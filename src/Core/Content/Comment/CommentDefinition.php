<?php declare(strict_types=1);

namespace RustyMcFly\CommentCmsPage\Core\Content\Comment;

use Shopware\Core\Content\Category\CategoryDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\DateField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\EmailField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\LongTextField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\System\SalesChannel\SalesChannelDefinition;

class CommentDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'comment';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return CommentEntity::class;
    }

    public function getCollectionClass(): string
    {
        return CommentCollection::class;
    }

    protected function defineFields(): FieldCollection
    {

        /**
         *
         * `id` BINARY(16) NOT NULL,
         * `email` VARCHAR(255) NOT NULL,
         * `email_verified_at` DATETIME(3) NOT NULL,
         * `email_verify_token` VARCHAR(255) NULL,
         * `comment` TEXT NOT NULL,
         * `firstName` TEXT NOT NULL,
         * `lastName` TEXT NOT NULL,
         * `active` TINYINT(1) COLLATE utf8mb4_unicode_ci default 0,
         */
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            (new EmailField('email', 'email'))->addFlags(new Required()),
            (new DateField('email_verified_at', 'emailVerifiedAt')),
            (new StringField('email_verify_token', 'emailVerifyToken'))->addFlags(new Required()),
            (new LongTextField('text', 'text'))->addFlags(new Required()),
            (new StringField('firstName', 'firstName'))->addFlags(new Required()),
            (new StringField('lastName', 'lastName'))->addFlags(new Required()),
            (new BoolField('active', 'active')),

            (new FkField('category_id', 'categoryId', CategoryDefinition::class))->addFlags(new Required()),
            (new ManyToOneAssociationField('category', 'category_id', CategoryDefinition::class, 'id')),

            (new FkField('sales_channel_id', 'salesChannelId', SalesChannelDefinition::class))->addFlags(new Required()),
            (new ManyToOneAssociationField('salesChannel', 'sales_channel_id', SalesChannelDefinition::class, 'id')),


            (new FkField('parent_id', 'parentId', CommentDefinition::class)),
            (new ManyToOneAssociationField('parent', 'parent_id', CommentDefinition::class, 'id')),
            (new OneToManyAssociationField('children', CommentDefinition::class, 'parent_id')),
        ]);
    }
}
