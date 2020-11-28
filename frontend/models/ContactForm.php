<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%contact}}".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $subject
 * @property string $message
 * @property int $created_at
 */
class ContactForm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%contact}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            ['class' => TimestampBehavior::className(), 'updatedAtAttribute' => false,],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'subject', 'message'], 'required'],
            [['email'], 'email'],
            [['message'], 'string'],
            [['name', 'email', 'subject'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'email' => 'Correo electrónico',
            'subject' => 'Título',
            'message' => 'Mensaje',
            'created_at' => 'Enviado en',
        ];
    }
}
