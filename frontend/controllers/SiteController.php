<?php
namespace frontend\controllers;

use frontend\models\Feed;
use Yii;
use yii\web\Controller;
use frontend\models\User;
use yii\data\Pagination;


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

        $limit = Yii::$app->params['feedPostLimit'];

        /*$feedItems = $currentUser->getFeed($limit);*/
        $posts = Feed::find()->where(['user_id' => $currentUser->getId()])->orderBy(['post_created_at' => SORT_DESC]);
        $pages = new Pagination(['totalCount' => $posts->count(), 'pageSize' => 5]);
        $feedItems = $posts->offset($pages->offset)->limit($pages->limit)->all();


        return $this->render('index', [
            'feedItems' => $feedItems,
            'currentUser' =>$currentUser,
            'pages' => $pages,
        ]);
    }


}
