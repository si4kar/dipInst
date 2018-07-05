<?php
namespace frontend\models\events;

use frontend\models\Comments;
use yii\base\Event;

class CommentCreatedEvent extends Event
{

    public $comment;
   /* public $post;*/

    public function getComment(): Comments
    {
        return $this->comment;
    }


}