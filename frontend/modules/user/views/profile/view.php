<?php

/* @var $this yii\web\View */
/* @var $user frontend\models\User */
/* @var $currentUser frontend\models\User */
/* @var $modelPicture frontend\modules\user\models\forms\PictureForm */

use yii\helpers\Html;
use yii\helpers\HTMLPurifier;
use yii\helpers\Url;
use dosamigos\fileupload\FileUpload;
?>



<h3><?php echo Html::encode($user->username); ?></h3>
<p><?php echo HTMLPurifier::process($user->about); ?> page!</p>

<img src="<?php echo $user->getPicture(); ?>" id="profile-picture" alt="user logo">

<?php if ($currentUser && $currentUser->equals($user)): ?>



    <div class="alert alert-success" style="display: none" id="profile-image-success">Profile image updated</div>
    <div class="alert alert-danger" style="display: none" id="profile-image-fail"></div>

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

    <a href="<?php echo Url::to(['/user/profile/delete-picture']); ?>" class="btn btn-danger">Delete picture</a>

<?php else: ?>
    <!--Buttons for subscribe and unsubscribe-->
    <?php if ($currentUser && !$user->equals($currentUser)): ?>
        <hr>
        <?php if (!$currentUser->isFollowing($user)): ?>
            <a href="<?php echo Url::to(['/user/profile/subscribe', 'id' => $user->getId()]); ?>" class="btn btn-info">Subscribe</a>
        <?php else: ?>
            <a href="<?php echo Url::to(['/user/profile/unsubscribe', 'id' => $user->getId()]); ?>"
               class="btn btn-info">Unsubscribe</a>
        <?php endif; ?>

        <!--Show people, who are following you-->
        <?php if ($muturalSubscriptions = $currentUser->getMuturalSubscriptionsTo($user)): ?>
            <hr>
            <h5>Friends, who are also following <?php echo Html::encode($user->username); ?>:</h5>
            <div class="row">
                <?php foreach ($muturalSubscriptions as $item): ?>
                    <div class="col-md-12">
                        <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($item['nickname']) ? ($item['nickname']) : ($item['id'])]); ?>">
                            <?php echo Html::encode($item['username']); ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

<?php endif; ?>
<hr>


<!-- Button to show your subscriptions and followers -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#subscriptions">
    Subscriptions: <?php echo $user->countSubscriptions(); ?>
</button>

<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#followers">
    Followers: <?php echo $user->countFollowers(); ?>
</button>

<!-- Modal window subscriptions-->
<div class="modal fade" id="subscriptions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Subscriptions</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php foreach ($user->getSubscriptions() as $subscription): ?>
                        <div class="col-md=12">
                            <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($subscription['nickname']) ? ($subscription['nickname']) : ($subscription['id']) ]);?>">
                                <?php echo Html::encode($subscription['username']); ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal window followers-->
<div class="modal fade" id="followers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Followers</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php foreach ($user->getFollowers() as $follower): ?>
                        <div class="col-md=12">
                            <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($follower['nickname']) ? ($follower['nickname']) : ($follower['id']) ]);?>">
                                <?php echo Html::encode($follower['username']); ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

