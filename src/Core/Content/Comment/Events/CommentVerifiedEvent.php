<?php

namespace RustyMcFly\CommentCmsPage\Core\Content\Comment\Events;

use RustyMcFly\CommentCmsPage\Core\Content\Comment\CommentDefinition;
use RustyMcFly\CommentCmsPage\Core\Content\Comment\CommentEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Event\EventData\EntityType;
use Shopware\Core\Framework\Event\EventData\EventDataCollection;
use Shopware\Core\Framework\Event\EventData\MailRecipientStruct;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Contracts\EventDispatcher\Event;

class CommentVerifiedEvent extends Event implements CommentAware
{

    const EVENT_NAME = 'comment.verified';

    public function __construct(private readonly SalesChannelContext $salesChannelContext, private readonly CommentEntity $comment, private ?MailRecipientStruct $mailRecipientStruct = null)
    {
    }

    public static function getAvailableData(): EventDataCollection
    {
        return (new EventDataCollection())->add('comment', new EntityType(CommentDefinition::class));
    }


    public function getName(): string
    {
        return self::EVENT_NAME;
    }

    public function getMailStruct(): MailRecipientStruct
    {
        $array = [];
        if ($this->mailRecipientStruct instanceof MailRecipientStruct) {
            $array = $this->mailRecipientStruct->getRecipients();
        }
        $this->mailRecipientStruct = new MailRecipientStruct(array_merge($array, [
            $this->comment->getEmail() => $this->comment->getFirstName() . ' ' . $this->comment->getLastName(),
        ]));

        return $this->mailRecipientStruct;
    }

    public function getSalesChannelId(): string
    {
        return $this->salesChannelContext->getSalesChannel()->getId();
    }

    public function getContext(): Context
    {
        return $this->salesChannelContext->getContext();
    }

    public function getComment(): CommentEntity
    {
        return $this->comment;
    }

    public function getCommentId(): string
    {
        return $this->comment->getId();
    }

    public function getConfirmUrl(): string
    {
        return '';
    }
}
