<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'on beforeRequest' => function ($event) {
        $lang_saved = null;
        if (true){
            # use cookie to store language
            $lang_saved = Yii::$app->request->cookies->get('language');
        }else{
            # use session to store language
            $lang_saved = Yii::$app->session['language'];
        }
        $lang = ($lang_saved) ? $lang_saved : 'en-US';

        Yii::$app->sourceLanguage = 'en-US';
        Yii::$app->language = $lang;
        return; 
    },
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'jd-yG6gI7NGa__Z3h9haqftihmf7xvBn',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
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
            'flushInterval' => 1,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['trace', 'warning'],
                    'categories' => ['yii\*'],
                    'exportInterval' => 1,
                    'logFile' => '@app/runtime/logs/app.log',
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['error'],
                    'levels' => ['error'],
                    'exportInterval' => 1,
                    'logFile' => '@app/runtime/logs/error.log',
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        
        'urlManager' => [
            'enablePrettyUrl' => true,
           	'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
                 ['class' => 'yii\rest\UrlRule', 'controller' => ['avatar']]
            ],
        ],

        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    // 'language' => 'zh-CN',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                    ],
                ],
            ],
        ],
        
    ],

    'modules' => [
       'treemanager' =>  [
            'class' => '\kartik\tree\Module',
            // other module settings, refer detailed documentation
            'treeStructure' => [
                'treeAttribute' => 'root',
                'leftAttribute' => 'lft',
                'rightAttribute' => 'rgt',
                'depthAttribute' => 'lvl',
            ],
        ],
        'markdown' => [
            'class' => 'kartik\markdown\Module',
            'smarty' => function($module) {
                if (\Yii::$app->user->can('smarty')) {
                    if(\Yii::$app->user->can('smartyYiiApp'))
                        $module->smartyYiiApp=true;
                    else
                        $module->smartyYiiApp=false;
                    if(\Yii::$app->user->can('smartyYiiParams'))
                        $module->smartyYiiParams=true;
                    else
                        $module->smartyYiiParams=false;
                    return true;
                }
                return false;
            },
            'smartyPants' => true,
            // 'i18n' => [
            //     'class' => 'yii\i18n\PhpMessageSource',
            //     'basePath' => '@markdown/messages',
            //     'forceTranslation' => true
            // ],
        ]
    ],


    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
