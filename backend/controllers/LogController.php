<?php

namespace backend\controllers;

use backend\models\Logs;
use backend\models\LogsSearch;
use yii\data\Pagination;
use yii\web\Controller;
use Yii;

class LogController extends Controller
{

    public function actionIndex()
    {
        $searchModel = new LogsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $pages = new Pagination(['totalCount' => $dataProvider->getTotalCount(), 'pageSizeLimit' => [1, 60], 'defaultPageSize' => 20]);

        return $this->render('index', [
            'pages' => $pages,
            'dataProvider' => $dataProvider
        ]);
    }

}
