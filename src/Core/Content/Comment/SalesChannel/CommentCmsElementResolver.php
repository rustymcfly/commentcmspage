<?php

namespace RustyMcFly\CommentCmsPage\Core\Content\Comment\SalesChannel;

use RustyMcFly\CommentCmsPage\Core\Content\Comment\CommentDefinition;
use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\DataResolver\CriteriaCollection;
use Shopware\Core\Content\Cms\DataResolver\Element\AbstractCmsElementResolver;
use Shopware\Core\Content\Cms\DataResolver\Element\ElementDataCollection;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\EntityResolverContext;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\NotFilter;

class CommentCmsElementResolver extends AbstractCmsElementResolver
{

    public function getType(): string
    {
        return 'comments';
    }

    public function collect(CmsSlotEntity $slot, ResolverContext $resolverContext): ?CriteriaCollection
    {
        $criteriaCollection = new CriteriaCollection();
        if($resolverContext instanceof EntityResolverContext) {
            $criteria = new Criteria();
            $criteria->addFilter(new EqualsFilter('categoryId', $resolverContext->getEntity()->getId()));
            $criteria->addFilter(new EqualsFilter('parentId', null));
            $criteria->addAssociation('children');
            $this->filter($criteria->getAssociation('children'));
            $this->filter($criteria);
            $criteriaCollection->add($slot->getUniqueIdentifier() . $slot->getType(), CommentDefinition::class, $criteria);
        }
        return $criteriaCollection;
    }

    private function filter(Criteria $criteria): void
    {
        $criteria->addFilter(new EqualsFilter('active', true));
        $criteria->addFilter(new NotFilter('and', [new EqualsFilter('emailVerifiedAt', null)]));

    }

    public function enrich(CmsSlotEntity $slot, ResolverContext $resolverContext, ElementDataCollection $result): void
    {
        $slot->setData($result->get($slot->getUniqueIdentifier() . $slot->getType())->getEntities());
    }
}
