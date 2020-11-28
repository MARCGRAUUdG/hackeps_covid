<?php

use common\models\User;
use frontend\models\Quote;
use yii\grid\GridView;
use yii\helpers\Html;

$statuses = [null => '-- Selecciona estado --'] + Quote::STATUS;

$role = Yii::$app->user->identity->role;

$this->title = "Consultas";
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php if ($role == User::ROLE_USER): ?>
                        <a href="/consultas/crear" class="btn btn-warning float-right" style="margin-bottom: 10px">Nueva consulta</a>
                    <?php endif ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'pager' => ['class' => \frontend\widgets\CustomPager::class],
                        'columns' => [
                            'id',
                            [
                                'label' => 'Estado',
                                'attribute' => 'status',
                                'value' => function($data) {
                                    return Quote::STATUS[$data->status];
                                },
                                'filter' => Html::activeDropDownList($searchModel, 'status', $statuses, ['class' => 'form-control']),
                            ],
                            [
                                'label' => 'Experto',
                                'attribute' => 'id_expert',
                                'value' => function($data) {
                                    if (empty($data->id_expert)) {
                                        return '-';
                                    }

                                    $expert = User::findOne($data->id_expert);
                                    return $expert->name;
                                },
                                'visible' => $role != \common\models\User::ROLE_EXPERT,
                            ],
                            [
                                'label' => 'Usuario',
                                'attribute' => 'id_user',
                                'value' => function($data) {
                                    $user = User::findOne($data->id_user);
                                    return $user->name;
                                },
                                'visible' => $role != \common\models\User::ROLE_USER,
                            ],
                            [
                                'label' => 'Consulta',
                                'attribute' => 'message',
                                'value' => function($data) {
                                    $msg = strip_tags($data->message);
                                    return $msg . (strlen($msg) > 50 ? '...' : '');
                                },
                                'filter' => Html::activeTextInput($searchModel, 'message', ['class' => 'form-control']),
                            ],
                            [
                                'label' => 'Creada en',
                                'attribute' => 'created_at',
                                'value' => function($data) {
                                    return date('d/m/Y \a \l\a\s H:i', $data->created_at);
                                },
                                'filter' => Html::activeInput('date', $searchModel, 'created_at', ['class' => 'form-control', 'onchange' => 'return false;']),
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view}',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::a('<i class="fas fa-eye"></i>', "/consultas/{$model->id}");
                                    },
                                ],
                            ],
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
