<?php

use console\controllers\ParserController;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'controllerMap' => [
        'parser' => [
            'class' => ParserController::class,
            'apacheLogsDir' => '/Users/dmitry/Projects/logsParser/console/runtime/apache-logs',
            'logFormat' => '%h %l %u %t \"%r\" %>s %b \"%{Referer}i\" \"%{User-agent}i\"',
            'logFileMasks' => ['access*.log']
        ]
    ],
    'params' => $params,
];
