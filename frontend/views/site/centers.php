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
        <div class="col-md-12">
            <div class="form-group">

                <?php $form = ActiveForm::begin(['id' => 'form-center']); ?>

                <label>Selecciona una província</label>
                <?= Html::activeDropDownList(new \frontend\models\Provincia, 'provinciaid', ArrayHelper::map(\frontend\models\Provincia::find()->all(), 'provinciaid', 'provincia'), ['class' => 'form-control', 'style' => 'width: 100%;']); ?>
                <hr>
                <div class="form-group">
                    <?= Html::submitButton('Buscar centros', ['class' => 'btn btn-primary', 'name' => 'center-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

                <!-- TABLE: Centros properos -->
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Centros properos</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Poblacion</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (isset($centers)) :?>
                                    <?php foreach ($centers as $center):?>
                                        <tr>
                                            <td><?=$center->name?></td>
                                            <td><?=$center->poblacion?></td>
                                        </tr>
                                    <?php endforeach;?>
                                <?php endif;?>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->



            </div>
        </div>
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
