<?php


/* @var $this yii\web\View */
/* @var $user frontend\modules\user\controllers\ProfileController*/
/* @var $currentUser frontend\modules\user\controllers\ProfileController*/
/* @var $modelPicture frontend\modules\user\controllers\ProfileController*/
/* @var $model frontend\modules\user\controllers\ProfileController*/

use yii\helpers\Html;
use dosamigos\fileupload\FileUpload;
use yii\helpers\HTMLPurifier;
use yii\widgets\ActiveForm;

$this->title = "Edit profile " . Html::encode($user->username);
?>

<div class="page-posts no-padding">
    <div class="row">
        <div class="page page-post col-sm-12 col-xs-12 post-82">
            <div class="blog-posts blog-posts-large">
                <div class="row">
                    <!-- profile -->
                    <article class="profile col-sm-12 col-xs-12">
                        <div class="profile-title">
                            <img src="<?php echo $user->getPicture(); ?>" class="author-image" id="profile-picture"/>
                            <div class="author-name"><?php echo Html::encode($user->username); ?></div>
                            <?php if ($currentUser && $currentUser->equals($user)): ?>

                                <!--widget to upload avatar photo-->
                                <?= FileUpload::widget([
                                    'model' => $modelPicture,
                                    'attribute' => 'picture',
                                    'url' => ['/user/profile/upload-picture'], // your url, this is just for demo purposes,
                                    'options' => ['accept' => 'image/*'],
                                    'clientEvents' => [
                                        'fileuploaddone' => 'function(e, data) {
                                     if (data.result.success) {
                                            $("#profile-image-success").show();
                                            $("#profile-image-fail").hide();
                                            $("#profile-picture").attr("src", data.result.pictureUri);
                                        } else {
                                            $("#profile-image-fail").html(data.result.errors.picture).show();
                                            $("#profile-image-success").hide();
                                        }
                                    }',
                                    ],
                                ]); ?>
                            <?php endif; ?>
                            <br>
                            <div class="alert alert-success" style="display: none" id="profile-image-success">
                                Profile image updated
                            </div>
                            <div class="alert alert-danger" style="display: none" id="profile-image-fail"></div>
                        </div>
                    </article>

                    <article class="profile col-sm-12 col-xs-12">

                        <?php $form = ActiveForm::begin(); ?>
                        <?php echo $form->field($model, 'username', array())->textInput(['value' => $user->username])->label('user name'); ?>
                        <?php echo $form->field($model, 'nickname', array())->textInput(['value' => $user->nickname])->label('user nickname'); ?>
                        <?php echo $form->field($model, 'about', array())->textarea(['value' => $user->about])->label('info about me'); ?>

                        <?php /*echo $form->field($model, 'picture')->fileInput(); */?><!--
                        --><?php /*echo $form->field($model, 'description'); */?>
                        <?php echo Html::a('Back', ['/user/profile/view', 'nickname' => $user->nickname], ['class' => 'btn btn-default']); ?>
                        <?php echo Html::submitButton('Update', ['class' => 'btn btn-primary']); ?>

                        <?php ActiveForm::end(); ?>
                    </article>
                </div>

            </div>
        </div>

    </div>
</div>



