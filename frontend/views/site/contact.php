<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactFormSearch */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Contactar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p>
                        Si tienes alguna duda o quieres realizar cualquier consulta utiliza el formulario de contacto a continuación.
                    </p>

                    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                        <?= $form->field($model, 'email') ?>

                        <?= $form->field($model, 'subject') ?>

                        <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
