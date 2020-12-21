<?php

use yii\helpers\Html;

$colors = ['success', 'info', 'warning', 'danger'];

$categoryCount = 4;
$newColors = [];

while (count($newColors) <= $categoryCount) {
    $newColors = array_merge($newColors, $colors);
}

$this->title = 'Servidores';
$this->params['breadcrumbs'][] = $this->title;

$userServers = \app\models\Servers::find()->where(['client' => Yii::$app->user->id])->asArray()->all();


?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12" id="accordion">
            <?php if (empty($userServers)): ?>
                <div class="alert alert-info">
                    <h5><i class="icon fas fa-info"></i> Ooops...</h5>
                    No tens cap servidor comprat, si us plau ves a creau un nou servidor per comprar un pla.
                </div>
            <?php else: ?>
                <?php $categoryIndex = 0 ?>
                <?php foreach ($userServers as $server): ?>
                    <?php
                    $form = \yii\widgets\ActiveForm::begin(
                        [
                            'id' => 'deleteserver-form',
                            'action' => 'site/power/' .$server['id'],
                            'method' => 'post',
                        ]
                    );
                    ?>
                    <?php
                        $pack = \app\models\Pla::find()->where(['id' => $server['pla']])->one();
                    ?>
                    <h4>SO: <?= $pack->os ?> // RAM: <?=$pack->ram?> // CPU: <?=$pack->cores?> cores // HDD: <?=$pack->hdd?> // Conexió: <?=$pack->conection?></h4>

                    <div class="card card-<?= $colors[$categoryIndex % 4] ?> card-outline">
                        <span class="d-block w-100" href="#collapse-faq-<?= $server['id'] ?>">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <?= $server['clau'] ?>
                                </h4>
                            </div>
                        </span>
                    </div>
                    <div class="col-md-2 col-2">
                        <?= Html::submitButton('Engegar VM', ['class' => 'btn btn-success btn-block']) ?>
                        <?php \yii\widgets\ActiveForm::end();?>
                        <?php
                        $form = \yii\widgets\ActiveForm::begin(
                            [
                                'id' => 'deleteserver-form',
                                'action' => 'site/deleteserver/' .$server['id'],
                                'method' => 'post',
                            ]
                        );
                        ?>
                        <?= Html::submitButton('Obrir Remote Desktop', ['class' => 'btn btn-success btn-block']) ?>
                        <?php \yii\widgets\ActiveForm::end();?>
                        <?php
                        $form = \yii\widgets\ActiveForm::begin(
                            [
                                'id' => 'deleteserver-form',
                                'action' => 'site/close/' .$server['id'],
                                'method' => 'post',
                            ]
                        );
                        ?>
                        <?= Html::submitButton('Tancar VM', ['class' => 'btn btn-warning btn-block']) ?>
                        <?php \yii\widgets\ActiveForm::end();?>
                        <?php
                        $form = \yii\widgets\ActiveForm::begin(
                            [
                                'id' => 'deleteserver-form',
                                'action' => 'site/deleteserver/' .$server['id'],
                                'method' => 'post',
                            ]
                        );
                        ?>
                        <?= Html::submitButton('Eliminar', ['class' => 'btn btn-danger btn-block']) ?>
                        <?php \yii\widgets\ActiveForm::end();?>
                    </div>
                    <div class="col-md-2 col-2">

                    </div>
                    <br><hr>

                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
</div>

