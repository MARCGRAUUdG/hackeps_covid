<?php

$colors = ['success', 'info', 'warning', 'danger'];

$categoryCount = count(array_keys($faqs));
$newColors = [];

while (count($newColors) <= $categoryCount) {
    $newColors = array_merge($newColors, $colors);
}

$this->title = 'Preguntas Frecuentes';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12" id="accordion">
            <?php if (empty($faqs)): ?>
                <div class="alert alert-info">
                    <h5><i class="icon fas fa-info"></i> Ooops...</h5>
                    Aún no hemos preparado las preguntas frecuentes. Por favor, <a href="/contacto">contacta con nosotros</a> para que respondamos tu consulta.
                </div>
            <?php else: ?>
                <?php $faqIndex = 0; $categoryIndex = 0 ?>
                <?php foreach ($faqs as $category => $categoryFaqs): ?>
                    <h4><?= $categories[$category] ?></h4>
                    <?php foreach ($categoryFaqs as $faq): ?>
                        <div class="card card-<?= $colors[$categoryIndex % 4] ?> card-outline">
                            <a class="d-block w-100" data-toggle="collapse" href="#collapse-faq-<?= $faq->id ?>">
                                <div class="card-header">
                                    <h4 class="card-title w-100">
                                        <?= ++$faqIndex ?>. <?= $faq->question ?>
                                    </h4>
                                </div>
                            </a>
                            <div id="collapse-faq-<?= $faq->id ?>" class="collapse <?= $faqIndex == 1 ? 'show' : '' ?>" data-parent="#accordion">
                                <div class="card-body">
                                    <?= $faq->answer ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                    <?php $categoryIndex++ ?>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mt-2 mb-3 text-center">
        <a href="/contacto" class="lead btn btn-lg btn-warning">No he encontrado la respuesta a mi pregunta</a>
    </div>
</div>
