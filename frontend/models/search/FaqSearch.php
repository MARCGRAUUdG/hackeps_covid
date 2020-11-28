<?php
namespace frontend\models\search;

use frontend\models\Faq;
use yii\data\ActiveDataProvider;

class FaqSearch extends Faq
{
    public function rules()
    {
        return [
            [['question', 'answer'], 'string'],
            [['id', 'id_category'], 'number'],
        ];
    }

    public function search($params)
    {
        $query = Faq::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id, 'id_category' => $this->id_category])
            ->andFilterWhere(['LIKE', 'question', $this->question])
            ->andFilterWhere(['LIKE', 'answer', $this->answer]);

        $query->orderBy(['id_category' => SORT_ASC, 'id' => SORT_ASC]);

        return $dataProvider;
    }
}
