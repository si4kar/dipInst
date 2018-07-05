<?php

namespace backend\modules\complaints\controllers;

use backend\modules\compaints\models\ManagePost;
use Yii;
use backend\models\Post;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\complaints\models\Manage;

/**
 * ManageController implements the CRUD actions for Post model.
 */
class ManageController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Post::findComplaints(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
              return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
      /*  $post_id = $this->findModel($id);


        return $this->redirect(['index']);*/

        $post = new Manage();
        if ($post_id = $post->findModel($id)) {
            $post->deletePost($post_id->id);
            return $this->redirect(['index']);
        }
        throw new NotFoundHttpException();

    }

    /**
     * Approve post action
     * @param $id
     * @return mixed
     */
    public function actionApprove($id)
    {
        $post = $this->findModel($id);
        if ($post->approve()) {
            Yii::$app->session->setFlash('success', 'post approved');
            return $this->redirect(['index']);
        }
    }

    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



}
