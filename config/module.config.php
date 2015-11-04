<?php

return [
    // Register aclman services
    'service_manager' => [
        'abstract_factories' => [
            'AclMan\Service\ServiceFactory',
            'AclMan\Storage\StorageFactory',
        ],
        'factories' => [
            'AclMan\Assertion\AssertionManager' => 'AclMan\Assertion\AssertionManagerFactory'
        ]
    ],
    'aclman_services' => [
        'Strapieno\Auth\AclMan\Service' => [
            'storage' => 'Strapieno\Auth\AclMan\Storage',
            'plugin_manager' => 'AclMan\Assertion\AssertionManager',
            'allow_not_found_resource' => false,
        ],
    ],
    'zf-oauth2' => [
        // https://apigility.org/documentation/auth/authentication-oauth2
        'storage' => 'Strapieno\Auth\Model\OAuth2\Adapter\MongoAdapter',
        'mongo' => [
            'database' => 'strapieno',
        ],
        'storage_settings' => [
            'client_table'          => 'oauth_client',
            'access_token_table'    => 'oauth_access_token',
            'refresh_token_table'   => 'oauth_refresh_token',
            'code_table'            => 'oauth_authorization_code',
            'user_table'            => 'user', // TODO recover from use service from factory
            'jwt_table'             => 'oauth_jwt',
        ]
    ],
    'aclman_storage' => [
        'Strapieno\Auth\AclMan\Storage' => [
            'roles' => [
                // TODO remove
                'superadmin' => [
                    'resources' => [
                        \AclMan\Storage\StorageInterface::ALL_RESOURCES => [
                            [
                                'allow' => true
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];

