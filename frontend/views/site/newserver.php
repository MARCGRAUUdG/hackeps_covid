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
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12" id="accordion">
            <?= $form->field($model, 'pla')->dropdownList([
                        1 => 'Paquet S',
                        2 => 'Paquet M',
                        3 => 'Paquet L'
                    ],
                    ['prompt'=>'Selecciona un pla']
                )->hint('Please enter your key');?>
            <?= Html::submitButton('Crear servidor', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
</div>
<?php \yii\widgets\ActiveForm::end(); ?>
