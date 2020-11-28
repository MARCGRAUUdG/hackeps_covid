<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = "Contacto";

$this->params['breadcrumbs'][] = 'Administración';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'pager' => ['class' => \frontend\widgets\CustomPager::class],
                        'columns' => [
                            'id',
                            'name',
                            [
                                'attribute' => 'email',
                                'format' => 'raw',
                                'value' => function($data) {
                                    $link = "mailto:{$data->email}?subject=" . urlencode("Re: {$data->subject}");
                                    return '<a href="' . $link . '" target="_blank">' . $data->email . '</a>';
                                }
                            ],
                            'subject',
                            [
                                'attribute' => 'message',
                                'value' => function($data) {
                                    return substr($data->message, 0, 50) . (strlen($data->message) > 50 ? '...' : '');
                                }
                            ],
                            [
                                'attribute' => 'created_at',
                                'label' => 'Enviado en',
                                'value' => function($data) {
                                    return date('d/m/Y \a \l\a\s H:i', $data->created_at);
                                },
                                'filter' => Html::activeInput('date', $searchModel, 'created_at', ['class' => 'form-control']),
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view} {delete}',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::a('<i class="fas fa-eye"></i>', "/admin/contacto/{$model->id}");
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('<i class="fas fa-trash"></i>', "/admin/contacto/borrar/{$model->id}" , ['data' => ['method' => 'post', 'confirm' => '¿Quieres borrar el registro?']]);
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
