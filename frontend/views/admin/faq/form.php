<?php

use yii\helpers\Html;

$categories = \frontend\models\FaqCategories::find()->select(['id', 'category'])->asArray()->all();
$categories = \yii\helpers\ArrayHelper::map($categories, 'id', 'category');

$newCategoryJS = <<<JS
    $('#new-category-btn').click(function() {
        var category = $('#category').val();
        
        $.post('/admin/faq/categoria', { category: category }, function(data) {
            if (data.success) {
                var newOption = $('<option value="' + data.id + '">' + category + '</option>');
                $('#faq-id_category').append(newOption);
                $('#faq-id_category').val(data.id);
            }
            
            $('#new-category').modal('hide');
            $('#faq-question').focus();
        });
        
        return false;        
    });
JS;

$this->registerJS($newCategoryJS);

$this->title = $faq->isNewRecord ? "Crear pregunta frecuente" : "Editar pregunta frecuente: {$faq->question}";

$this->params['breadcrumbs'][] = 'Administración';
$this->params['breadcrumbs'][] = ['label' => 'Preguntas Frecuentes', 'url' => '/admin/faq'];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <button class="btn btn-warning float-right" style="margin-bottom: 10px" data-toggle="modal" data-target="#new-category">Nueva categoría</button>

                    <?php $form = \yii\widgets\ActiveForm::begin() ?>

                        <?= $form->field($faq, 'id_category')->dropDownList($categories, ['class' => 'form-control']) ?>

                        <?= $form->field($faq, 'question')->textInput(['class' => 'form-control']) ?>

                        <?= $form->field($faq, 'answer')->textarea(['rows' => 6]) ?>

                        <div class="form-group">
                            <?= Html::submitButton($faq->isNewRecord ? 'Crear' : 'Guardar', ['class' => 'btn btn-primary']) ?>
                        </div>

                    <?php \yii\widgets\ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="new-category" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Crear categoría de pregunta frecuente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <label>
                    Título:
                </label>
                <input type="text" id="category" class="form-control">
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="new-category-btn">Crear</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
