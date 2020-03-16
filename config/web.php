<?php

$params = require(__DIR__ . '/params.php');
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => '<i class="fa fa-university"></i> <span>MEPB</span>',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'profile/index',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'EmeB7V67mEvKhcW1_fuq2lxzSdGft0BC',
            'parsers' => [
                 'application/json' => 'yii\web\JsonParser',
             ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            // 'identityClass' => 'dektrium\user\models\User',
            'enableAutoLogin' => true,
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/dektrium',
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'user/login' => 'site/login'
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:d M Y',
            'datetimeFormat' => 'php:d M Y H:i:s',
            'timeFormat' => 'php:H:i:s',
            'locale' => 'ind-id', //your language locale
            'defaultTimeZone' => 'Asia/Jakarta', // time zone
            'timeZone' => 'Asia/Jakarta',
            'decimalSeparator' => ',',
            'thousandSeparator' => '.',
            'currencyCode' => 'IDR',
        ],
        'assetManager' => [
            'bundles' => [
                'dosamigos\google\maps\MapAsset' => [
                    'options' => [
                        'key' => 'AIzaSyD_Zi42hif-HM8iaG92u2rU0_0N-56uM7o',
                        'language' => 'id',
                        'version' => '3.1.18'
                    ]
                ]
            ]
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // only support DbManager
            'defaultRoles' => ['Guest'],
        ],
        // 'authClientCollection' => [
        //     'class' => 'yii\authclient\Collection',
        //     'clients' => [
        //         'dapobud' => [
        //             'class' => 'app\clients\Dapobud',
        //             'authUrl' => 'http://sso.dapobud.bukapeta.com/oauth2/authorize',
        //             'tokenUrl' => 'http://sso.dapobud.bukapeta.com/oauth2/token',
        //             'apiBaseUrl' => 'http://sso.dapobud.bukapeta.com/oauth2',
        //             'returnUrl' => 'http://localhost:8083/auth/index?authclient=dapobud',
        //             'clientId' => 'penggiatlokal',
        //             'clientSecret' => 'penggiatlokal',
        //         ],
        //     ],
        // ]
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'gii/*',
            'rbac/*',
            'site/*',
            // 'admin/*',
            'v1/*',
            'provinsi/*',
            'kabupatenkota/*',
            'kecamatan/*',
            'location/*',
            'user/*',
            'manual-entry/*',
            'gridview/*',
            'export/*',
        ]
    ],
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
            // enter optional module parameters below - only if you need to  
            // use your own export download action or custom translation 
            // message source
            'downloadAction' => 'export/download',
            // 'i18n' => []
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
        ],
        'v1' => [
            'class' => 'app\modules\api\v1\Module',
        ],
        'social' => [
            // the module class
            'class' => 'kartik\social\Module',
            // the global settings for the twitter plugins widget
            'twitter' => [
                'screenName' => 'budayasaya',
            ],
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'enableConfirmation' => false,
            'enableRegistration' => false,
            'enablePasswordRecovery' => false,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['admin@localhost.dev'],
            // 'adminPermission' => 'SuperAdmin',
            'modelMap' => [
                'User' => 'app\models\User',
                'Profile' => 'app\models\Profile',
            ],
            'controllerMap' => [
                'security' => 'app\controllers\user\SecurityController'
            ],
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
