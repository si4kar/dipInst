<?php

namespace frontend\components;

use Yii;
use frontend\models\Comments;
use yii\base\Component;
use yii\base\Event;
use frontend\models\Post;

class CommentService extends Component
{
    public function addToComments(Event $event)
    {
        $comment = $event->getComment();
        /* @var $redis \yii\redis\Connection */
        $redis = Yii::$app->redis;
        $redis->sadd("post:{$comment->post_id}:comments", $comment->id);

    }

    public function deleteToComments(Event $event)
    {
        $comment = $event->getComment();
        /* @var $redis \yii\redis\Connection */
        $redis = Yii::$app->redis;
        $redis->srem("post:{$comment->post_id}:comments", $comment->id);

    }
}