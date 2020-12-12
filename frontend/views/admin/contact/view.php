<?php

use yii\helpers\Html;

$this->title = "Contacto: {$contact->subject}";

$link = "mailto:{$contact->email}?subject=" . urlencode("Re: {$contact->subject}");

$this->params['breadcrumbs'][] = 'Administración';
$this->params['breadcrumbs'][] = ['label' => 'Contacto', 'url' => '/admin/contacto'];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center" style="margin-bottom: 20px">
                        <?= $contact->subject ?>
                        <?= Html::a('Borrar', "/admin/contacto/borrar/{$contact->id}" , ['class' => 'btn btn-danger float-right', 'data' => ['method' => 'post', 'confirm' => '¿Quieres borrar el registro?']]) ?>
                        <a href="<?= $link ?>" class="btn btn-primary float-right" target="_blank" style="margin-right: 10px">Responder</a>
                    </h3>
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Nombre:</strong> <?= $contact->name ?>
                        </div>
                        <div class="col-md-4 text-center">
                            <strong>Correo electrónico:</strong> <?= $contact->email ?>
                        </div>
                        <div class="col-md-4 text-right">
                            <strong>Enviado en:</strong> <?= date('d/m/Y \a \l\a\s H:i', $contact->created_at) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <blockquote>
                                <?= strip_tags($contact->message, '<p><br>') ?>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

