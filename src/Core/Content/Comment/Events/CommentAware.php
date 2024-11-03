<?php

namespace RustyMcFly\CommentCmsPage\Core\Content\Comment\Events;

use RustyMcFly\CommentCmsPage\Core\Content\Comment\CommentEntity;
use Shopware\Core\Content\Flow\Dispatching\Aware\ConfirmUrlAware;
use Shopware\Core\Framework\Event\MailAware;
use Shopware\Core\Framework\Event\SalesChannelAware;

interface CommentAware extends SalesChannelAware, MailAware, ConfirmUrlAware
{
    const COMMENT = 'comment';
    const COMMENT_ID = 'commentId';

    public function getComment(): CommentEntity;

    public function getCommentId(): string;
}
