<?php

use yii\helpers\Html;

$this->title = 'Iniciar sesión';

?>
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Inicia sesión para acceder a tus datos</p>

        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'login-form']) ?>

        <?= $form->field($model,'email', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>

        <?= $form->field($model, 'password', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
            <div class="col-8">
            </div>
            <div class="col-4">
                <?= Html::submitButton('Iniciar sesión', ['class' => 'btn btn-primary btn-block']) ?>
            </div>
        </div>

        <?php \yii\bootstrap4\ActiveForm::end(); ?>

        <p class="mb-1">
            <a href="/recuperar">Contraseña olvidada</a>
        </p>
        <p class="mb-0">
            <a href="/registrar" class="text-center">Crear cuenta</a>
        </p>
    </div>
    <!-- /.login-card-body -->
</div>
