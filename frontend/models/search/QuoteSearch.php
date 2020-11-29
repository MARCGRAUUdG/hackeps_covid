<?php
namespace frontend\models\search;

use common\models\User;
use frontend\models\Quote;
use Yii;
use yii\data\ActiveDataProvider;

class QuoteSearch extends Quote
{
    public function rules()
    {
        return [
            [['message', 'created_at'], 'string'],
            [['id_user', 'id_expert', 'status'], 'number'],
        ];
    }

    public function search($params)
    {
        $query = Quote::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $role = Yii::$app->user->identity->role;

        if ($role == User::ROLE_USER) {
            $query->andWhere(['id_user' => Yii::$app->user->id]);
        }

        else if ($role == User::ROLE_EXPERT) {
            $query->andWhere(['id_expert' => Yii::$app->user->id]);
        }

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id_user' => $this->id_user])
            ->andFilterWhere(['id_expert' => $this->id_expert])
            ->andFilterWhere(['id' => $this->id, 'status' => $this->status]);

        if (!empty($this->created_at))
        {
            $dateStart = strtotime($this->created_at);
            $dateEnd = strtotime('+23 hours +59 minutes +59 seconds', $dateStart);

            $query->andWhere(['BETWEEN', 'created_at', $dateStart, $dateEnd]);
        }

        $query->orderBy(['status' => SORT_ASC, 'date_created' => SORT_ASC]);

        return $dataProvider;
    }
}
