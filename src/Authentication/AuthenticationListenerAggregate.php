<?php

namespace Strapieno\Auth\Api\Authentication;

use Matryoshka\Model\ModelManager;
use Strapieno\Auth\Api\Identity\AuthenticatedIdentity;
use Strapieno\Auth\Api\OAuth2\Adapter\MongoAdapter;
use Strapieno\Auth\Model\OAuth2\AdapterInterface;
use Strapieno\Auth\Model\OauthClientModelInterface;
use Strapieno\User\Model\UserModelInterface;
use Strapieno\User\Model\UserModelService;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\MvcAuth\Identity\GuestIdentity;
use ZF\MvcAuth\Identity\IdentityInterface;
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

        if ($identity instanceof GuestIdentity) {
            return;
        }

        if ($identity instanceof IdentityInterface) {
            $autheticateIdentity = $identity->getAuthenticationIdentity();
            if (!empty($autheticateIdentity['user_id'])) {
                $sm = $mvcAuthEvent->getMvcEvent()->getApplication()->getServiceManager();
                if ($sm->has('Strapieno\Auth\Model\OAuth2\StorageAdapter')
                    && ($adapter = $sm->get('Strapieno\Auth\Model\OAuth2\StorageAdapter'))
                    && !($adapter instanceof AdapterInterface)
                ) {
                    // TODO Exception
                }
                /** @var $userService UserModelInterface */
                $userService = $sm->get(ModelManager::class)->get(UserModelService::class);
                $result = $userService->getAuthenticationUser(
                    $adapter->getIdentityField(),
                    $autheticateIdentity['user_id']
                );

                if ($result->count() != 1) {
                    // TODO exception
                }
                $identity = new AuthenticatedIdentity($autheticateIdentity);
                $identity->setAuthenticationObject($result->current());
                $identity->setName($autheticateIdentity['user_id']);
            } elseif (!empty($autheticateIdentity['client_id'])) {
                $sm = $mvcAuthEvent->getMvcEvent()->getApplication()->getServiceManager();
                /** @var $oauthClientService  OauthClientModelInterface */
                $oauthClientService = $sm->get(ModelManager::class)->get('Strapieno\Auth\Model\OauthClientModelService');
                $result = $oauthClientService->getAuthenticationClient($autheticateIdentity);
            } else {
                return new ApiProblemResponse(new ApiProblem(401, 'Unknown identity type'));
            }
        }

        $mvcAuthEvent->setIdentity($identity);
    }
}