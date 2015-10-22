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
        'options' => [
            'always_issue_new_refresh_token' => true, // zf2 default is false
            // 'refresh_token_lifetime' => (default is 1209600, equal to 14 days)
        ],
    ],
];

