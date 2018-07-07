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

    public function actionSearch($term)
    {
        $currentUser = Yii::$app->user->identity;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $rs = Feed::find()->andWhere(['like', 'post_description', 'da'])->andWhere(['user_id' => $currentUser->getId()])->all();

        if ($rs != null) {
            $row_set = [];
            foreach ($rs as $row) {
                $row_set[] = $row->post_description; //build an array
            }
            return $row_set;
        }

        return false;

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
