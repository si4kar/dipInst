<?php

/* @var $this yii\web\View */
/* @var $post frontend\models\Post*/
/* @var $comment \frontend\modules\post\models\forms\CommentForm*/
/* @var $username frontend\models\Post*/

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Comments;
use yii\helpers\HTMLPurifier;
use yii\helpers\Url;
?>

<div class="post-default-index">

    <div class="row">

        <div class="col-md-12">
            <?php if ($post->user): ?>
                <?php echo 'Autor: '  . $post->user->username; ?>
            <?php endif; ?>
        </div>

        <div class="col-md-12">
            <img src="<?php echo $post->getImage(); ?>" >
        </div>

        <div class="col-md-12">
            <?php echo 'Description: ' . Html::encode($post->description); ?>
        </div>
    </div>

    <hr>

    <div class="col-md-12">
        Likes: <span class="likes-count"><?php echo $post->countLikes(); ?></span>
        <?php if ($currentUser && $post->isLikedBy($currentUser)): ?>
            <a href="#" class="btn btn-primary button-like" style="display: none" data-id="<?php echo $post->id; ?>">
                Like&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
            </a>

            <a href="#" class="btn btn-primary button-unlike" data-id="<?php echo $post->id; ?>">
                Unlike&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
            </a>

        <?php else: ?>
            <a href="#" class="btn btn-primary button-like" data-id="<?php echo $post->id; ?>">
                Like&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
            </a>

            <a href="#" class="btn btn-primary button-unlike" style="display: none" data-id="<?php echo $post->id; ?>">
                Unlike&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
            </a>

        <?php endif; ?>

    </div>

    <hr>

    <!--Show comments-->
    <div class="col-md-12">

        <h3>Comments:</h3>
        <?php $comments = Comments::getComment($post->id); ?>

        <?php foreach ($comments as $current_comment): ?>
            <h5><?php echo HTMLPurifier::process($current_comment->description); ?></h5>
            <p>
                <?php echo '<b>Author: </b>' . Comments::getCommentAuthor($current_comment->user_id); ?>
                <?php echo '<b>Date: </b>' . date('m.d.Y H:i:s', $current_comment->created_at); ?>
            </p>
            <a href="<?php Url::to(['/post/update', 'id' => $current_comment->id]) ?>" class="btn btn-default">Edit</a>

        <?php endforeach; ?>

    </div>

    <hr>
    <!--Add new comment-->
    <?php if ($currentUser): ?>
        <div class="col-md-12">
            <h3>Create comment</h3>
            <?php $form = ActiveForm::begin(); ?>
            <?php echo $form->field($comment, 'description')->textarea()->label('Comment'); ?>
            <?php echo $form->field($comment, 'post_id')->hiddenInput(['value' => $post->id])->label(false); ?>

            <?php echo Html::submitButton('Create', ['class' => 'btn btn-primary button-sendComment']); ?>

            <?php ActiveForm::end(); ?>

        </div>

    <?php endif; ?>




</div>


<?php $this->registerJsFile('@web/js/likes.js', [
    'depends' => \yii\web\JqueryAsset::className(),
]);