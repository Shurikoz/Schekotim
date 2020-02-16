<?php

namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;


/**
 * Site controller
 */
class PagesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Displays onihomikoz.
     *
     * @return mixed
     */
    public function actionOnihomikoz()
    {
//        $this->view->registerMetaTag([
//            'name' => 'description',
//            'content' => ''
//        ]);

        return $this->render('onihomikoz');
    }

    /**
     * Displays treschini.
     *
     * @return mixed
     */
    public function actionTreschini()
    {
//        $this->view->registerMetaTag([
//            'name' => 'description',
//            'content' => ''
//        ]);

        return $this->render('treschini');
    }

    /**
     * Displays oniholizis.
     *
     * @return mixed
     */
    public function actionOniholizis()
    {
//        $this->view->registerMetaTag([
//            'name' => 'description',
//            'content' => ''
//        ]);

        return $this->render('oniholizis');
    }

    /**
     * Displays nogot.
     *
     * @return mixed
     */
    public function actionNogot()
    {
//        $this->view->registerMetaTag([
//            'name' => 'description',
//            'content' => ''
//        ]);

        return $this->render('nogot');
    }

    /**
     * Displays mozol.
     *
     * @return mixed
     */
    public function actionMozol()
    {
//        $this->view->registerMetaTag([
//            'name' => 'description',
//            'content' => ''
//        ]);

        return $this->render('mozol');
    }

    /**
     * Displays gematomi.
     *
     * @return mixed
     */
    public function actionGematoma()
    {
//        $this->view->registerMetaTag([
//            'name' => 'description',
//            'content' => ''
//        ]);

        return $this->render('gematoma');
    }

    /**
     * Displays borodavki.
     *
     * @return mixed
     */
    public function actionBorodavki()
    {
//        $this->view->registerMetaTag([
//            'name' => 'description',
//            'content' => ''
//        ]);

        return $this->render('borodavki');
    }


}

