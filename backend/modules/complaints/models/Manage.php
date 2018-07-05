<?php

namespace backend\modules\complaints\models;


use backend\models\events\PostDeletedEvent;
use Yii;
use yii\base\Model;
use backend\models\Post;
use yii\web\NotFoundHttpException;
use backend\models\Feed;

class Manage extends Model
{

    const EVENT_POST_DELETED = 'post_deleted';

    public function __construct()
    {
        $this->on(self::EVENT_POST_DELETED, [Yii::$app->postService, 'deletePost']);
    }



    /**
     * @param $id
     * @return  int post_id
     */
    public function deletePost($id)
    {
        $post = $this->findModel($id);
        $this->findModel($id)->delete();
        $this->deleteFeeds($post->id);

        $event = new PostDeletedEvent();
        $event->post = $post;

        $this->trigger(self::EVENT_POST_DELETED, $event);
        return true;

    }

    public function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function deleteFeeds($id)
    {
        Feed::deleteAll(['post_id' => $id]);
    }


}