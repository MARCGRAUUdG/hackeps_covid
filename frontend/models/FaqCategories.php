<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%faq_categories}}".
 *
 * @property int $id
 * @property string $category
 *
 * @property Faq[] $faqs
 */
class FaqCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%faq_categories}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category'], 'required'],
            [['category'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
        ];
    }

    /**
     * Gets query for [[Faqs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaqs()
    {
        return $this->hasMany(Faq::className(), ['id_category' => 'id']);
    }
}
