<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PhotoVisitSearch represents the model behind the search form of `backend\models\PhotoVisit`.
 */
class PhotoSearch extends Visit
{

    public $problem;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'number', 'card_number'], 'integer'],
            [['city', 'address_point', 'anamnes', 'specialist_id', 'manipulation', 'recommendation', 'next_visit_from', 'next_visit_by', 'has_come', 'description', 'used_photo', 'problem'], 'safe'],
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

        $query = Visit::find()->where(['has_come' => '1'])->joinWith('problem');

//        $query = Visit::find()->select(['visit.*', 'COUNT(photo.id) AS visitsCount'])->joinWith('photo')->groupBy('visit.id')->joinWith('problem');

//        $query = Visit::find()->select('visit.*')->join('INNER JOIN', 'photo','photo.visit_id = visit.id')->joinWith('problem');

//        $query = Visit::find()->select('visit.*')->leftJoin('photo', '`photo`.`visit_id` = `visit`.`id`')->joinWith('problem');

//        $query = Visit::find()->select(['{{visit}}.*', 'COUNT({{photo}}.id) AS visitCount'])->joinWith('photo')->groupBy('{{photo}}.id')->joinWith('problem');
//        $customers = Customer::find()->select(['{{customer}}.*', 'COUNT({{order}}.id) AS ordersCount'])->joinWith('orders')->groupBy('{{customer}}.id')->all();

//        $customers = Customer::find()->select('customer.*')->leftJoin('order', '`order`.`customer_id` = `customer`.`id`')->where(['order.status' => Order::STATUS_ACTIVE])->with('orders')->all();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSizeLimit' => [1, 40],
                'defaultPageSize' => 10,
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

        $query->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'address_point', $this->address_point])
            ->andFilterWhere(['like', 'specialist', $this->specialist_id])
            ->andFilterWhere(['like', Visit::tableName() . '.number', $this->number])
            ->andFilterWhere(['like', Problem::tableName() . '.id', $this->problem])
            ->andFilterWhere(['like', 'has_come', $this->has_come])
            ->andFilterWhere(['like', 'used_photo', $this->used_photo])
            ->andFilterWhere(['like', 'description', $this->description]);
        return $dataProvider;
    }
}
