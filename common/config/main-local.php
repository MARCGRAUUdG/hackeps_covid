<?php

$databaseUrl = getenv('DATABASE_URL');

$db = [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=ec2-176-34-114-78.eu-west-1.compute.amazonaws.com;port=5432;dbname=dcf38c794fhvt',
    'username' => 'zbbazyuwnzklay',
    'password' => '93a64910af71a8ca5466d91c341befcc9821a733212516de78761e7e3bb7db3c',
    'charset' => 'utf8',
];

if ($databaseUrl)
{
    $db['dsn'] = 'pgsql:host=' . parse_url($databaseUrl, PHP_URL_HOST) . ';port=' . parse_url($databaseUrl, PHP_URL_PORT) . ';dbname=' . substr(parse_url($databaseUrl, PHP_URL_PATH), 1);
    $db['username'] = parse_url($databaseUrl, PHP_URL_USER);
    $db['password'] = parse_url($databaseUrl, PHP_URL_PASS);
}

return [
    'components' => [
        'db' => $db,
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
];
