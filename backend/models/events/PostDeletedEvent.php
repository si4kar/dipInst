<?php
namespace backend\models\events;

use backend\models\Post;
use yii\base\Event;

class PostDeletedEvent extends Event
{

    public $post;

    public function getPost(): Post
    {
        return $this->post;
    }


}