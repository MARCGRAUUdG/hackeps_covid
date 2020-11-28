<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%faq}}".
 *
 * @property int $id
 * @property int $id_category
 * @property string $question
 * @property string $answer
 *
 * @property FaqCategories $category
 */
class Faq extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%faq}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_category', 'question', 'answer'], 'required'],
            [['id_category'], 'default', 'value' => null],
            [['id_category'], 'integer'],
            [['question', 'answer'], 'string', 'max' => 255],
            [['id_category'], 'exist', 'skipOnError' => true, 'targetClass' => FaqCategories::className(), 'targetAttribute' => ['id_category' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_category' => 'Categoría',
            'question' => 'Pregunta',
            'answer' => 'Respuesta',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(FaqCategories::className(), ['id' => 'id_category']);
    }
}
