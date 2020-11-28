<?php

$databaseUrl = getenv('DATABASE_URL');

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=' . parse_url($databaseUrl, PHP_URL_HOST) . ';port=' . parse_url($databaseUrl, PHP_URL_PORT) . ';dbname=' . parse_url($databaseUrl, PHP_URL_PATH),
            'username' => parse_url($databaseUrl, PHP_URL_USER),
            'password' => parse_url($databaseUrl, PHP_URL_PASS),
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
