<?php

namespace Strapieno\Auth\Api\Authorization;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;

/**
 * Class ListenerAggregate
 */
class ListenerAggregate implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
}