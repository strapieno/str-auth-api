<?php

namespace Strapieno\Auth\Api\Authorization;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use ZF\MvcAuth\MvcAuthEvent;

/**
 * Class ListenerAggregate
 */
class AuthorizationListenerAggregate implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * {@inheritdoc}
     */
    public function attach(EventManagerInterface $events)
    {
        // TODO add priority
        $this->listeners[] = $events->attach(MvcAuthEvent::EVENT_AUTHORIZATION, [$this, 'loadAclMan'], 100);
    }

    public function loadAclMan(MvcAuthEvent $mvcAuthEvent)
    {
        // TODO
    }
}