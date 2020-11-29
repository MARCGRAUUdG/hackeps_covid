<?php

use common\models\User;
use frontend\models\Provincia;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$newCategoryJS = <<<JS
    function loadLocalStats()
    {
        $('#local-data h3').each(function() {
            $(this).text('Cargando...');
        });
        
        $.get('/estadisticas/local', function(data) {
            var keys = Object.keys(data);
            var index = 0;
            
            $('#local-data h3').each(function() {
                $(this).text(data[keys[index++]]);
            });
        });
    }

    function loadOfficialStats()
    {
        var form = $('#official-stats');
        
        $('#last-update').text('Cargando...');
        $('#confirmed-cases').text('Cargando...');
        $('#deaths').text('Cargando...');
        $('#healed').text('Cargando...');
        
        $.get('/estadisticas/oficial', form.serialize(), function(data) {
            $('#last-update').text(data['lastUpdated']);
            $('#confirmed-cases').text(data['infected']);
            $('#deaths').text(data['deaths']);
            $('#healed').text(data['healed']);
        });
    }
    
    $('#local-stats-province').on('change', function() {
        loadLocalStats();
        return false;
    });

    $('#filter-official-stats').click(function() {
        loadOfficialStats();        
        return false;
    });

    loadLocalStats();
    loadOfficialStats();
JS;

$this->registerJS($newCategoryJS);

$this->title = 'Estadísticas';
$this->params['breadcrumbs'] = [['label' => $this->title]];

?>
<!-- Main content -->
<div class="container-fluid">
    <h4>Datos locales actuales</h4>
    <!-- Small boxes (Stat box) -->
    <div class="row" id="local-data">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Cargando...</h3>
                    <p>Total</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Cargando...</h3>
                    <p>Casos confirmados</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>Cargando...</h3>
                    <p>Fallecidos</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Cargando...</h3>
                    <p>Recuperados</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Provincia:</label>
                <?= Html::dropDownList('province', 0, [0 => '-- Selecciona una provincia --'] + ArrayHelper::map(Provincia::find()->orderBy(['provincia' => SORT_ASC])->all(), 'provinciaid', 'provincia'), ['id' => 'local-stats-province', 'class' => 'form-control']); ?>
            </div>
        </div>
        <!-- /.col -->
    </div>

    <!-- /.row -->
    <br><hr><br>

    <h4>Datos Ministerio de Sanidad</h4>
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="last-update">Cargando...</h3>
                    <p>Última actualización</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 id="confirmed-cases">Cargando...</h3>
                    <p>Casos confirmados</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 id="deaths">Cargando...</h3>
                    <p>Fallecidos</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 id="healed">Cargando...</h3>
                    <p>Recuperados</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-12">
            <?= Html::beginForm(null, 'GET', ['id' => 'official-stats']) ?>
                <label>Provincia:</label>
                <?= Html::dropDownList('province', 0, [0 => '-- Selecciona provincia --'] + ArrayHelper::map(Provincia::find()->orderBy(['provincia' => SORT_ASC])->all(), 'provinciaid', 'provincia'), ['class' => 'form-control']) ?>
                <label>Fecha inicio:</label>
                <?= Html::input('date', 'from', date('Y-m-d'), ['class' => 'form-control']) ?>
                <label>Fecha fin:</label>
                <?= Html::input('date', 'to', date('Y-m-d'), ['class' => 'form-control']) ?>
                <?= Html::button('Filtrar', ['id' => 'filter-official-stats', 'class' => 'btn btn-primary']) ?>
            <?= Html::endForm() ?>
        </div>
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
