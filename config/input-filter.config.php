<?php
return [
    'invokables' => [
        'Strapieno\Auth\Api\V1\InputFilter\InputFilter' => 'Strapieno\Auth\Api\V1\InputFilter\InputFilter',
        'Strapieno\Auth\Api\V1\InputFilter\PostInputFilter' => 'Strapieno\Auth\Api\V1\InputFilter\PostInputFilter'
    ],
    'aliases' => [
        'OauthClientInputFilter' => 'Strapieno\Auth\Api\V1\InputFilter\InputFilter',
        'OauthClientPosInputFilter' => 'Strapieno\Auth\Api\V1\InputFilter\PostInputFilter'
    ]
];