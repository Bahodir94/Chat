<?php

return [
    'login' => [
        'type' => 2,
    ],
    'logout' => [
        'type' => 2,
    ],
    'signup' => [
        'type' => 2,
    ],
    'change-password' => [
        'type' => 2,
    ],
    'request-password-reset' => [
        'type' => 2,
    ],
    'reset-password' => [
        'type' => 2,
    ],
    'users' => [
        'type' => 2,
    ],
    'incorrect-messages' => [
        'type' => 2,
    ],
    'spam-message' => [
        'type' => 2,
    ],
    'change-role' => [
        'type' => 2,
    ],
    'error' => [
        'type' => 2,
    ],
    'index' => [
        'type' => 2,
    ],
    'post' => [
        'type' => 2,
    ],
    'guest' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'login',
            'logout',
            'error',
            'signup',
            'index',
            'reset-password',
            'request-password-reset',
        ],
    ],
    'user' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'post',
            'change-password',
            'guest',
        ],
    ],
    'admin' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'users',
            'spam-message',
            'change-role',
            'user',
            'incorrect-messages',
            'guest',
        ],
    ],
];
