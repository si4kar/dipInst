<?php

/* @var $this yii\web\View */
/* @var $user frontend\models\User */
/* @var $currentUser frontend\models\User */
use yii\helpers\Html;
use yii\helpers\HTMLPurifier;
use yii\helpers\Url;
?>

<h3><?php echo Html::encode($user->username); ?></h3>
<p><?php echo HTMLPurifier::process($user->about); ?> page!</p>

<a href="<?php echo Url::to(['/user/profile/subscribe', 'id' => $user->getId()]);?>" class="btn btn-info">Subscribe</a>
<a href="<?php echo Url::to(['/user/profile/unsubscribe', 'id' => $user->getId()]);?>" class="btn btn-info">Unsubscribe</a>

<hr>

<h5>Friends, who are also following <?php echo Html::encode($user->username);?>:</h5>
<div class="row">
    <?php foreach ($currentUser->getMuturalSubscriptionsTo($user) as $item): ?>
        <div class="col-md-12">
            <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($item['nickname']) ? ($item['nickname']) : ($item['id'])]);?>">
                <?php echo Html::encode($item['username']); ?>
            </a>
        </div>
    <?php endforeach; ?>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#subscriptions">
    Subscriptions: <?php echo $user->countSubscriptions(); ?>
</button>

<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#followers">
    Followers: <?php echo $user->countFollowers(); ?>
</button>

<!-- Modal subscriptions-->
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

<!-- Modal followers-->
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

