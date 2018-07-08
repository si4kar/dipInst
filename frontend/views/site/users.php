<?php

/* @var $this yii\web\View */
/* @var $usersList [] frontend\controller\SiteController */
/* @var $currentUser [] frontend\controller\SiteController */

use yii\helpers\Html;
use yii\helpers\HTMLPurifier;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = "Users list";
?>

<?php foreach ($usersList as $user): ?>
    <div class="page-posts no-padding">
        <div class="row">
            <div class="page page-post col-sm-12 col-xs-12 post-82">
                <div class="blog-posts blog-posts-large">
                    <div class="row">
                        <!-- profile -->
                        <article class="profile col-sm-12 col-xs-12">
                            <div class="profile-title">
                                <img src="<?php echo $user->getPicture(); ?>" class="author-image"
                                     id="profile-picture"/>
                                <div class="author-name">
                                    <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => $user->getNickname()]); ?>"><?php echo Html::encode($user->username); ?></a>
                                </div>


                            </div>
                            <?php if ($user->about): ?>
                                <div class="profile-description">
                                    <p><?php echo HTMLPurifier::process($user->about); ?></p>
                                </div>
                            <?php endif; ?>
                            <br>
                            <!--If show another user profile add button subscribe and unsubscribe-->
                            <?php if ($currentUser && !$user->equals($currentUser)): ?>
                                <!--Show people, who are following you-->
                                <?php if ($muturalSubscriptions = $currentUser->getMuturalSubscriptionsTo($user)): ?>
                                    <hr>
                                    <h5><?php echo Yii::t('menu', 'Friends, who are also following');?> <?php echo Html::encode($user->username); ?>
                                        :</h5>
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
                            <hr>
                            <div class="profile-bottom">
                                <div class="profile-post-count">
                                    <span><?php echo Yii::t('menu', 'posts ') . '(' . $user->getPostCount() . ')';?></span>
                                </div>
                                <div class="profile-followers">
                                    <a href="#" data-toggle="modal"
                                       data-target="#followers"> <?php echo Yii::t('menu', 'followers ') . '(' . $user->countFollowers() . ')';?></a>
                                </div>
                                <div class="profile-following">
                                    <a href="#" data-toggle="modal"
                                       data-target="#subscriptions">
                                        <?php echo Yii::t('menu', 'following ') . '(' . $user->countSubscriptions(). ')';?></a>
                                </div>
                            </div>
                        </article>

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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Subscriptions</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <?php foreach ($user->getSubscriptions() as $subscription): ?>
                            <div class="col-md=12">
                                <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($subscription['nickname']) ? ($subscription['nickname']) : ($subscription['id'])]); ?>">
                                    &nbsp; <?php echo Html::encode($subscription['username']); ?>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
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

<?php endforeach; ?>

<!--display pagination-->
<?php echo LinkPager::widget(['pagination' => $pages,]); ?>



