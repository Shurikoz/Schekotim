<?php
use kartik\mpdf\Pdf;


$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'name' => '«Щекотливая тема»',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['gii', 'debug'],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['*'],
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    /* 'userClassName' => 'app\models\User', */
                    'idField' => 'id',
                    'usernameField' => 'username',
                ],
            ],
            'layout' => 'left-menu',
            'mainLayout' => '@backend/views/layouts/main.php',
        ],
    ],
    'components' => [
        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'timeFormat' => 'H:i',
            'locale' => 'ru-RU',
            'timeZone' => 'UTC'

        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'mdm\admin\models\User',
            'loginUrl' => 'site/login',
            //'loginUrl' => 'admin/user/login',
            'enableAutoLogin' => false,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'authTimeout' => 7200
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => '',
            'rules' => [
                '<action:(index|review|login|request-password-reset|reset-password|support|policy)>' => 'site/<action>',
                '<action:(show|hide)>' => 'review/<action>',
                '<action:(tutorial)>' => 'pages/<action>',
                '<action:(notification|settings)>' => 'profile/<action>',
            ],

        ],
        'assetManager' => [
            'bundles' => [
                'language' => 'ru',
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => false // do not load bootstrap assets for a specific asset bundle
                ],
            ],
        ],
        'pdf' => [
            'class' => Pdf::classname(),
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            // refer settings section for all configuration options
        ]
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/login',
            'site/request-password-reset',
            'site/reset-password',
            'site/policy',
        ]
    ],
    'params' => $params,
];
