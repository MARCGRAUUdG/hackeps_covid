<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "servers".
 *
 * @property int $id
 * @property int $client
 * @property int $pla
 * @property string|null $clau
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
            [['client', 'pla'], 'default', 'value' => null],
            [['client', 'pla'], 'integer'],
            [['clau'], 'string'],
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
