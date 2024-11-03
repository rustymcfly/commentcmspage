<?php

namespace RustyMcFly\CommentCmsPage\Core\Validation;

use Shopware\Core\Framework\Validation\BuildValidationEvent;
use Shopware\Core\Framework\Validation\DataBag\DataBag;
use Shopware\Core\Framework\Validation\DataValidationDefinition;
use Shopware\Core\Framework\Validation\DataValidationFactoryInterface;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class CommentFormValidationFactory implements DataValidationFactoryInterface
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher,
    )
    {
    }


    /**
     * The regex to check if string contains an url
     */
    final public const DOMAIN_NAME_REGEX = '/((https?:\/))/';


    public function create(SalesChannelContext $context): DataValidationDefinition
    {
        return $this->createCommentFormValidation('comment_form.create', $context);
    }

    public function update(SalesChannelContext $context): DataValidationDefinition
    {
        return $this->createCommentFormValidation('comment_form.update', $context);
    }

    private function createCommentFormValidation(string $validationName, SalesChannelContext $context): DataValidationDefinition
    {
        $definition = new DataValidationDefinition($validationName);

        $definition
            ->add('email', new NotBlank(), new Email())
            ->add('text', new NotBlank(), new Regex(['pattern' => self::DOMAIN_NAME_REGEX, 'match' => false]))
            ->add('firstName', new NotBlank(), new Regex(['pattern' => self::DOMAIN_NAME_REGEX, 'match' => false]))
            ->add('lastName', new NotBlank(), new Regex(['pattern' => self::DOMAIN_NAME_REGEX, 'match' => false]));


        $validationEvent = new BuildValidationEvent($definition, new DataBag(), $context->getContext());
        $this->eventDispatcher->dispatch($validationEvent, $validationEvent->getName());

        return $definition;
    }

}
