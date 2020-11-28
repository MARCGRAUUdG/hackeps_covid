<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Perfil';
?>
<body class="hold-transition sidebar-mini">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                     src="//merics.org/sites/default/files/styles/ct_team_member_default/public/2020-04/avatar-placeholder.png?itok=Vhm0RCa3"
                                     alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center"><?= Yii::$app->user->identity->name?></h3>

                            <p class="text-muted text-center"><?= Yii::$app->user->identity->role?></p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Nombre</b> <a class="float-right"><?= $model->name?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Telefono mobil</b> <a class="float-right"><?= $model->phone?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right"><?= $model->email?></a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <span>Edita tu perfil</span>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <?php $form = ActiveForm::begin(['id' => 'profile-form']); ?>
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                                    </li>
                                    <li class="list-group-item">
                                        <?= $form->field($model, 'phone') ?>
                                    </li>
                                    <li class="list-group-item">
                                        <?= $form->field($model, 'email') ?>
                                    </li>
                                </ul>

                                <div class="form-group">
                                    <?= Html::submitButton('Actualizar perfil', ['class' => 'btn btn-primary', 'name' => 'profile-button']) ?>
                                </div>
                                <?php ActiveForm::end();?>
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</body>
