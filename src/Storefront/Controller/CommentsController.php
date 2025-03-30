<?php declare(strict_types=1);

namespace RustyMcFly\CommentCmsPage\Storefront\Controller;

use RustyMcFly\CommentCmsPage\Core\Content\Comment\Events\CommentCreatedEvent;
use RustyMcFly\CommentCmsPage\Core\Content\Comment\Events\CommentVerifiedEvent;
use RustyMcFly\CommentCmsPage\Core\Content\Comment\SalesChannel\AbstractCommentsRoute;
use Shopware\Core\Content\Category\Exception\CategoryNotFoundException;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Util\Random;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Core\Framework\Validation\DataValidationFactoryInterface;
use Shopware\Core\Framework\Validation\DataValidator;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[Route(defaults: ['_routeScope' => ['storefront']])]
class CommentsController extends StorefrontController
{

    public function __construct(
        private readonly EntityRepository               $commentRepository,
        private readonly AbstractCommentsRoute          $commentsRoute,
        private readonly EventDispatcherInterface       $eventDispatcher,
        private readonly DataValidationFactoryInterface $commentValidationFactory,
        private readonly DataValidator                  $validator
    )
    {
    }

    #[Route(
        path: '/comments/{categoryId}',
        name: 'frontend.comments.get',
        methods: ['GET']
    )]
    public function getComments(Request $request, SalesChannelContext $context): Response
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('categoryId', $request->get('categoryId')));
        $criteria->addFilter(new EqualsFilter('parentId', null));
        return $this->renderStorefront('@CommentCmsPage/storefront/element/cms-element-comments.html.twig', [
            'comments' => $this->commentsRoute->load($criteria, $context),
            "page" => [
                "navigationId" => $request->get('categoryId'),
            ]
        ]);
    }


    #[Route(
        path: '/comments/{categoryId}',
        name: 'frontend.comments.post',
        methods: ['POST']
    )]
    public function postComment(Request $request, RequestDataBag $data, SalesChannelContext $context): Response
    {

        $definition = $this->commentValidationFactory->create($context);
        $violations = $this->validator->getViolations($data->all(), $definition);
        if ($violations->count() > 0) {
            $this->addFlash(self::DANGER, $this->trans('plugin.RustyMcFly.CommentCmsPage.form-errors'));
            return $this->redirectToRoute('frontend.navigation.page', ['navigationId' => $request->get('categoryId')]);
        }

        $token = Random::getAlphanumericString(32);
        $payload = [
            'id' => Uuid::randomHex(),
            'categoryId' => $request->get('categoryId'),
            'text' => $data->get('text'),
            'firstName' => $data->get('firstName'),
            'lastName' => $data->get('lastName'),
            'email' => $data->get('email'),
            'emailVerifyToken' => $token,
            'salesChannelId' => $context->getSalesChannelId(),
        ];

        if ($data->has('parentId') && $data->get('parentId')) {
            $payload['parentId'] = $data->get('parentId');
        }
        $this->commentRepository->create([$payload], $context->getContext());
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('categoryId', $request->get('categoryId')));
        $criteria->addFilter(new EqualsFilter('emailVerifyToken', $token));
        $comments = $this->commentsRoute->load($criteria, $context);
        $event = new CommentCreatedEvent($this->generateUrl('frontend.comments.verify', ["emailVerifyToken" => $token], UrlGeneratorInterface::ABSOLUTE_URL), $comments->getComments()->first(), $context);
        $this->eventDispatcher->dispatch($event);
        $this->addFlash(self::SUCCESS, $this->trans('plugin.RustyMcFly.CommentCmsPage.verifyYourEmail'));
        return $this->redirectToRoute('frontend.navigation.page', ['navigationId' => $request->get('categoryId')]);
    }

    #[Route(
        path: '/comments/verify/{emailVerifyToken}',
        name: 'frontend.comments.verify',
        methods: ['GET']
    )]
    public function verifyComment(Request $request, SalesChannelContext $context): Response
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('emailVerifyToken', $request->get('emailVerifyToken')));
        $comments = $this->commentsRoute->load($criteria, $context);

        if ($comments->getComments()->count() === 0) {
            throw new CategoryNotFoundException($request->get('emailVerifyToken'));
        }

        $comment = $comments->getComments()->first();

        $this->commentRepository->update([[
            "id" => $comment->getId(),
            "emailVerifiedAt" => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT)
        ]], $context->getContext());

        $event = new CommentVerifiedEvent($context, $comments->getComments()->first());
        $this->eventDispatcher->dispatch($event);

        $this->addFlash(self::SUCCESS, $this->trans('plugin.RustyMcFly.CommentCmsPage.emailVerified'));

        return $this->redirectToRoute('frontend.navigation.page', ["navigationId" => $comment->getCategoryId(), "commentId" => $comment->getId()]);

    }
}
