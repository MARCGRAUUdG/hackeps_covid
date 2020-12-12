<?php

use common\models\User;

$authed = !Yii::$app->user->isGuest;
$role = $authed ? (int)Yii::$app->user->identity->role : null;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link text-center">
        <i class="fas fa-user" style="opacity: .8"></i>
        <span class="brand-text font-weight-light">VPS Web</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <?php
            echo \hail812\adminlte3\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Servidors', 'url' => ['/'], 'icon' => 'clinic-medical'],
                    ['label' => 'Nou servidor', 'url' => ['/new'], 'icon' => 'user-md', 'visible' => $authed],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
