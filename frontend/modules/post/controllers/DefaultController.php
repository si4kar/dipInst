<?php

namespace frontend\modules\post\controllers;

use frontend\models\Comments;
use frontend\models\Post;
use frontend\models\User;
use frontend\modules\post\models\forms\CommentForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use frontend\modules\post\models\forms\PostForm;

/**
 * Default controller for the `post` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionCreate()
    {

        if (Yii::$app->user->isGuest) {
            return $this->redirect('/user/default/login ');
        }

        $model = new PostForm(Yii::$app->user->identity);

        if ($model->load(Yii::$app->request->post())) {
            $model->picture = UploadedFile::getInstance($model, 'picture');

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Post send');

                return $this->goHome();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Renders the create view for the module
     * @return string
     */
    public function actionView($id)
    {
        $currentUser = Yii::$app->user->identity;
        $comment = new CommentForm();

        if ($comment->load(Yii::$app->request->post()) && $comment->save()) {
            Yii::$app->session->setFlash('success', 'Comment add');

        }

        return $this->render('view', [
            'post' => $this->findPost($id),
            'currentUser' => $currentUser,
            'comment' => $comment,

        ]);
    }

    /**
     * Update current comment
     * @param $id
     * @return string
     */
    public function actionUpdate($id)
    {
        $comment = new CommentForm();

        if ($commentOld = $comment->findComment($id)) {
            if (Yii::$app->request->post('Comments')) {
                $arr = Yii::$app->request->post('Comments');
                $commentOld->description = $arr['description'];

                if($commentOld->save()) {
                    Yii::$app->session->setFlash('success', 'Comment update');
                    return $this->redirect(['/post/default/view', 'id' => $commentOld->post_id]);
                }
            }

        }
        return $this->render('update', [
            'commentOld' => $commentOld,
        ]);


    }

    /**
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $comment = new CommentForm();
        if ($post_id = $comment->deleteFromRedis($id)) {

            return $this->redirect(['/post/default/view', 'id' => $post_id]);
        }
        throw new NotFoundHttpException();
    }

    /**
     * @param $id
     * @return User
     * @throws NotFoundHttpException
     */
    private function findPost($id)
    {

        if ($user = Post::findOne($id)) {
            return $user;
        }

        throw new NotFoundHttpException();
    }

    public function actionLike()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $post = $this->findPost($id);
        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;

        $post->like($currentUser);


        return [
            'success' => true,
            'likesCount' => $post->countLikes(),
        ];
    }

    public function actionUnlike()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $post = $this->findPost($id);
        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;

        $post->unLike($currentUser);


        return [
            'success' => true,
            'likesCount' => $post->countLikes(),
        ];
    }

    public function actionComplain()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');

        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;
        $post = $this->findPost($id);

        if ($post->complain($currentUser)) {
            return  [
                'success' => true,
                'text' => 'Post reported'
            ];
        }

        return [
            'success' => false,
            'text' => 'Error',
        ];

    }
}
