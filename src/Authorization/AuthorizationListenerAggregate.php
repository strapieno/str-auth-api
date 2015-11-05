<?php

namespace Strapieno\Auth\Api\Authorization;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use ZF\MvcAuth\Identity\IdentityInterface;
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
        $this->listeners[] = $events->attach(MvcAuthEvent::EVENT_AUTHORIZATION, [$this, 'loadAclMan'], 999);
    }

    public function loadAclMan(MvcAuthEvent $mvcAuthEvent)
    {
        $identity = $mvcAuthEvent->getIdentity();

        if (!$identity instanceof IdentityInterface) {
            return;
        }

        $serviceLocator = $mvcAuthEvent->getMvcEvent()->getApplication()->getServiceManager();
        $zfAuthorizationService = $serviceLocator->get('authorization');
        $aclManService = $serviceLocator->get('Strapieno\Auth\AclMan\Service');

        $aclManService->setAcl($zfAuthorizationService);
        $aclManService->loadResource($identity, $mvcAuthEvent->getResource());
    }
}