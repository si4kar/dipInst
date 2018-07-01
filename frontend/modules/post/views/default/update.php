<?php

/* @var $comment \frontend\modules\post\controllers\DefaultController*/

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="post-default-update">
    <h1>Update comment</h1>
    <?php $form = ActiveForm::begin(); ?>
    <?php echo $form->field($comment, 'description')->textarea()->label('Comment'); ?>
    <?php echo $form->field($comment, 'post_id')->hiddenInput(['value' => $comment->post_id])->label(false); ?>
    <?php echo Html::submitButton('Update', ['class' => 'btn btn-primary']); ?>

    <?php ActiveForm::end(); ?>

</div>
