<?php

namespace frontend\components;

use yii\base\Application;
use yii\base\BootstrapInterface;

class LanguageSelector implements  BootstrapInterface
{

    public $supportLanguages = ['en-US', 'ru-RU'];


    public function bootstrap($app)
    {
        $cookieLanguage = $app->request->cookies['language'];

        if (isset($cookieLanguage) && in_array($cookieLanguage, $this->supportLanguages)) {
            $app->language = $app->request->cookies['language'];
        }
    }
}