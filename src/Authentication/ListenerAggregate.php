<?php

namespace Strapieno\Auth\Api\Authentication;

use Zend\EventManager\ListenerAggregateInterface;

/**
 * Class ListenerAggregate
 */
class ListenerAggregate implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
}