<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'Dashboard';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<!-- Main content -->
<div class="container-fluid">
    <span><h4>Datos locales</h4></span>
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>150</h3>

                    <p>New Orders</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>

                    <p>Bounce Rate</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>44</h3>

                    <p>User Registrations</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>65</h3>

                    <p>Unique Visitors</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Selecciona una província</label>
                <?= Html::activeDropDownList(new \frontend\models\Provincia, 'provinciaid', ArrayHelper::map(\frontend\models\Provincia::find()->all(), 'provinciaid', 'provincia'), ['class' => 'form-control', 'style' => 'width: 100%;']); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Selecciona un rango de tiempo</label>
                <select class="form-control" style="width: 100%;">
                    <option selected="selected">Hoy</option>
                    <option>Última semana</option>
                    <option>Último mes</option>
                    <option>Últimos tres meses</option>
                    <option>Todo</option>
                </select>
            </div>
            <!-- /.form-group -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <br><hr><br>

    <span><h4>Datos Ministerio de Sanidad</h4></span>
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>150</h3>

                    <p>New Orders</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>

                    <p>Bounce Rate</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>44</h3>

                    <p>User Registrations</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>65</h3>

                    <p>Unique Visitors</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Selecciona una província</label>
                <?= Html::activeDropDownList(new \frontend\models\Provincia, 'provinciaid', ArrayHelper::map(\frontend\models\Provincia::find()->all(), 'provinciaid', 'provincia'), ['class' => 'form-control', 'style' => 'width: 100%;']); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Selecciona un rango de tiempo</label>
                <select class="form-control" style="width: 100%;">
                    <option selected="selected">Hoy</option>
                    <option>Última semana</option>
                    <option>Último mes</option>
                    <option>Últimos tres meses</option>
                    <option>Todo</option>
                </select>
            </div>
            <!-- /.form-group -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
