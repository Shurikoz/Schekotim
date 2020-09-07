<?php

namespace backend\models;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "problem".
 *
 * @property int $id
 * @property int $number
 * @property string $name
 * @property string $anamnes
 * @property string $manipulation
 * @property string $recommendation
 * @property string $diagnosis
 */

class Problem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'problem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
            [['number', 'anamnes', 'manipulation', 'recommendation', 'diagnosis'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Проблема',
            'anamnes' => 'Анамнез',
            'manipulation' => 'Манипуляции',
            'recommendation' => 'Рекомендации',
            'diagnosis' => 'Диагноз',
            'number' => 'Номер',
        ];
    }

    /**
     * @return int
     */
    public function count(){
        $model = Problem::find()->all();
        $count = count($model);
        return $count;
    }

    public function getNext($number) {
        $next = $this->find()->where(['>', 'number', $number])->orderBy('number asc')->one();
        return $next;
    }

    public function getPrev($number) {
        $prev = $this->find()->where(['<', 'number', $number])->orderBy('number desc')->one();
        return $prev;
    }

    /**
     * передадим на вход номер карты
     * делаем проверку на существование не закрытых проблем и исключаем их.
     * возвращаем список проблем
     * Если есть одна или несколько проблем, которые не отмечены "пациент пришел" или "проблема решена", то они будут удаляться из массива для предотвращения задвоения
     */
    public function listProblem($cardNumber)
    {
        $model = $this::find()->orderBy(['number' => SORT_ASC])->all();
        $problem = ArrayHelper::map($model, 'number', 'name');
        $visit = Visit::find()->where(['card_number' => $cardNumber])->all();
        foreach ($visit as $item) {
            if ($this->checkOpenProblems($item)) {
                unset($problem[$item->problem_id]);
            }
        }
        return $problem;
    }

    public function openProblem($cardNumber)
    {
        $problem = [];
        $visit = Visit::find()->where(['card_number' => $cardNumber])->all();
        foreach ($visit as $item) {
            if ($this->checkOpenProblems($item)) {
                array_push($problem, $item->problem->name);
            }
        }
        return $problem;
    }

    public function checkOpenProblems($visit)
    {
        if (($visit->planned == 1 || $visit->visit_date <= $visit->next_visit_by) && $visit->has_come == 0) {
            return true;
        } else {
            return false;
        }
    }


    public function getVisit()
    {
        return $this->hasOne(Visit::className(), ['problem_id' => 'id']);
    }


}
