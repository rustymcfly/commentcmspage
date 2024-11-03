<?php

namespace RustyMcFly\CommentCmsPage\Core\Content\Category;

use RustyMcFly\CommentCmsPage\Core\Content\Comment\CommentDefinition;
use Shopware\Core\Content\Category\CategoryDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class CommentsExtension extends EntityExtension
{

    /**
     * @inheritDoc
     */
    public function getDefinitionClass(): string
    {
        return CategoryDefinition::class;
    }

    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(new OneToManyAssociationField('comments', CommentDefinition::class, 'category_id', 'id'));
    }
}
