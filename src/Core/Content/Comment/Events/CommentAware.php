<?php

namespace RustyMcFly\CommentCmsPage\Core\Content\Comment\Events;

use RustyMcFly\CommentCmsPage\Core\Content\Comment\CommentEntity;
use Shopware\Core\Content\Flow\Dispatching\Aware\ScalarValuesAware;
use Shopware\Core\Framework\Event\FlowEventAware;
use Shopware\Core\Framework\Event\MailAware;
use Shopware\Core\Framework\Event\SalesChannelAware;

interface CommentAware extends FlowEventAware, SalesChannelAware, MailAware, ScalarValuesAware
{
    const COMMENT = 'comment';
    const COMMENT_ID = 'commentId';

    public function getComment(): CommentEntity;

    public function getCommentId(): string;
}
