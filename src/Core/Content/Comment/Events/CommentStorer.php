<?php

namespace RustyMcFly\CommentCmsPage\Core\Content\Comment\Events;

use Psr\EventDispatcher\EventDispatcherInterface;
use RustyMcFly\CommentCmsPage\Core\Content\Comment\CommentDefinition;
use RustyMcFly\CommentCmsPage\Core\Content\Comment\CommentEntity;
use Shopware\Core\Content\Flow\Dispatching\StorableFlow;
use Shopware\Core\Content\Flow\Dispatching\Storer\FlowStorer;
use Shopware\Core\Content\Flow\Events\BeforeLoadStorableFlowDataEvent;
use Shopware\Core\Content\MailTemplate\Exception\MailEventConfigurationException;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Event\EventData\MailRecipientStruct;
use Shopware\Core\Framework\Event\FlowEventAware;
use Shopware\Core\Framework\Event\MailAware;

class CommentStorer extends FlowStorer
{

    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly EntityRepository         $commentRepository
    )
    {
    }

    /**
     * @param array<string, mixed> $stored
     *
     * @return array<string, mixed>
     */
    public function store(FlowEventAware $event, array $stored): array
    {
        if (!$event instanceof CommentAware) {
            return $stored;
        }

        if (!isset($stored[MailAware::MAIL_STRUCT])) {
            try {
                $mailStruct = $event->getMailStruct();
                $data = [
                    'recipients' => $mailStruct->getRecipients(),
                    'bcc' => $mailStruct->getBcc(),
                    'cc' => $mailStruct->getCc(),
                ];

                $stored[MailAware::MAIL_STRUCT] = $data;
            } catch (MailEventConfigurationException) {
            }
        }

        if (isset($stored[CommentAware::COMMENT_ID])) {
            return $stored;
        }

        $stored[MailAware::SALES_CHANNEL_ID] = $event->getSalesChannelId();
        $stored[CommentAware::COMMENT_ID] = $event->getCommentId();
        $stored[CommentAware::COMMENT] = $event->getComment();

        return $stored;
    }

    public function restore(StorableFlow $storable): void
    {

        if (!$storable->hasStore(CommentAware::COMMENT_ID)) {
            return;
        }

        $storable->setData(CommentAware::COMMENT_ID, $storable->getStore(CommentAware::COMMENT_ID));

        $storable->lazy(
            CommentAware::COMMENT,
            $this->lazyLoad(...)
        );

        if ($storable->hasStore(MailAware::MAIL_STRUCT)) {
            $this->restoreMailStore($storable);
        }
    }


    private function lazyLoad(StorableFlow $storableFlow): ?CommentEntity
    {
        $id = $storableFlow->getStore(CommentAware::COMMENT_ID);
        if ($id === null) {
            return null;
        }

        $criteria = new Criteria([$id]);

        return $this->loadComment($criteria, $storableFlow->getContext(), $id);
    }

    private function loadComment(Criteria $criteria, Context $context, string $id): ?CommentEntity
    {
        $criteria->addAssociation('category');
        $criteria->addAssociation('parent');

        $event = new BeforeLoadStorableFlowDataEvent(
            CommentDefinition::ENTITY_NAME,
            $criteria,
            $context,
        );

        $this->eventDispatcher->dispatch($event, $event->getName());

        $comment = $this->commentRepository->search($criteria, $context)->get($id);

        if ($comment) {
            /** @var CommentEntity $comment */
            return $comment;
        }

        return null;
    }


    private function restoreMailStore(StorableFlow $storable): void
    {
        $mailStructData = $storable->getStore(MailAware::MAIL_STRUCT);

        $mailStruct = new MailRecipientStruct($mailStructData['recipients'] ?? []);
        $mailStruct->setBcc($mailStructData['bcc'] ?? null);
        $mailStruct->setCc($mailStructData['cc'] ?? null);

        $storable->setData(MailAware::SALES_CHANNEL_ID, $storable->getStore(MailAware::SALES_CHANNEL_ID));
        $storable->setData(MailAware::MAIL_STRUCT, $mailStruct);
    }

}
