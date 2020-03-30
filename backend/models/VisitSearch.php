<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * VisitSearch represents the model behind the search form of `backend\models\Visit`.
 */
class VisitSearch extends Visit
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'card_number'], 'integer'],
            [['city_id', 'address_point_id', 'anamnes', 'podolog_id', 'manipulation', 'recommendation', 'next_visit_from', 'next_visit_by', 'has_come', 'description', 'used_photo'], 'safe'],
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
        $query = Visit::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSizeLimit' => [1, 60],
            ],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]// Отсортируем по убыванию
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
            'card_number' => $this->card_number,
            'next_visit_from' => $this->next_visit_from,
            'next_visit_by' => $this->next_visit_by,
            'used_photo' => $this->used_photo
        ]);

        $query->andFilterWhere(['like', 'city', $this->city_id])
            ->andFilterWhere(['like', 'address_point', $this->address_point_id])
            ->andFilterWhere(['like', 'anamnes', $this->anamnes])
            ->andFilterWhere(['like', 'podolog', $this->podolog_id])
            ->andFilterWhere(['like', 'manipulation', $this->manipulation])
            ->andFilterWhere(['like', 'recommendation', $this->recommendation])
            ->andFilterWhere(['like', 'has_come', $this->has_come])
            ->andFilterWhere(['like', 'used_photo', $this->used_photo])
            ->andFilterWhere(['like', 'description', $this->description]);
        return $dataProvider;
    }
}
