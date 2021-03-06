<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'language' => 'en-US',
    'bootstrap' => [
        'log',
        [
            'class' => 'frontend\components\LanguageSelector',
        ]
    ],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'user' => [
            'class' => 'frontend\modules\user\module',
        ],
        'post' => [
            'class' => 'frontend\modules\post\module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'frontend\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
            'rules' => [
                '/' => 'site/index',
                'profile/edit/<nickname:\w+>' => 'user/profile/edit_profile',
                'profile/<nickname:\w+>' => 'user/profile/view',
                'post/update/<id:\d+>' => 'post/default/update',
                'post/delete_comment/<id:\d+>' => 'post/default/delete_comment',
                'post/delete_post/<id:\d+>' => 'post/default/delete_post',
                'post/<id:\d+>' => 'post/default/view',
            ],
        ],

        'feedService' => [
            'class' => 'frontend\components\FeedService',
        ],
        'commentService' => [
            'class' => 'frontend\components\CommentService',
        ],

        'i18n' => [ //internationalization
            'translations' => [
              '*' => [
                'class' => 'yii\i18n\PhpMessageSource',
              ],
            ],
        ],


    ],
    'params' => $params,
];
