<?php

namespace Strapieno\Auth\Api\Authentication;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use ZF\MvcAuth\MvcAuthEvent;

/**
 * Class ListenerAggregate
 */
class AuthenticationListenerAggregate implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * {@inheritdoc}
     */
    public function attach(EventManagerInterface $events)
    {
        // TODO controll priority
        $this->listeners[] = $events->attach(MvcAuthEvent::EVENT_AUTHENTICATION_POST, [$this, 'loadObjectIdentity'], 100);
    }

    /**
     * @param MvcAuthEvent $mvcAuthEvent
     */
    public function loadObjectIdentity(MvcAuthEvent $mvcAuthEvent)
    {
        $identity = $mvcAuthEvent->getIdentity();
        if ($identity instanceof GuestIdentity) {
            return;
        }
        var_dump($identity);
        die();
    }
}