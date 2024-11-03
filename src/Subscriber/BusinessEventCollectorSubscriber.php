<?php

namespace RustyMcFly\CommentCmsPage\Subscriber;

use RustyMcFly\CommentCmsPage\Core\Content\Comment\Events\CommentCreatedEvent;
use RustyMcFly\CommentCmsPage\Core\Content\Comment\Events\CommentVerifiedEvent;
use Shopware\Core\Framework\Event\BusinessEventCollector;
use Shopware\Core\Framework\Event\BusinessEventCollectorEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BusinessEventCollectorSubscriber implements EventSubscriberInterface
{

    public function __construct(private readonly BusinessEventCollector $collector)
    {
    }

    public function collectEvents(BusinessEventCollectorEvent $event)
    {
        $event->getCollection()->add($this->collector->define(CommentCreatedEvent::class, CommentCreatedEvent::EVENT_NAME));
        $event->getCollection()->add($this->collector->define(CommentVerifiedEvent::class, CommentVerifiedEvent::EVENT_NAME));
    }


    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            BusinessEventCollectorEvent::NAME => 'collectEvents',
        ];
    }
}
