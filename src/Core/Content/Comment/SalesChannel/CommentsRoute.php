<?php declare(strict_types=1);

namespace RustyMcFly\CommentCmsPage\Core\Content\Comment\SalesChannel;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Plugin\Exception\DecorationPatternException;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\Routing\Attribute\Route;

#[Route(defaults: ['_routeScope' => ['store-api']])]
class CommentsRoute extends AbstractCommentsRoute
{
    public function __construct(private readonly EntityRepository $productRepository)
    {
    }

    public function getDecorated(): AbstractCommentsRoute
    {
        throw new DecorationPatternException(self::class);
    }

    #[Route(
        path: '/store-api/comments',
        name: 'store-api.comments.search',
        methods: ['GET', 'POST']
    )]
    public function load(Criteria $criteria, SalesChannelContext $context): CommentsRouteResponse
    {
        return new CommentsRouteResponse($this->productRepository->search($criteria, $context->getContext()));
    }
}
