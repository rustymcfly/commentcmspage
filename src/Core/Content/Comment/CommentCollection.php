<?php declare(strict_types=1);

namespace RustyMcFly\CommentCmsPage\Core\Content\Comment;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void add(CommentEntity $entity)
 * @method void set(string $key, CommentEntity $entity)
 * @method CommentEntity[] getIterator()
 * @method CommentEntity[] getElements()
 * @method CommentEntity|null get(string $key)
 * @method CommentEntity|null first()
 * @method CommentEntity|null last()
 */
class CommentCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return CommentEntity::class;
    }
}
