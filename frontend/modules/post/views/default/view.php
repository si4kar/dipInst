<?php

/* @var $this yii\web\View */
/* @var $post frontend\models\Post*/

use yii\helpers\Html;

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

</div>


<?php $this->registerJsFile('@web/js/likes.js', [
    'depends' => \yii\web\JqueryAsset::className(),
]);