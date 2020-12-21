<?php

use yii\helpers\Html;

$this->title = 'Nou servidor';

$form = \yii\widgets\ActiveForm::begin(
    [
        'id' => 'newserver-form',
        'action' => 'site/newserver',
        'method' => 'post',
    ]
);

$model = new \app\models\Servers();

$packS = \app\models\Pla::find()->where(['id' => 1])->one();
$packM = \app\models\Pla::find()->where(['id' => 2])->one();
$packL = \app\models\Pla::find()->where(['id' => 3])->one();
?>
<div class="container-fluid">
    <div class="row" id="local-data">
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Pack S</h3>
                    <p><?= $packS->os?></p>
                    <p><?= $packS->ram?> GB RAM</p>
                    <p><?= $packS->cores?> CPUs</p>
                    <p><?= $packS->hdd?> GB HDD</p>
                    <p><?= $packS->conection?></p>
                    <p><?= $packS->price?> €</p>

                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Pack M</h3>
                    <p><?= $packM->os?></p>
                    <p><?= $packM->ram?> GB RAM</p>
                    <p><?= $packM->cores?> CPUs</p>
                    <p><?= $packM->hdd?> GB HDD</p>
                    <p><?= $packM->conection?></p>
                    <p><?= $packM->price?> €</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Pack L</h3>
                    <p><?= $packL->os?></p>
                    <p><?= $packL->ram?> GB RAM</p>
                    <p><?= $packL->cores?> CPUs</p>
                    <p><?= $packL->hdd?> GB HDD</p>
                    <p><?= $packL->conection?></p>
                    <p><?= $packL->price?> €</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <div class="row">
        <div class="col-12" id="accordion">
            <?= $form->field($model, 'pla')->dropdownList([
                        1 => 'Paquet S',
                        2 => 'Paquet M',
                        3 => 'Paquet L'
                    ],
                    ['prompt'=>'Selecciona un pla']
                );?>
            <?= Html::submitButton('Crear servidor', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
</div>
<?php \yii\widgets\ActiveForm::end(); ?>
