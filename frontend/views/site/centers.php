<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Centros';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<!-- Main content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">

                <?php $form = ActiveForm::begin(['id' => 'form-center']); ?>

                <label>Selecciona una província</label>
                <?= Html::dropDownList('provinciaid', ArrayHelper::map(\frontend\models\Provincia::find()->all(), 'provinciaid', 'provincia'), ['class' => 'form-control', 'style' => 'width: 100%;']); ?>

                <div class="form-group">
                    <?= Html::submitButton('Crear cuenta', ['class' => 'btn btn-primary', 'name' => 'center-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
