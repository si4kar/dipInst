<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\assets\FontAwesomeAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use yii\jui\AutoComplete;

AppAsset::register($this);
FontAwesomeAsset::register($this);
?>


<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>



<body class="home page">
<?php $this->beginBody() ?>

<div class="wrapper">
    <header>
        <div class="header-top">
            <div class="container">
                <div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4 brand-logo">
                    <h1>
                        <a href="<?php echo Url::to(['/site/index']); ?>">
                            <img src="/img/logo.gif" alt="">
                        </a>
                    </h1>
                </div>
                <div class="col-md-4 col-sm-4 navicons-topbar">
                    <ul>
                        <li class="blog-search">
                            <i class="fa fa-search"></i>

                                <?php echo AutoComplete::widget([
                                    /*          'model' => $model,
                                              'attribute' => 'country',*/
                                    'options' => (['class' => 'form-control', 'placeholder' => 'Search for description']),
                                    'clientOptions' => [
                                        'source' => Url::to(['site/search']),
                                        'minLength'=>'2',

                                    ],
                                ]); ?>

                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="header-main-nav">
            <div class="container">
                <div class="main-nav-wrapper">
                    <nav class="main-menu">
                        <?php
                        $menuItems = [
                            ['label' => 'NewsFeed', 'url' => ['/site/index']],
                        ];
                        if (Yii::$app->user->isGuest) {
                            $menuItems[] = ['label' => 'Signup', 'url' => ['/user/default/signup']];
                            $menuItems[] = ['label' => 'Login', 'url' => ['/user/default/login']];
                        } else {
                            $menuItems[] = ['label' => 'My page', 'url' => ['/user/profile/view', 'nickname' => Yii::$app->user->identity->getNickname()]];
                            $menuItems[] = ['label' => 'Create post', 'url' => ['/post/default/create']];
                            $menuItems[] = '<li>'
                                . Html::beginForm(['/user/default/logout'], 'post')
                                . Html::submitButton(
                                    'Logout (' . Yii::$app->user->identity->username . ') <i class="fa fa-sign-out"></i>',
                                    ['class' => 'btn btn-link logout']
                                )
                                . Html::endForm()
                                . '</li>';
                        }
                        echo Nav::widget([
                            'options' => ['class' => 'menu navbar-nav navbar-right'],
                            'items' => $menuItems,
                        ]);

                        ?>


                    </nav>
                </div>
            </div>
        </div>

    </header>

    <div class="container full">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>


    <div class="push"></div>
</div>

<footer>
    <div class="footer">
        <div class="back-to-top-page">
            <a class="back-to-top"><i class="fa fa-angle-double-up"></i></a>
        </div>
        <p class="text">Diplom Sergii Sichkar</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>









