<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'Centros';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<!-- Main content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Selecciona una província</label>
                <?= Html::activeDropDownList(new \frontend\models\Provincia, 'provinciaid', ArrayHelper::map(\frontend\models\Provincia::find()->all(), 'provinciaid', 'provincia'), ['class' => 'form-control', 'style' => 'width: 100%;']); ?>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
