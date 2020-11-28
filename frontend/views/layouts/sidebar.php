<?php

use common\models\User;

$authed = !Yii::$app->user->isGuest;
$role = $authed ? Yii::$app->user->identity->role : null;

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
                    [
                        'label' => 'Pruebas',
                        'icon' => 'syringe',
                        'items' => [
                            ['label' => 'Centros', 'url' => ['/pruebas/centros'], 'icon' => 'clinic-medical', 'iconStyle' => 'far fas'],
                            ['label' => 'Mis pruebas', 'url' => ['/pruebas/mis'], 'icon' => 'notes-medical', 'iconStyle' => 'far fas', 'visible' => $authed && $role == User::ROLE_USER],
                        ]
                    ],
                    ['label' => 'Consultas', 'url' => ['/consultas'], 'icon' => 'user-md', 'visible' => $authed],
                    ['label' => 'Preguntas Frecuentes', 'url' => ['/faq'], 'icon' => 'question-circle'],
                    ['label' => 'Contacto', 'url' => ['/faq'], 'icon' => 'envelope'],
                    ['label' => 'Aplicación', 'url' => ['/app'], 'icon' => 'mobile'],
                    ['label' => 'Administración', 'icon' => 'cogs', 'visible' => $authed && $role == User::ROLE_ADMIN],


                    /*['label' => 'Yii2 PROVIDED', 'header' => true],
                    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],*/
                    /*['label' => 'Level1'],
                    [
                        'label' => 'Level1',
                        'items' => [
                            ['label' => 'Level2', 'iconStyle' => 'far'],
                            [
                                'label' => 'Level2',
                                'iconStyle' => 'far',
                                'items' => [
                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle']
                                ]
                            ],
                            ['label' => 'Level2', 'iconStyle' => 'far']
                        ]
                    ],*/
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
