<?php

/* @var $this yii\web\View */
/* @var $user frontend\models\User */
/* @var $currentUser frontend\models\User */
/* @var $postItems[] frontend\models\Feed */
/* @var $modelPicture frontend\modules\user\controllers\ProfileController */

use yii\helpers\Html;
use yii\helpers\HTMLPurifier;
use yii\helpers\Url;
use dosamigos\fileupload\FileUpload;

$this->title = Html::encode($user->username);
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
                                <a href="<?php echo Url::to(['/user/profile/edit_profile', 'nickname' => $currentUser->getNickname()])?>" class="btn btn-default">Edit profile</a>
                            <?php endif; ?>
                        </div>

                        <?php if ($user->about): ?>
                        <div class="profile-description">
                            <p><?php echo HTMLPurifier::process($user->about); ?></p>
                        </div>
                            <hr>
                        <?php endif; ?>

                        <!--If show another user profile add button subscribe and unsubscribe-->
                        <?php if ($currentUser && !$user->equals($currentUser)): ?>
                            <br>
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
                            <hr>
                        <?php endif; ?>

                        <div class="profile-bottom">
                            <div class="profile-post-count">
                                <span><?php echo $user->getPostCount(); ?> posts</span>
                            </div>
                            <div class="profile-followers">
                                <a href="#" data-toggle="modal" data-target="#followers"> <?php echo $user->countFollowers(); ?> followers</a>
                            </div>
                            <div class="profile-following">
                                <a href="#" data-toggle="modal" data-target="#subscriptions"> <?php echo $user->countSubscriptions(); ?> following</a>
                            </div>
                        </div>
                    </article>

                    <div class="col-sm-12 col-xs-12">
                        <div class="row profile-posts">
                            <?php foreach ($user->getPosts() as $post): ?>
                            <div class="col-md-4 profile-post">
                                <a href="<?php echo Url::to(['/post/default/view', 'id' => $post->id]); ?>">
                                    <img src="<?php echo Yii::$app->storage->getFile($post->filename)?>" class="author-image" />
                                </a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>


                </div>

            </div>
        </div>

    </div>
</div>

<!-- Modal window subscriptions-->
<div class="modal fade" id="subscriptions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Subscriptions</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php foreach ($user->getSubscriptions() as $subscription): ?>
                        <div class="col-md=12">
                            <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($subscription['nickname']) ? ($subscription['nickname']) : ($subscription['id'])]); ?>">
                                &nbsp;  <?php echo Html::encode($subscription['username']); ?>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Followers</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php foreach ($user->getFollowers() as $follower): ?>
                        <div class="col-md=12">
                            <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($follower['nickname']) ? ($follower['nickname']) : ($follower['id'])]); ?>">
                               &nbsp; <?php echo Html::encode($follower['username']); ?>
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


