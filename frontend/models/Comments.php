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

    /**
     * @param $id
     * @return array
     */
    public static function getComments($id)
    {
        return static::findAll(['post_id' => $id]);
    }

    /**
     * @param $id
     * @return string
     */
    public static function getCommentAuthor($id)
    {
        if($user = User::findIdentity($id)) {
            return $user->username;
        }
    }





}
