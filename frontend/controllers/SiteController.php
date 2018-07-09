<?php
namespace frontend\controllers;

use frontend\models\Feed;
use Yii;
use yii\web\Controller;
use frontend\models\User;
use yii\data\Pagination;
use yii\web\Cookie;
use yii\web\Response;


/**
 * Site controller
 */
class SiteController extends Controller
{
    const TYPE_ORDINARY_USER = null;

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/user/default/login');
        }
        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;

        $feedItems = $currentUser->getFeed();
        $pages = new Pagination(['totalCount' => $feedItems->count(), 'pageSize' => 5]);
        $feedItems = $feedItems->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', [
            'feedItems' => $feedItems,
            'currentUser' =>$currentUser,
            'pages' => $pages,
        ]);
    }

    public function actionUsers()
    {
        $usersList = User::find()->where(['type' => self::TYPE_ORDINARY_USER]);

        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;
        $pages = new Pagination(['totalCount' => $usersList->count(), 'pageSize' => 5]);

        return $this->render('users', [
            'usersList' => $usersList->offset($pages->offset)->limit($pages->limit)->all(),
            'currentUser' => $currentUser,
            'pages' => $pages,
        ]);
    }



    public function actionLanguage()
    {
        $language = Yii::$app->request->post('language');
        Yii::$app->language = $language;

        $languageCookie = new Cookie([
           'name' => 'language',
           'value' => $language,
           'expire' => time() + 60 * 60 * 24 *30,
        ]);

        Yii::$app->response->cookies->add($languageCookie);
        return $this->redirect(Yii::$app->request->referrer);
    }



}
