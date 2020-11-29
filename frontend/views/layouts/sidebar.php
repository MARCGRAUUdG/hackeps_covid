<?php

use common\models\User;

$authed = !Yii::$app->user->isGuest;
$role = $authed ? (int)Yii::$app->user->identity->role : null;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link text-center">
        <i class="fas fa-virus" style="opacity: .8"></i>
        <span class="brand-text font-weight-light">HackEPS CoVID</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <?php
            echo \hail812\adminlte3\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Estadísticas', 'url' => ['/'], 'icon' => 'tachometer-alt'],
                    ['label' => 'Centros', 'url' => ['/centros'], 'icon' => 'clinic-medical'],
                    ['label' => 'Consultas', 'url' => ['/consultas'], 'icon' => 'user-md', 'visible' => $authed],
                    ['label' => 'Preguntas Frecuentes', 'url' => ['/faq'], 'icon' => 'question-circle'],
                    ['label' => 'Contacto', 'url' => ['/contacto'], 'icon' => 'envelope'],
                    ['label' => 'Aplicación', 'url' => ['/app'], 'icon' => 'mobile'],
                    [
                        'label' => 'Administración',
                        'icon' => 'cogs',
                        'visible' => $role === User::ROLE_ADMIN,
                        'items' => [
                            ['label' => 'Consultas', 'url' => ['/admin/consultas'], 'icon' => 'user-md', 'iconStyle' => 'far fas'],
                            ['label' => 'Centros', 'url' => ['/admin/centros'], 'icon' => 'clinic-medical', 'iconStyle' => 'far fas'],
                            ['label' => 'Preguntas Frecuentes', 'url' => ['/admin/faq'], 'icon' => 'question-circle', 'iconStyle' => 'far fas'],
                            ['label' => 'Contacto', 'url' => ['/admin/contacto'], 'icon' => 'envelope', 'iconStyle' => 'far fas'],
                        ]
                    ],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
