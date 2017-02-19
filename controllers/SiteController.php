<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Presupuesto;
use app\models\presupuestoSearch;
use app\models\Factura;
use app\models\facturaSearch;
use app\models\Albaran;
use app\models\albaranSearch;
use app\models\Pedido;
use app\models\pedidoSearch;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout','index'],
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

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        //$this->layout = 'main-fluid';

        $presupuestoSearchModel = new PresupuestoSearch();
        $presupuestoProvider = $presupuestoSearchModel->search(Yii::$app->request->queryParams);
        $presupuestoProvider->pagination->pageSize=5;
        
        $facturaSearchModel = new FacturaSearch();
        $facturaProvider = $facturaSearchModel->search(Yii::$app->request->queryParams);
        $facturaProvider->pagination->pageSize=5;
        
        $albaranSearchModel = new AlbaranSearch();
        $albaranProvider = $albaranSearchModel->search(Yii::$app->request->queryParams);
        $albaranProvider->pagination->pageSize=5;
        
        $pedidoSearchModel = new PedidoSearch();
        $pedidoProvider = $pedidoSearchModel->search(Yii::$app->request->queryParams);
        $pedidoProvider->pagination->pageSize=5;
        

        return $this->render('index', [
            'searchModel' => $presupuestoSearchModel,
            'dataProvider' => $presupuestoProvider,
            'factura_searchModel' => $facturaSearchModel,
            'factura_dataProvider' => $facturaProvider,
            'albaran_searchModel' => $albaranSearchModel,
            'albaran_dataProvider' => $albaranProvider,
            'pedido_searchModel'=> $pedidoSearchModel,
            'pedido_dataProvider' => $pedidoProvider
        ]);
        
        
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
    
}
