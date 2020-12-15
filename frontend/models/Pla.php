<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pla".
 *
 * @property int $id
 * @property string|null $os
 * @property int|null $ram
 * @property int|null $cores
 * @property int|null $hdd
 * @property string|null $conection
 */
class Pla extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pla';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['os', 'conection'], 'string'],
            [['ram', 'cores', 'hdd'], 'default', 'value' => null],
            [['ram', 'cores', 'hdd'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'os' => 'Os',
            'ram' => 'Ram',
            'cores' => 'Cores',
            'hdd' => 'Hdd',
            'conection' => 'Conection',
        ];
    }
}
