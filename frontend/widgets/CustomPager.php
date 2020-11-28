<?php
namespace frontend\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\LinkPager;

class CustomPager extends LinkPager
{
    public $linkContainerOptions = ['class' => 'page-item'];

    public $linkOptions = ['class' => 'page-link'];

    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = $this->linkContainerOptions;
        $linkWrapTag = ArrayHelper::remove($options, 'tag', 'li');
        Html::addCssClass($options, empty($class) ? $this->pageCssClass : $class);

        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }

        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);
        }

        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;

        return Html::tag($linkWrapTag, Html::a($label, $this->pagination->createUrl($page), $linkOptions), $options);
    }
}
