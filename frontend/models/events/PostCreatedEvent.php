<?php

namespace frontend\models\events;

use yii\base\Event;
use frontend\models\Post;
use frontend\models\User;

class PostCreatedEvent extends Event
{

    public $user;
    public $post;

    public function getUser(): User
    {
        return $this->user;
    }

    public function getPost(): Post
    {
        return $this->post;
    }

}