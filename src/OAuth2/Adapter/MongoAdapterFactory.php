<?php

namespace Strapieno\Auth\Api\OAuth2\Adapter;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
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
        $adapter = new MongoAdapter($this->getMongoDb($services), $this->getOauth2ServerConfig($config));

        if (isset($config['zf-oauth2']['storage_settings']['identity_field'])) {
            $adapter->setIdentityField($config['zf-oauth2']['storage_settings']['identity_field']);
        }

        if (isset($config['zf-oauth2']['storage_settings']['password_crypt'])) {
            $adapter->setIdentityField($config['zf-oauth2']['storage_settings']['password_crypt']);
        }

        return $adapter;
    }
}