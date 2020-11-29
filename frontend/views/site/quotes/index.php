<?php

use common\models\User;
use frontend\models\Quote;
use yii\grid\GridView;
use yii\helpers\Html;

$statuses = [null => '-- Selecciona estado --'] + Quote::STATUS;

$role = Yii::$app->user->identity->role;

if ($role != User::ROLE_EXPERT)
{
    $experts = User::find()->select(['id', 'name'])->where(['role' => User::ROLE_EXPERT])->asArray()->all();
    $experts = [null => '-- Selecciona experto --'] + \yii\helpers\ArrayHelper::map($experts, 'id', 'name');
}

else {
    $experts = [];
}

if ($role != User::ROLE_USER)
{
    $users = User::find()->select(['user.id', 'name'])
        ->joinWith(['quotes'], false, 'INNER JOIN')
        ->where(['role' => User::ROLE_USER]);

    if ($role == User::ROLE_EXPERT) {
        $users = $users->andWhere(['id_expert' => Yii::$app->user->identity->id]);
    }

    $users = $users->groupBy(['user.id'])
        ->asArray()
        ->all();

    $users = [null => '-- Selecciona usuario --'] + \yii\helpers\ArrayHelper::map($users, 'id', 'name');
}

else {
    $users = [];
}

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
                                'filter' => Html::activeDropDownList($searchModel, 'id_expert', $experts, ['class' => 'form-control']),
                            ],
                            [
                                'label' => 'Usuario',
                                'attribute' => 'id_user',
                                'value' => function($data) {
                                    $user = User::findOne($data->id_user);
                                    return $user->name;
                                },
                                'visible' => $role != \common\models\User::ROLE_USER,
                                'filter' => Html::activeDropDownList($searchModel, 'id_user', $users, ['class' => 'form-control']),
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
                                    'view' => function ($url, $model, $key) use ($role) {
                                        return Html::a('<i class="fas fa-eye"></i>', ($role == User::ROLE_ADMIN ? '/admin' : '') . "/consultas/{$model->id}");
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
