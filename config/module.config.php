<?php

return [
    // Register aclman services
    'service_manager' => [
        'abstract_factories' => [
            'AclMan\Service\ServiceFactory',
            'AclMan\Storage\StorageFactory',
        ],
        'factories' => [
            'AclMan\Assertion\AssertionManager' => 'AclMan\Assertion\AssertionManagerFactory',
            'Strapieno\Auth\Api\OAuth2\Adapter\MongoAdapter' => 'Strapieno\Auth\Api\OAuth2\Adapter\MongoAdapterFactory',
        ]
    ],
    'aclman_services' => [
        'Strapieno\Auth\AclMan\Service' => [
            'storage' => 'Strapieno\Auth\AclMan\Storage',
            'plugin_manager' => 'AclMan\Assertion\AssertionManager',
            'allow_not_found_resource' => false,
        ],
    ],
    'aclman_storage' => [
        'Strapieno\Auth\AclMan\Storage' => [],
    ],
    'zf-oauth2' => [
        // https://apigility.org/documentation/auth/authentication-oauth2
        'storage' => 'Strapieno\Auth\Api\OAuth2\Adapter\MongoAdapter',
        'mongo' => [
            'database' => 'strapieno',
        ],
    ],
];

