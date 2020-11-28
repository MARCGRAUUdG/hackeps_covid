<?php
namespace frontend\models\search;

use frontend\models\ContactForm;
use yii\data\ActiveDataProvider;

class ContactFormSearch extends ContactForm
{
    public function rules()
    {
        return [
            [['name', 'email', 'subject', 'message'], 'string'],
            [['id', 'created_at'], 'number'],
        ];
    }

    public function search($params)
    {
        $query = ContactForm::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['LIKE', 'name', $this->name])
            ->andFilterWhere(['LIKE', 'email', $this->email])
            ->andFilterWhere(['LIKE', 'subject', $this->subject])
            ->andFilterWhere(['LIKE', 'message', $this->message]);

        if (!empty($this->created_at))
        {
            $dateStart = date('Y-m-d', $this->created_at);
            $dateEnd = strtotime('+23 hours +59 minutes +59 seconds', $dateStart);
            $query->andWhere(['BETWEEN', 'created_at', $dateStart, $dateEnd]);
        }

        $query->orderBy(['id' => SORT_ASC]);


        return $dataProvider;
    }
}
