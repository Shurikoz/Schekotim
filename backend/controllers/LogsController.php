<?php

namespace backend\controllers;

use backend\models\Logs;
use backend\models\LogsSearch;
use yii\data\Pagination;
use yii\web\Controller;
use Yii;

class LogsController extends Controller
{

    public function actionIndex()
    {
        $searchModel = new LogsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $pages = new Pagination(['totalCount' => $dataProvider->getTotalCount(), 'pageSizeLimit' => [1, 60], 'defaultPageSize' => 20]);
        $model = Logs::find()->all();
        return $this->render('logs', [
            'pages' => $pages,
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }

}
