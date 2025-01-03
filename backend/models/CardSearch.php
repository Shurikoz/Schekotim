<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CardSearch represents the model behind the search form of `backend\models\Card`.
 */
class CardSearch extends Card
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'number'], 'integer'],
            [['city_id', 'address_point_id', 'name', 'surname', 'middle_name', 'birthday', 'created_at'], 'safe'],
            [['name', 'surname', 'middle_name', 'number'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
//        $query = Card::find()->with('addressPoint', 'city');
        $query = Card::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSizeLimit' => [1, 60],
            ],
            'sort' => ['defaultOrder' => ['number' => SORT_DESC]]// Отсортируем по убыванию
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'number' => $this->number,
            'created_at' => $this->created_at,
            'city_id' => $this->city_id,
            'address_point_id' => $this->address_point_id,
        ]);

//        ->andFilterWhere(['like', City::tableName() . '.id', $this->city])

        $query
//            ->andFilterWhere(['like', 'city_id', $this->city_id])
//            ->andFilterWhere(['like', 'address_point_id', $this->address_point_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', Card::tableName() . '.birthday', $this->birthday]);
        return $dataProvider;
    }
}
