<?php

use common\models\User;
use frontend\models\Quote;
use yii\helpers\Html;

$badgeColor = 'default';

switch ($quote->status)
{
    case Quote::STATUS_ASSIGNED:
    case Quote::STATUS_OPEN:
        $badgeColor = 'primary';
        break;

    case Quote::STATUS_SOLVED:
        $badgeColor = 'success';
        break;
}

$quoteId = $quote->id;

$experts = User::find()->select(['id', 'name'])->where(['role' => User::ROLE_EXPERT])->asArray()->all();
$experts = [null => '-- Selecciona experto --'] + \yii\helpers\ArrayHelper::map($experts, 'id', 'name');

$newCategoryJS = <<<JS
    $('#status-selector').on('change', function() {
        $.post('/consultas/$quoteId/estado', { status: $(this).val() });
        return false;        
    });

    $('#expert-selector').on('change', function() {
        $.post('/admin/consultas/$quoteId/experto', { expert: $(this).val() });
        return false;        
    });
JS;

$this->registerJS($newCategoryJS);

$this->title = "Consulta #{$quote->id}";
$this->params['breadcrumbs'][] = ['label' => 'Consultas', 'url' => '/consultas'];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <h4>
                Consulta <span class="badge badge-<?= $badgeColor ?>"><?= Quote::STATUS[$quote->status] ?></span>
            </h4>
        </div>
        <div class="col-md-3">
            <?php if (Yii::$app->user->identity->role != User::ROLE_USER): ?>
                <?= Html::dropDownList('status', $quote->status, Quote::STATUS, ['id' => 'status-selector', 'class' => 'form-control float-right mb-2']) ?>
            <?php endif ?>
        </div>
    </div>

    <?php if (Yii::$app->user->identity->role == User::ROLE_ADMIN): ?>
        <div class="row">
            <div class="col-12">
                <?= Html::dropDownList('expert', $quote->id_expert, $experts, ['id' => 'expert-selector', 'class' => 'form-control float-right mb-2']) ?>
            </div>
        </div>
    <?php endif ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="post">
                        <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="//merics.org/sites/default/files/styles/ct_team_member_default/public/2020-04/avatar-placeholder.png?itok=Vhm0RCa3">
                            <span class="username">
                                <a href="#"><?= Yii::$app->user->identity->name ?></a>
                            </span>
                            <span class="description"><?= date('d/m/Y \a \l\a\s H:i', $quote->created_at) ?></span>
                        </div>
                        <p>
                            <?= strip_tags($quote->message, '<p><br>') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h4>Mensajes</h4>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php if (empty($messages)): ?>
                        <div class="alert alert-info">
                            Aún no hay mensajes para tu consulta.
                        </div>
                    <?php else: ?>
                        <?php foreach ($messages as $message): ?>
                            <div class="post">
                                <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="//merics.org/sites/default/files/styles/ct_team_member_default/public/2020-04/avatar-placeholder.png?itok=Vhm0RCa3">
                                    <span class="username">
                                            <a href="#"><?= User::findOne($message->id_user)->name ?></a>
                                        </span>
                                    <span class="description"><?= date('d/m/Y \a \l\a\s H:i', $message->created_at) ?></span>
                                </div>
                                <!-- /.user-block -->
                                <p>
                                    <?= strip_tags($message->message, '<p><br>') ?>
                                </p>
                            </div>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>

    <?php if ($quote->status < Quote::STATUS_SOLVED): ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php $form = \yii\widgets\ActiveForm::begin(['action' => "/consultas/{$quote->id}/mensaje"]) ?>

                        <?= $form->field($newMessage, 'message')->textarea(['rows' => 6, 'class' => 'form-control', 'placeholder' => 'Escribe tu respuesta...'])->label(false) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Responder', ['class' => 'btn btn-primary']) ?>
                        </div>

                    <?php \yii\widgets\ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif ?>
</div>
