<?php
namespace Strapieno\Auth\Api;


use Strapieno\Auth\Api\Authentication\AuthenticationListenerAggregate;
use Zend\ModuleManager\Feature\HydratorProviderInterface;
use Zend\ModuleManager\Feature\InputFilterProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ArrayUtils;

/**
 * Class Module
 */
class Module implements HydratorProviderInterface, InputFilterProviderInterface
{
    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/',
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getHydratorConfig()
    {
        return include __DIR__ . '/config/hydrator.config.php';
    }


    /**
     * {@inheritdoc}
     */
    public function getInputFilterConfig()
    {
        return include __DIR__ . '/config/input-filter.config.php';
    }

    /**
     * @param MvcEvent $e
     * @throws RuntimeException
     */
    public function onBootstrap(MvcEvent $e)
    {
        /** @var $events EventManagerInterface */
        $events = $e->getApplication()->getEventManager();
        $events->attachAggregate(new AuthenticationListenerAggregate());
    }
}
