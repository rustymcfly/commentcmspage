<?php declare(strict_types=1);

namespace RustyMcFly\CommentCmsPage\ScheduledTask;

use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTask;

class DeleteUnverifiedComments extends ScheduledTask
{
    public static function getTaskName(): string
    {
        return 'comments.delete_unverified';
    }

    public static function getDefaultInterval(): int
    {
        return 300; // 5 minutes
    }
}
