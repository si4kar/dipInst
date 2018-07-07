<?php

/* @var $commentOld \frontend\modules\post\models\forms\Manage*/

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="post-default-update">
    <h1>Update comment</h1>
    <?php $form = ActiveForm::begin(); ?>
    <?php echo $form->field($commentOld, 'description')->textarea()->label('Comment'); ?>
    <?php echo Html::submitButton('Update', ['class' => 'btn btn-primary']); ?>

    <?php ActiveForm::end(); ?>

</div>
