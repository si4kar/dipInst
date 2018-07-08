<?php

namespace frontend\modules\user\models\forms;

use Yii;
use Intervention\Image\ImageManager;
use yii\base\Model;
use frontend\models\User;

class UserForm extends Model
{
    const MAX_USERNAME_LENGTH = 50;
    const MAX_NICKNAME_LENGTH = 20;
    const MAX_ABOUT_LENGTH = 2000;

    public $username;
    public $nickname;
    public $about;

    private $user;

    public function rules()
    {
        return [
            [['username'], 'string', 'max' => self::MAX_ABOUT_LENGTH],
            [['nickname'], 'string', 'max' => self::MAX_ABOUT_LENGTH],
            [['about'], 'string', 'max' => self::MAX_ABOUT_LENGTH],
        ];
    }

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function save()
    {
        if ($this->validate()) {
            $this->user->username = $this->username;
            $this->user->nickname = $this->nickname;
            $this->user->about = $this->about;
            $this->user->updated_at = time();
            if ($this->user->update(true)) {
                return true;
            }
        }
        return false;
    }


}