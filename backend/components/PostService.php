<?php

namespace backend\components;

use Yii;
use yii\base\Component;
use yii\base\Event;

class PostService extends Component
{


    public function deletePost(Event $event)
    {
        $post = $event->getPost();
        /* @var $redis \yii\redis\Connection */
        $redis = Yii::$app->redis;
        $redis->del("post:{$post->id}:likes");
        $redis->del("post:{$post->id}:complaints");

    }


}