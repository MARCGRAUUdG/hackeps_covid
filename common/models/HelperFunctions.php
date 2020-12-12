<?php
namespace common\models;

use yii\base\Model;
use yii\db\ActiveRecord;

class HelperFunctions extends Model
{
    /**
     * @param ActiveRecord $model
     */
    public static function errors($model)
    {
        $errors = $model->getErrors();

        if (empty($errors)) {
            return '';
        }

        $return = '<ul>';

        foreach ($errors as $attribute => $attErrors) {
            foreach ($attErrors as $error) {
                $return .= '<li> ' . $model->getAttributeLabel($attribute) . ": {$error}</li>";
            }
        }

        $return .= '</ul>';

        return $return;
    }
}
