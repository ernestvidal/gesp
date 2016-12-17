<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class WebservicesController extends Controller
{
    public function actionIndex()
    {
        return $this->render('customers');
    }

}
