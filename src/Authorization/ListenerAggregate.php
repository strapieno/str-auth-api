<?php

namespace Strapieno\Auth\Api\Authorization;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;

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
        $this->listeners[] = $events->attach(MvcAuthEvent::EVENT_AUTHORIZATION, [$this, 'loadAclMan']);
    }

    public function loadAclMan()
    {

    }
}