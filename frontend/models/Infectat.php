<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "infectat".
 *
 * @property float $infectatid
 * @property string $infectat
 */
class Infectat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'infectat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['infectatid', 'infectat'], 'required'],
            [['infectatid'], 'number'],
            [['infectat'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'infectatid' => 'Infectatid',
            'infectat' => 'Infectat',
        ];
    }
}
