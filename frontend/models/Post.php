<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property string $filename
 * @property string $description
 * @property string $created_at
 * @property string $complaints
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'filename' => 'Filename',
            'description' => 'Description',
            'created_at' => 'Created At',
        ];
    }

    public function getImage()
    {
        return Yii::$app->storage->getFile($this->filename);
    }

    /**
     * Get autor of the post
     * @return User|null
     */

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Like current post by given user
     * @param \frontend\models\User $user
     */

    public function like(User $user)
    {
        /* @var $redis \yii\redis\Connection */
        $redis = Yii::$app->redis;
        $redis->sadd("post:{$this->getId()}:likes", $user->getId());
        $redis->sadd("user:{$user->getId()}:likes", $this->getId());
    }
   /**
     * Unlike current post by given user
     * @param \frontend\models\User $user
     */

    public function unLike(User $user)
    {
        /* @var $redis \yii\redis\Connection */
        $redis = Yii::$app->redis;
        $redis->srem("post:{$this->getId()}:likes", $user->getId());
        $redis->srem("user:{$user->getId()}:likes", $this->getId());
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function countLikes()
    {
        /* @var $redis \yii\redis\Connection */
        $redis = Yii::$app->redis;
        return $redis->scard("post:{$this->getId()}:likes");
    }

    public function isLikedBy(User $user)
    {
        /* @var $redis \yii\redis\Connection */
        $redis = Yii::$app->redis;
        return $redis->sismember("post:{$this->getId()}:likes", $user->getId());
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getPosts($id)
    {
        $order = ['created_at' => SORT_DESC];
        return static::find()->where(['user_id' => $id])->orderBy($order)->all();
    }

    /**
     * Add complain to post from given user
     * @param User $user
     * @return bool
     */
    public function complain(User $user)
    {
        /* @var $redis \yii\redis\Connection */
        $redis = Yii::$app->redis;
        $key = "post:{$this->getId()}:complaints";

        if (!$redis->sismember($key, $user->getId())) {
            $redis->sadd($key, $user->getId());
            $this->complaints++;
            return $this->save(false, ['complaints']);
        }
    }
}
