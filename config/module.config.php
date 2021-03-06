<?php

return [
    // Register aclman services
    'service_manager' => [
        'abstract_factories' => [
            'AclMan\Service\ServiceFactory',
            'AclMan\Storage\StorageFactory',
        ],
        'factories' => [
            'Strapieno\Utils\Listener\ListenerManager' => 'Strapieno\Utils\Listener\ListenerManagerFactory',
            'AclMan\Assertion\AssertionManager' => 'AclMan\Assertion\AssertionManagerFactory'
        ],
        'invokables' => [
            'Strapieno\Utils\Delegator\AttachListenerDelegator' =>  'Strapieno\Utils\Delegator\AttachListenerDelegator'
        ],
        'aliases' => [
            'listenerManager' => 'Strapieno\Utils\Listener\ListenerManager'
        ],
        'delegators' => [
            'Application' => [
                'Strapieno\Utils\Delegator\AttachListenerDelegator',
            ]
        ]
    ],
    'service-listeners' => [
        'invokables' => [
            'Strapieno\Auth\Api\Authorization\AuthorizationListenerAggregate' => 'Strapieno\Auth\Api\Authorization\AuthorizationListenerAggregate',
        ]
    ],
    'attach-listeners' => [
        'Application' => [
            'Strapieno\Auth\Api\Authorization\AuthorizationListenerAggregate'
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
        'storage' => 'Strapieno\Auth\Model\OAuth2\StorageAdapter',
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
                // Default allow all resource
                \AclMan\Storage\StorageInterface::ALL_ROLES => [
                    'resources' => [
                        \AclMan\Storage\StorageInterface::ALL_RESOURCES => [
                            [
                                'allow' => true
                            ]
                        ],
                    ]
                ]
            ]
        ]
    ],
    'router' => [
        'routes' => [
            'api-rest' => [
                'child_routes' => [
                    'oauth-client' => [
                        'type' => 'Segment',
                        'may_terminate' => true,
                        'options' => [
                            'route' => '/oauth-client[/:client_id]',
                            'defaults' => [
                                'controller' => 'Strapieno\OauthClient\Api\V1\Rest\Controller'
                            ],
                            'constraints' => [
                                'client_id' => '[0-9a-f]{24}'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
    'matryoshka-apigility' => [
        'matryoshka-connected' => [
            'Strapieno\OauthClient\Api\V1\Rest\ConnectedResource' => [
                'model' => 'Strapieno\Auth\Model\OauthClientModelService',
                'prototype_strategy' => 'Matryoshka\Model\Object\PrototypeStrategy\ServiceLocatorStrategy',
                'collection_criteria' => 'Strapieno\Auth\Model\Criteria\OauthClientCollectionCriteria',
                'entity_criteria' => 'Strapieno\Model\Criteria\NotIsolatedActiveRecordCriteria'
            ]
        ]
    ],
    'zf-rest' => [
        'Strapieno\OauthClient\Api\V1\Rest\Controller' => [
            'service_name' => 'oauth-client',
            'listener' => 'Strapieno\OauthClient\Api\V1\Rest\ConnectedResource',
            'route_name' => 'api-rest/oauth-client',
            'route_identifier_name' => 'client_id',
            'collection_name' => 'oauth-clients',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                'order_by',
            ],
            'page_size' => 10,
            'page_size_param' => 'page_size',
            'collection_class' => 'Zend\Paginator\Paginator', // FIXME function?
        ]
    ],
    'zf-content-negotiation' => [
        'accept_whitelist' => [
            'Strapieno\OauthClient\Api\V1\Rest\Controller' => [
                'application/hal+json',
                'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Strapieno\OauthClient\Api\V1\Rest\Controller' => [
                'application/json'
            ],
        ],
    ],
    'zf-hal' => [
        // map each class (by name) to their metadata mappings
        'metadata_map' => [
            'Strapieno\Auth\Model\Entity\OauthClientEntity' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api-rest/oauth-client',
                'route_identifier_name' => 'client_id',
                'hydrator' => 'OauthClientApiHydrator',
            ],
        ],
    ],
    'zf-content-validation' => [
        'Strapieno\OauthClient\Api\V1\Rest\Controller' => [
            'input_filter' => 'Strapieno\Auth\Model\InputFilter\DefaultInputFilter',
            'POST' => 'Strapieno\Auth\Model\InputFilter\PostInputFilter'
        ]
    ],
    'strapieno_input_filter_specs' => [
        'Strapieno\Auth\Model\InputFilter\PostInputFilter' => [
            'merge' => 'Strapieno\Auth\Model\InputFilter\DefaultInputFilter',
            'client_id' => [
                'name' => 'client_id',
                'require' => false,
                'allow_empty' => true
            ],
            'type' => [
                'name' => 'type',
                'require' => true,
                'allow_empty' => false
            ]
        ]
    ]
];

