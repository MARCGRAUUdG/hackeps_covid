<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "servers".
 *
 * @property int $id
 * @property int $client
 * @property int $pla
 * @property int|null $clau
 */
class Servers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client'], 'required'],
            [['client', 'pla', 'clau'], 'default', 'value' => null],
            [['client', 'pla', 'clau'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client' => 'Client',
            'pla' => 'Pla',
            'clau' => 'Clau',
        ];
    }
}
