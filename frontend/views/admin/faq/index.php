<?php

use yii\grid\GridView;
use yii\helpers\Html;

$categories = [null => '-- Selecciona categoría --'];

$faqCategories = \frontend\models\FaqCategories::find()->select(['id', 'category'])->asArray()->all();
$faqCategories = \yii\helpers\ArrayHelper::map($faqCategories, 'id', 'category');
$categories = $categories + $faqCategories;

$this->title = "Preguntas Frecuentes";

$this->params['breadcrumbs'][] = 'Administración';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="/admin/faq/crear" class="btn btn-warning float-right" style="margin-bottom: 10px">Crear pregunta frecuente</a>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'pager' => ['class' => \frontend\widgets\CustomPager::class],
                        'columns' => [
                            'id',
                            [
                                'attribute' => 'id_category',
                                'format' => 'raw',
                                'value' => function($data) {
                                    $faqCategory = \frontend\models\FaqCategories::findOne($data->id_category);
                                    return $faqCategory->category;
                                },
                                'filter' => Html::activeDropDownList($searchModel, 'id_category', $categories, ['class' => 'form-control']),
                            ],
                            'question',
                            [
                                'attribute' => 'answer',
                                'format' => 'raw',
                                'value' => function($data) {
                                    $answer = strip_tags($data->answer);
                                    $answer = substr($answer, 0, 50) . (strlen($answer) > 50 ? '...' : '');
                                    return "<p title=\"{$data->answer}\">{$answer}</p>";
                                },
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{update} {delete}',
                                'buttons' => [
                                    'update' => function ($url, $model, $key) {
                                        return Html::a('<i class="fas fa-pencil-alt"></i>', "/admin/faq/editar/{$model->id}");
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('<i class="fas fa-trash"></i>', "/admin/faq/borrar/{$model->id}" , ['data' => ['method' => 'post', 'confirm' => '¿Quieres borrar la pregunta frecuente?']]);
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
