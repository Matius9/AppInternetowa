<?php

use Zend\Session\Storage\SessionArrayStorage;
use Zend\Session\Validator\RemoteAddr;
use Zend\Session\Validator\HttpUserAgent;

return [
    'session_config' => [
        'cookie_lifetime'     => 60*60*1,
        'gc_maxlifetime'      => 60*60*24*30,        
    ],
    'session_manager' => [
        'validators' => [
            RemoteAddr::class,
            HttpUserAgent::class,
        ]
    ],
    'session_storage' => [
        'type' => SessionArrayStorage::class
    ],
    'doctrine' => [
        'migrations_configuration' => [
            'orm_default' => [
                'directory' => 'data/Migrations',
                'name'      => 'Doctrine Database Migrations',
                'namespace' => 'Migrations',
                'table'     => 'migrations',
            ],
        ],
    ],
    'db' => [
        'driver' => 'Pdo',
        'dsn'    => 'mysql:dbname=internetowe;host=localhost;charset=utf8',
        'username' => 'root',
        'password' => '',
    ],
];
