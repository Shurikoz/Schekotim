<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * VisitPlannedSearch represents the model behind the search form of `backend\models\Visit`.
 */
class VisitPlannedSearch extends Visit
{

    public $surname;
    public $name;
    public $middle_name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'number', 'specialist_id', 'card_number', 'city_id', 'address_point_id', 'problem_id', 'dermatolog', 'immunolog', 'ortoped', 'hirurg', 'planned', 'has_come', 'resolve', 'used_photo', 'edit', 'contacted', 'recorded', 'cancel'], 'integer'],
            [['surname', 'name', 'middle_name', 'anamnes', 'manipulation', 'recommendation', 'next_visit_from', 'next_visit_by', 'visit_date', 'visit_time', 'description', 'timestamp'], 'safe'],
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
        $query = Visit::find()->where(['planned' => 1])->andWhere(['<>', 'has_come', 2])->joinWith('card');

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
            'id' => $this->id,
            'number' => $this->number,
            'specialist_id' => $this->specialist_id,
            'card_number' => $this->card_number,
            'city_id' => $this->city_id,
            'address_point_id' => $this->address_point_id,
            'problem_id' => $this->problem_id,
            'dermatolog' => $this->dermatolog,
            'immunolog' => $this->immunolog,
            'ortoped' => $this->ortoped,
            'hirurg' => $this->hirurg,
            'planned' => $this->planned,
            'has_come' => $this->has_come,
            'resolve' => $this->resolve,
            'used_photo' => $this->used_photo,
            'edit' => $this->edit,
            'contacted' => $this->contacted,
            'recorded' => $this->recorded,
            'cancel' => $this->cancel,
        ]);

        $query->andFilterWhere(['like', 'anamnes', $this->anamnes])
            ->andFilterWhere(['like', 'manipulation', $this->manipulation])
            ->andFilterWhere(['like', 'card_number', $this->card_number])
            ->andFilterWhere(['like', 'recommendation', $this->recommendation])
            ->andFilterWhere(['like', 'next_visit_from', $this->next_visit_from])
            ->andFilterWhere(['like', 'next_visit_by', $this->next_visit_by])
            ->andFilterWhere(['like', 'visit_date', $this->visit_date])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'timestamp', $this->timestamp])
            ->andFilterWhere(['like', Card::tableName() . '.surname', $this->surname])
            ->andFilterWhere(['like', Card::tableName() . '.name', $this->name])
            ->andFilterWhere(['like', Card::tableName() . '.middle_name', $this->middle_name]);

        return $dataProvider;
    }
}
