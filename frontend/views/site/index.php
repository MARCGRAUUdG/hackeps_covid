<?php

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
                    <h4><?= $server['pla'] ?></h4>

                    <div class="card card-<?= $colors[$categoryIndex % 4] ?> card-outline">
                        <a class="d-block w-100" href="#collapse-faq-<?= $server['id'] ?>">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <?= $server['clau'] ?>
                                </h4>
                            </div>
                        </a>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
</div>
