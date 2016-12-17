<?php

namespace app\controllers;

use Yii;
use mPDF;
use app\models\Factura;
use app\models\Facturaitem;
// use app\models\FacturaItem;
use app\models\Identidad;
use app\models\FacturaSearch;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;


class ReportController extends Controller
{


    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Factura models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}