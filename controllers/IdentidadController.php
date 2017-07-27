<?php

namespace app\controllers;

use Yii;
use app\models\Identidad;
use app\models\IdentidadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Factura;
use app\models\Cargo;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * IdentidadController implements the CRUD actions for Identidad model.
 */
class IdentidadController extends Controller {

    public function behaviors() {
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
     * Lists all Identidad models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new IdentidadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Identidad model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {

        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Identidad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($submit = false) {
        /*
          $model = new Identidad();

          if ($model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['view', 'id' => $model->identidad_id]);
          } else {
          return $this->render('create', [
          'model' => $model,
          ]);
          }
         * 
         */


        $model = new Identidad();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $submit == false) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $model->refresh();
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'message' => '¡Éxito!',
                ];
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }

        return $this->renderAjax('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Identidad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {

        $model = $this->findModel($id);
        $modelCargo = Cargo::find()->where(['cargo_identidad_id' => $id])->all();
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->identidad_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'modelCargo' => $modelCargo,
            ]);
        }
    }

    /**
     * Deletes an existing Identidad model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionOverview($id) {
        $facturaModel = Factura::find()
                ->where('cliente_id =' . $id)
                ->orderBy('factura_fecha ASC')
                ->all();

        return $this->render('overview', [
                    'facturaModel' => $facturaModel
        ]);
    }

    /**
     * Finds the Identidad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Identidad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Identidad::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
