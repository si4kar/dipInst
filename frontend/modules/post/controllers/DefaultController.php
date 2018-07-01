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


    public function actionUpdate($id)
    {
        if ($comment = CommentForm::findComment($id)) {

            if ($comment->attributes = Yii::$app->request->post('Comments') && $comment->save()) {


                Yii::$app->session->setFlash('success', 'Comment update');
                return $this->redirect(['/post/default/view', 'id' => $comment->post_id]);

            }
            return $this->render('update', [
                'comment' => $comment,
            ]);
        }
        throw new NotFoundHttpException();
    }


    public function actionDelete($id)
    {
        if ($comment = CommentForm::findComment($id)) {
            $comment->delete();
            return $this->redirect(['/post/default/view', 'id' => $comment->post_id]);
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
}
