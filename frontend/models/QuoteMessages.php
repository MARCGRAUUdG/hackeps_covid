<?php

namespace frontend\models;

use common\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%quote_messages}}".
 *
 * @property int $id
 * @property int $id_quote
 * @property int $id_user
 * @property string $message
 * @property int $created_at
 *
 * @property Quote $quote
 * @property User $user
 */
class QuoteMessages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quote_messages}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_quote', 'id_user', 'message', 'created_at'], 'required'],
            [['id_quote', 'id_user', 'created_at'], 'default', 'value' => null],
            [['id_quote', 'id_user', 'created_at'], 'integer'],
            [['message'], 'string'],
            [['id_quote'], 'exist', 'skipOnError' => true, 'targetClass' => Quote::className(), 'targetAttribute' => ['id_quote' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_quote' => 'Id Quote',
            'id_user' => 'Id User',
            'message' => 'Message',
            'created_at' => 'Created At',
        ];
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
     * Gets query for [[Quote]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuote()
    {
        return $this->hasOne(Quote::className(), ['id' => 'id_quote']);
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
}
