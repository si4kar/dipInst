<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Admin panel';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Admin panel</h1>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-6">
                <h2>Complains</h2>


                <p><a class="btn btn-default" href="<?php echo Url::to(['/complaints/manage']); ?>">Manage complaints</a></p>

            </div>
            <div class="col-lg-6">
                <h2>Users</h2>

                <p><a class="btn btn-default" href="<?php echo Url::to(['/user/manage']); ?>">Manage users</a></p>
            </div>

        </div>

    </div>

</div>
