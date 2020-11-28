<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "provincia".
 *
 * @property float $provinciaid
 * @property string $provincia
 */
class Provincia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provincia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['provinciaid', 'provincia'], 'required'],
            [['provinciaid'], 'number'],
            [['provincia'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'provinciaid' => 'Provinciaid',
            'provincia' => 'Provincia',
        ];
    }
}
