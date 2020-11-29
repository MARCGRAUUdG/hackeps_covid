<?php

namespace frontend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "{{%test}}".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_center
 * @property int $result
 * @property string|null $comments
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Center $center
 * @property User $user
 */
class Test extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%test}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'id_center', 'created_at', 'updated_at'], 'required'],
            [['id_user', 'id_center', 'result', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['id_user', 'id_center', 'result', 'created_at', 'updated_at'], 'integer'],
            [['comments'], 'string'],
            [['id_center'], 'exist', 'skipOnError' => true, 'targetClass' => Center::className(), 'targetAttribute' => ['id_center' => 'id']],
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
            'id_user' => 'Id User',
            'id_center' => 'Id Center',
            'result' => 'Result',
            'comments' => 'Comments',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Center]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCenter()
    {
        return $this->hasOne(Center::className(), ['id' => 'id_center']);
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
