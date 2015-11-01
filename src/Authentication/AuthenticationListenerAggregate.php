<?php

namespace Strapieno\Auth\Api\Authentication;

use Strapieno\Auth\Api\Identity\IdentityInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
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
        $this->listeners[] = $events->attach(MvcAuthEvent::EVENT_AUTHENTICATION_POST, [$this, 'loadObjectIdentity'], 100);
    }

    /**
     * @param MvcAuthEvent $mvcAuthEvent
     */
    public function loadObjectIdentity(MvcAuthEvent $mvcAuthEvent)
    {

        $identity = $mvcAuthEvent->getIdentity();
        if ($identity instanceof IdentityInterface) {
            $autheticateIdentity = $identity->getAuthenticationIdentity();
            if (!empty($autheticateIdentity['user_id'])) {
                // TODO recover user object
            } elseif (!empty($autheticateIdentity['client_id'])) {
                // TODO recover client object
            } else {
                // TODO Invalid identity
            }
        }

        $mvcAuthEvent->setIdentity($identity);
    }
}