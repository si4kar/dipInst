<?php

namespace frontend\modules\post\models\forms;


use frontend\models\events\CommentCreatedEvent;
use Yii;
use yii\base\Model;
use frontend\models\Comments;

class CommentForm extends Model
{
    const MAX_DESCRIPTION_LENGTH = 1000;
    const EVENT_COMMENT_CREATED = 'comment_created';
    const EVENT_COMMENT_DELETED = 'comment_deleted';

    public $description;
    public $post_id;
    public $id;

    private $user;

    public function rules()
    {
        return [
            [['description'], 'string', 'max' => self::MAX_DESCRIPTION_LENGTH],
            [['post_id'], 'integer'],

        ];
    }

    public function __construct()
    {
        $this->user = Yii::$app->user->identity;
        $this->on(self::EVENT_COMMENT_CREATED, [Yii::$app->commentService, 'addToComments']);
        $this->on(self::EVENT_COMMENT_DELETED, [Yii::$app->commentService, 'deleteToComments']);
    }

    public function save()
    {
        if ($this->validate()) {
            $comment = new Comments();
            $comment->description = $this->description;
            $comment->created_at = time();
            $comment->post_id = intval($this->post_id);
            $comment->user_id = $this->user->getId();

            if ($comment->save(false)) {
                $event = new CommentCreatedEvent();
                $event->comment = $comment;
                $this->trigger(self::EVENT_COMMENT_CREATED, $event);

                return true;
            };
        }
        return false;
    }

    /**
     * @param $id
     * @return  int post_id
     */
    public function deleteFromRedis($id)
    {
        $comment = $this->findComment($id);
        if($comment->delete()) {
            $event = new CommentCreatedEvent();
            $event->comment = $comment;

            $this->trigger(self::EVENT_COMMENT_DELETED, $event);
            return $comment->post_id;
        }

        return false;
    }

    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findComment($id)
    {
        return Comments::find()->where(['id' => $id])->one();
    }




}