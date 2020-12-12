<?php

namespace frontend\models;

use common\models\User;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%quote}}".
 *
 * @property int $id
 * @property int $id_user
 * @property int|null $id_expert
 * @property int $status
 * @property string|null $message
 * @property int $created_at
 * @property int|null $updated_at
 *
 * @property User $user
 * @property User $expert
 * @property QuoteMessages[] $messages
 */
class Quote extends \yii\db\ActiveRecord
{
    const STATUS_CREATED = 0;
    const STATUS_ASSIGNED = 1;
    const STATUS_OPEN = 2;
    const STATUS_SOLVED = 3;
    const STATUS_CLOSED = 4;

    const STATUS = [
        self::STATUS_CREATED => 'Sin experto asignado',
        self::STATUS_ASSIGNED => 'Sin respuesta',
        self::STATUS_OPEN => 'Abierta',
        self::STATUS_SOLVED => 'Resuelta',
        self::STATUS_CLOSED => 'Cerrada',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quote}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            ['class' => TimestampBehavior::className()],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'created_at'], 'required'],
            [['id_user', 'id_expert', 'status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['id_user', 'id_expert', 'status', 'created_at', 'updated_at'], 'integer'],
            [['message'], 'string'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['id_expert'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_expert' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_expert' => 'Id Expert',
            'status' => 'Status',
            'message' => 'Message',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * Gets query for [[Expert]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExpert()
    {
        return $this->hasOne(User::className(), ['id' => 'id_expert']);
    }

    /**
     * Gets query for [[QuoteMessages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(QuoteMessages::className(), ['id_quote' => 'id']);
    }
}
