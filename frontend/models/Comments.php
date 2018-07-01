<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property string $description
 * @property int $created_at
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'user_id' => 'User ID',
            'description' => 'Description',
            'created_at' => 'Created At',
        ];
    }

    public static function getComment($id)
    {
        return static::findAll(['post_id' => $id]);
    }

    public static function getCommentAuthor($id)
    {
        if($user = User::findIdentity($id)) {
            return $user->username;
        }
    }




}
