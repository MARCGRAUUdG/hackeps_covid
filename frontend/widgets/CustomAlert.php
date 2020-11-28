<?php
namespace frontend\widgets;

use hail812\adminlte3\widgets\Alert;

class CustomAlert extends Alert
{
    public function run()
    {
        $body = '';

        if (!$this->simple) {
            $icon = $this->icon ?? $this->alertTypes[$this->type]['icon'] ?? null;
            $iconHtml = $icon ? '<i class="icon fas '.$icon.'"></i>' : '';
            $body = "{$iconHtml} {$this->body}";
        }

        echo \yii\bootstrap4\Alert::widget([
            'body' => $body,
            'closeButton' => $this->closeButton,
            'options' => [
                'id' => $this->getId().'-'.$this->type,
                'class' => $this->alertTypes[$this->type]['class']
            ]
        ]);
    }
}
