<?php

use yii\helpers\Html;

?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a href="https://wa.me/+34600802802" class="nav-link" target="_blank">
                <i class="fab fa-whatsapp"></i> Whatsapp
            </a>
        </li>
        <?php if (!Yii::$app->user->isGuest): ?>
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline"><?= Yii::$app->user->identity->username ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    <p><?= Yii::$app->user->identity->username ?></p>
                    <p>
                        <?= Yii::$app->user->identity->username ?> - <?= Yii::$app->user->identity->role?>
                        <small>Member since Nov. 2012</small>
                    </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <?= Html::a('Profile', ['/edit-profile'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat float-left']) ?>
                    <?= Html::a('Sign out', ['/site/logout'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat float-right']) ?>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
                    class="far fa-comments"></i></a>
        </li>
        <?php else: ?>
            <a href="/login" class="btn btn-default btn-flat">Iniciar sesión</a>
            <a href="/signup" class="btn btn-default btn-flat">Crear cuenta</a>
        <?php endif;?>
    </ul>
</nav>