<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * VisitSearch represents the model behind the search form of `backend\models\Visit`.
 */
class VisitPlansSearch extends Visit
{

    public function rules()
    {
        return [
            [['id', 'card_number'], 'integer'],
            [['city', 'address_point', 'anamnes', 'podolog_id', 'manipulation', 'recommendation', 'next_visit_from', 'next_visit_by', 'has_come', 'description', 'used_photo', 'problem'], 'safe'],
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
        $query = Visit::find()->where(['planned' => '1'])->with('card', 'city', 'address_point');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSizeLimit' => [1, 60],
            ],
            'sort' => ['defaultOrder' => ['next_visit_from' => SORT_ASC]]// Отсортируем по убыванию
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id
        ]);

        $query->andFilterWhere(['like', 'number', $this->number]);
        return $dataProvider;
    }
}