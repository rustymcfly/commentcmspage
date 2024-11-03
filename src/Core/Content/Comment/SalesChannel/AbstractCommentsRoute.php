<?php declare(strict_types=1);

namespace RustyMcFly\CommentCmsPage\Core\Content\Comment\SalesChannel;

use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

abstract class AbstractCommentsRoute
{
    abstract public function getDecorated(): AbstractCommentsRoute;

    abstract public function load(Criteria $criteria, SalesChannelContext $context): CommentsRouteResponse;
}
