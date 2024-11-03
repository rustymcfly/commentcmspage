<?php

namespace RustyMcFly\CommentCmsPage\Core\Content\Comment\Events;


use RustyMcFly\CommentCmsPage\Core\Content\Comment\CommentDefinition;
use RustyMcFly\CommentCmsPage\Core\Content\Comment\CommentEntity;
use Shopware\Core\Content\Flow\Dispatching\Action\FlowMailVariables;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Event\EventData\EntityType;
use Shopware\Core\Framework\Event\EventData\EventDataCollection;
use Shopware\Core\Framework\Event\EventData\MailRecipientStruct;
use Shopware\Core\Framework\Event\EventData\ScalarValueType;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Contracts\EventDispatcher\Event;

class CommentCreatedEvent extends Event implements CommentAware
{
    const EVENT_NAME = 'comment.created';

    public function __construct(private readonly string $confirmUrl, private readonly CommentEntity $comment, private readonly SalesChannelContext $salesChannelContext, private ?MailRecipientStruct $mailRecipientStruct = null)
    {
    }

    public static function getAvailableData(): EventDataCollection
    {
        return (new EventDataCollection())
            ->add('comment', new EntityType(CommentDefinition::class))
            ->add('confirmUrl', new ScalarValueType(ScalarValueType::TYPE_STRING));
    }

    public function getName(): string
    {
        return self::EVENT_NAME;
    }

    public function getSalesChannelId(): string
    {
        return $this->salesChannelContext->getSalesChannel()->getId();
    }

    public function getContext(): Context
    {
        return $this->salesChannelContext->getContext();
    }

    public function getConfirmUrl(): string
    {
        return $this->confirmUrl;
    }

    public function getMailStruct(): MailRecipientStruct
    {
        if (!$this->mailRecipientStruct instanceof MailRecipientStruct) {
            $this->mailRecipientStruct = new MailRecipientStruct([
                $this->comment->getEmail() => $this->comment->getFirstName() . ' ' . $this->comment->getLastName(),
            ]);
        }
        return $this->mailRecipientStruct;
    }

    /**
     * @return array<string, scalar|array<mixed>|null>
     */
    public function getValues(): array
    {
        return [FlowMailVariables::CONFIRM_URL => $this->confirmUrl];
    }

    public function getComment(): CommentEntity
    {
        return $this->comment;
    }

    public function getCommentId(): string
    {
        return $this->comment->getId();
    }
}
