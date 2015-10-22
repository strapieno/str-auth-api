<?php

namespace Strapieno\Auth\Api\OAuth2\Adapter;

use Zend\ServiceManager\FactoryInterface;
use ZF\OAuth2\Factory\MongoAdapterFactory as ZfCampusMongoAdapterFactory;

/**
 * Class MongoAdapterFactory
 */
class MongoAdapterFactory extends ZfCampusMongoAdapterFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return MongoAdapter
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $config  = $services->get('Config');
        return new MongoAdapter($this->getMongoDb($services), $this->getOauth2ServerConfig($config));
    }
}