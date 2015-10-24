<?php

namespace Strapieno\Auth\Api\Authentication;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use ZF\MvcAuth\MvcAuthEvent;

/**
 * Class ListenerAggregate
 */
class ListenerAggregate implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * {@inheritdoc}
     */
    public function attach(EventManagerInterface $events)
    {
        // TODO add priority
        $this->listeners[] = $events->attach(MvcAuthEvent::EVENT_AUTHENTICATION_POST, [$this, 'loadObjectIdentity'], 100);
    }


    public function loadObjectIdentity()
    {

    }
}