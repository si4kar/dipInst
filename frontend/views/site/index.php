<?php

/* @var $this yii\web\View */
/* @var $feedItems [] frontend\models\Feed */

/* @var $currentUser frontend\models\User */

use yii\web\JqueryAsset;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HTMLPurifier;
use yii\widgets\LinkPager;


$this->title = 'News feed';

?>
    <div class="page-posts no-padding">
        <div class="row">
            <div class="page page-post col-sm-12 col-xs-12">
                <div class="blog-posts blog-posts-large">

                    <div class="row">

                        <?php if ($feedItems): ?>
                            <?php foreach ($feedItems as $feedItem): ?>
                                <?php /* @var $feedItem \frontend\models\Feed */ ?>

                                <!-- feed item -->
                                <article class="post col-sm-12 col-xs-12">
                                    <div class="post-meta">
                                        <div class="post-title">
                                            <img src="<?php echo $feedItem->author_picture ?>" class="author-image"/>
                                            <div class="author-name">
                                                <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($feedItem->author_nickname) ? ($feedItem->author_nickname) : ($feedItem->author_id)]) ?>">
                                                    <?php echo Html::encode($feedItem->author_name); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="post-type-image">
                                        <a href="<?php echo Url::to(['/post/default/view', 'id' => $feedItem->post_id]); ?>">
                                            <img src="<?php echo Yii::$app->storage->getFile($feedItem->post_filename); ?>"
                                                 alt="">
                                        </a>
                                    </div>
                                    <div class="post-description">
                                        <p> <?php echo HTMLPurifier::process($feedItem->post_description); ?></p>
                                    </div>
                                    <div class="post-bottom">
                                        <div class="post-likes">
                                            <i class="fa fa-lg fa-heart-o"></i>
                                            &nbsp;&nbsp;&nbsp;
                                            <span class="likes-count"><?php echo Yii::t('menu', 'Likes ') . '(' . $feedItem->countLikes() . ')';?> &nbsp;&nbsp;</span>
                                            <a href="#"
                                               class="btn btn-default button-like <?php echo ($currentUser->likesPost($feedItem->post_id)) ? "display-none" : ""; ?>"
                                               data-id="<?php echo $feedItem->post_id; ?>">
                                                <?php echo Yii::t('menu', 'Like');?> &nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
                                            </a>

                                            <a href="#"
                                               class="btn btn-default button-unlike <?php echo ($currentUser->likesPost($feedItem->post_id)) ? "" : "display-none"; ?>"
                                               data-id="<?php echo $feedItem->post_id; ?>">
                                                <?php echo Yii::t('menu', 'Unlike');?>&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
                                            </a>
                                        </div>
                                        <div class="post-comments">
                                            <a href="<?php echo Url::to(['/post/default/view', 'id' => $feedItem->post_id]); ?>">
                                                <span class="comments-count"><?php echo $feedItem->countCommentsToPost(); ?></span>
                                                <?php echo Yii::t('menu', 'Comments');?>
                                            </a>

                                        </div>
                                        <div class="post-date">
                                            <span><?php echo Yii::$app->formatter->asDatetime($feedItem->post_created_at); ?></span>
                                        </div>
                                        <div class="post-report">
                                            <?php if (!$feedItem->isReported($currentUser)): ?>
                                            <a href="#" class="btn btn-default button-complain" data-id="<?php echo $feedItem->post_id; ?>">
                                                <?php echo Yii::t('menu', 'Report post');?> <i class="fa fa-cog fa-spin fa-fw icon-preloader" style="display: none"></i>
                                            </a>
                                            <?php else: ?>
                                            <p><?php echo Yii::t('menu', 'Post has been reported');?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </article>
                            <?php endforeach; ?>

                            <!--display pagination-->
                            <?php echo LinkPager::widget(['pagination' => $pages,]); ?>

                        <?php else: ?>

                            <div class="col-md-12">
                                <?php echo Yii::t('menu', 'Nobody posted yet!');?>
                            </div>

                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->registerJsFile('@web/js/likes.js', [
    'depends' => JqueryAsset::className(),
]);
?>

<?php $this->registerJsFile('@web/js/complaints.js', [
    'depends' => JqueryAsset::className(),
]);

?>