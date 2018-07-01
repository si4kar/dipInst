<?php

namespace frontend\modules\post\models\forms;


use Yii;
use yii\base\Model;
use frontend\models\Comments;
use frontend\models\User;

class CommentForm extends Model
{
    const MAX_DESCRIPTION_LENGTH = 1000;

    public $description;
    public $post_id;

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
    }

    public function save()
    {
        $currentUser = Yii::$app->user->identity;
        if ($this->validate()) {
            $comment = new Comments();
            $comment->description = $this->description;
            $comment->created_at = time();
            $comment->post_id = intval($this->post_id);
            $comment->user_id = $this->user->getId();

            return $comment->save(false);
        }
    }


}