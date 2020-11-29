<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%center}}".
 *
 * @property int $id
 * @property int $id_provincia
 * @property string $poblacion
 * @property string $name
 * @property int $created_at
 *
 * @property Test[] $tests
 */
class Center extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%center}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_provincia', 'poblacion', 'name', 'created_at'], 'required'],
            [['id_provincia', 'created_at'], 'default', 'value' => null],
            [['id_provincia', 'created_at'], 'integer'],
            [['poblacion', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_provincia' => 'Id Provincia',
            'poblacion' => 'Poblacion',
            'name' => 'Name',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Tests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTests()
    {
        return $this->hasMany(Test::className(), ['id_center' => 'id']);
    }
}
