<?php declare(strict_types=1);

namespace RustyMcFly\CommentCmsPage\Core\Content\Comment\SalesChannel;

use RustyMcFly\CommentCmsPage\Core\Content\Comment\CommentCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Shopware\Core\System\SalesChannel\StoreApiResponse;

/**
 * @property EntitySearchResult $object
 */
class CommentsRouteResponse extends StoreApiResponse
{
    public function getComments(): CommentCollection
    {
        $collection = $this->object->getEntities();
        return $collection;
    }
}
