<?php

use yii\helpers\Url;
use yii\helpers\Html;

$colors = ['success', 'info', 'warning', 'danger'];

$categoryCount = 4;
$newColors = [];

$this->title = 'Servidores';
$this->params['breadcrumbs'][] = $this->title;

$reports = \frontend\models\Reports::find()->where(['user_id' => Yii::$app->user->id])->asArray()->all();

?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">
<style>
    body, html {
        height: 100%;
        font-family: "Inconsolata", sans-serif;
    }

    .menu {
        display: none;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12" id="accordion">
            <?php if (empty($reports)): ?>
                <div class="alert alert-info">
                    <h5><i class="icon fas fa-info"></i> Ooops...</h5>
                    No tienes ningún informe, por favor, revisalo más tarde.
                </div>
            <?php else: ?>
                <?php $categoryIndex = 0 ?>
                <?php foreach ($reports as $report): ?>
                    <h4>Report: <?=$report['report_name']?></h4>

                    <div class="card card-<?= $colors[$categoryIndex] ?> card-outline">
                        <span class="d-block w-100" href="#collapse-faq-<?= $report['id'] ?>">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <a href="<?= Url::toRoute(["site/download", "file" => $report['report_name']]) ?>">Descargar archivo</a>
                                </h4>
                            </div>
                        </span>
                    </div>
                    <br><hr>

                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
</div>

