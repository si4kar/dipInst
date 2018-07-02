<?php
namespace frontend\models\events;

use frontend\models\Comments;
use yii\base\Event;
use frontend\models\Post;

class CommentCreatedEvent extends Event
{

    public $comment;
   /* public $post;*/

    public function getComment(): Comments
    {
        return $this->comment;
    }

  /*  public function getPost(): Post
    {
        return $this->post;
    }*/

}