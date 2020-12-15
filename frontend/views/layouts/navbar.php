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
        <li class="nav-item dropdown user-menu">
            <?php if (Yii::$app->user->isGuest): ?>
                <a href="/login" class="btn btn-default btn-flat" style="float: right;">Iniciar sesión</a>
                <a href="/registrar" class="btn btn-primary btn-flat" style="float: right;">Crear cuenta</a>
            <?php else: ?>
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="//merics.org/sites/default/files/styles/ct_team_member_default/public/2020-04/avatar-placeholder.png?itok=Vhm0RCa3" class="user-image img-circle elevation-2" alt="User Image">
                    <span class="d-none d-md-inline"><?= Yii::$app->user->identity->name ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-primary">
                        <img src="//merics.org/sites/default/files/styles/ct_team_member_default/public/2020-04/avatar-placeholder.png?itok=Vhm0RCa3" class="img-circle elevation-2" alt="User Image">
                        <p><?= Yii::$app->user->identity->name ?></p>
                        <small><?= \common\models\User::ROLE[Yii::$app->user->identity->role] ?></small>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <a href="/edit-profile" class="btn btn-default btn-flat">Perfil</a>
                        <?= Html::a('Cerrar sesión', ['/logout'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat float-right']) ?>
                    </li>
                </ul>
            <?php endif ?>
        </li>
    </ul>
</nav>
