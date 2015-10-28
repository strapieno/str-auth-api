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
        $adapeter = new MongoAdapter($this->getMongoDb($services), $this->getOauth2ServerConfig($config));

        if ($config['zf-oauth2']['identity_field']) {
            $adapeter->setIdentityField($config['zf-oauth2']['identity_field');
        }

        if ($config['zf-oauth2']['password_crypt']) {
            $adapeter->setIdentityField($config['zf-oauth2']['password_crypt');
        }

        return $adapter;
    }
}