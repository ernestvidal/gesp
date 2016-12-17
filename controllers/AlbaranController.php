<?php

namespace app\controllers;

use Yii;
use mPDF;
use app\models\Albaran;
use app\models\Albaranitem;
use app\models\Identidad;
use app\models\AlbaranSearch;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;
use app\models\Factura;
use app\models\Facturaitem;

/**
 * AlbaranController implements the CRUD actions for Albaran model.
 */
class AlbaranController extends Controller {

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
     * Lists all Albaran models.
     * @return mixed
     */
    public function actionIndex($albaranes = NULL, $cliente=Null) {
        if (isset($cliente) != Null){
            $model = Albaran::find()
                    ->where(['cliente_id' => $cliente])
                    ->orderBy('facturador_id, albaran_id DESC')
                    ->all();
            return $this->render('index', [
                        'model' => $model
            ]);
        }elseif (isset($albaranes) == Null) {
            $model = Albaran::find()
                    ->where(['albaran_factura_num' => NULL])
                    ->orderBy('facturador_id, albaran_id DESC')
                    ->all();
            return $this->render('index', [
                        'model' => $model
            ]);
        } else {

            $model = Albaran::find()
                    ->orderBy('facturador_id, albaran_id DESC')
                    ->all();
            return $this->render('index', [
                        'model' => $model
            ]);
        }
    }

    /**
     * Displays a single Albaran model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {

        return $this->render('view', [
                    'model' => $this->findModel($id)
        ]);
    }

    /**
     * Creates a new Albaran model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Albaran();
        $modelItem = new AlbaranItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $data = (Yii::$app->request->getBodyParams());
            /*
             * Esta es la esctructura de datos que tiene que tener el array $data para que se procese.
             *
             * $data['AlbaranItem'][0] = ['albaran_num'=>'12ab', 'item_cantidad'=>10,00, 'item_descripcion'=>'holaa', 'item_precio'=>100,00];
             */

            $count = count($data['AlbaranItem']);
            $models = [new AlbaranItem()];

            for ($i = 1; $i < $count; $i++) {
                $models[$i] = new AlbaranItem();
            }

            if (Model::loadMultiple($models, $data, $formName = 'AlbaranItem') && Model::validateMultiple($models)) {
                foreach ($models as $modelo) {
                    // populate and save records for each model
                    if ($modelo->save(false)) {
                        // do something here after saving
                        $count++;
                    }
                }
            } else {
                foreach ($models as $modelo) {
                    $errores = $modelo->getErrors();
                    var_dump($errores);
                    // populate and save records for each model
                }
            }
            return $this->redirect(['view', 'id' => $model->albaran_id]);
        } else {
            return $this->render('albaran', [
                        'model' => $model,
                        'modelItem' => $modelItem,
            ]);
        }
    }

    /**
     * Updates an existing Albaran model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        /* Código original acción update

          $model = $this->findModel($id);
          if ($model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['view', 'id' => $model->albaran_id]);
          } else {
          return $this->render('update', [
          'model' => $model,
          ]);
          }
         */

        $model = $this->findModel($id);
        $models = $model['albaranitems'];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $data = (Yii::$app->request->getBodyParams());
            /*
             * Esta es la esctructura de datos que tiene que tener el array $data para que se procese.
             *
             * $data['AlbaranItem'][0] = ['albaran_num'=>'12ab', 'item_cantidad'=>10,00, 'item_descripcion'=>'holaa', 'item_precio'=>100,00];
             */

            $count = count($data['AlbaranItem']);
            //$models = [new AlbaranItem()];

            /*
              for($i = 1; $i < $count; $i++) {
              $models[$i] = new AlbaranItem();
              }
             */
            if (Model::loadMultiple($models, $data, $formName = 'AlbaranItem') && Model::validateMultiple($models)) {
                foreach ($models as $modelo) {
                    // populate and save records for each model
                    if ($modelo->save(false)) {
                        // do something here after saving
                        $count++;
                    }
                }
            } else {
                foreach ($models as $modelo) {
                    $errores = $modelo->getErrors();
                    var_dump($errores);
                    // populate and save records for each model
                }
            }
            return $this->redirect(['view', 'id' => $model->albaran_id]);
        } else {
            return $this->render('_albaran', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Albaran model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Albaran model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Albaran the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Albaran::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPrintalbaran($id) {
        $footer = ' 
            
                <table style="width: 100%">
                    <tr>
                        <td style="text-align: center">Por tu caja bonita, slu </td>
                    </tr>
                    <tr>
                        <td style="text-align: center">Nou d\'octubre, 11,1 / 46815 La Llosa de Ranes / Valencia</td>
                    </tr>
                    <tr>
                        <td style="text-align: center"><h3>96 062 71 32</h3></td>
                    </tr>
                    
                </table> ';

        $this->layout = 'viewLayout';
        $mpdf = new mPDF('UTF-8', 'A4', '', '', 15, 15, 15, 0, '', 5, 'P');
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($this->render('view', ['model' => $this->findModel($id)]));
        $albaranPdf = $mpdf->Output('albaran.pdf', 'D');
    }

    public function actionSendalbaran($id) {
        // Recogemos los datos enviados desde modalSendAlbaran form.
        $datosmodel = Yii::$app->request->post();
        $mailto = $datosmodel['Identidad']['mail'];
        $asunto = $datosmodel['Identidad']['asunto'];
        $body = $datosmodel['Identidad']['body'];

        $this->layout = 'viewLayout';
        $mpdf = new mPDF('UTF-8', 'A4', '', '', 10, 10, 20, 20, '', '', 'P');
        $mpdf->WriteHTML($this->render('view', ['model' => $this->findModel($id)]));
        $albaranPdf = $mpdf->Output('albaran.pdf', 'S');


        $message = Yii::$app->mailer->compose()
                ->setFrom('ernest@portucajabonita.com')
                ->setTo($mailto)
                ->setSubject($asunto)
                ->setTextBody($body)
                ->setHtmlBody($body)
                ->attachContent($albaranPdf, ['fileName' => 'albaran.pdf', 'contentType' => 'application/pdf'])
                ->send();

        //exit;

        return $this->redirect(['index']);
    }

    public function actionModalfacturar($id) {
        $model = $this->findModel($id);

        if ($model->albaran_factura_num <> NULL) {
            echo 'this albarán is factured';
        } else {
            return $this->renderAjax('modalFacturarAlbaran', [
                        //'model' => $model,
                        'numAlbaran' => $id,
            ]);
        }
    }

    public function actionFacturar() {
        /**
         * Recogemos los datos enviados desde el formulario modalFacturaAlbaran.php
         * Luego cargamos el alabarán con el id correspondiente
         * 
         */
        $fecha_factura;
        $num_factura;
        $num_albaran;

        $data_request = Yii::$app->request->post();
        $num_albaran = $data_request['albaran_id'];
        $fecha_factura = $data_request['fecha_factura'];
        $num_factura = $data_request['num_factura'];
        $model = $this->findModel($num_albaran);
        $modelItems =$model['albaranitems'];
        $fModel = new Factura();
        $fModel->factura_num = $num_factura;
        $fModel->factura_fecha = $fecha_factura;
        $fModel->facturador_id = $model->facturador_id;
        $fModel->cliente_id = $model->cliente_id;
        $fModel->factura_rate_descuento = $model->albaran_rate_descuento;
        $fModel->factura_rate_iva = 21;
        $fModel->factura_rate_irpf = $model->albaran_rate_irpf;
        $fModel->forma_pago =  ($model['cliente']['identidad_forma_pago'] <> Null)? $model['cliente']['identidad_forma_pago']:'';
        $fModel->factura_cta = $model['cliente']['identidad_cta'];
        $fModel->save();
        //var_dump($modelItems);
        
        /**
         * Insertamos el número de albarán y la fecha en los items de la factura.
         * Lo hacemos de este modo porqué el foreach siguiente solo cuenta las líneas del albarán
         */
        $fModelItems = new Facturaitem();
        $fModelItems->factura_num = $num_factura;
        $fModelItems->item_cantidad = 0;
        $fModelItems->item_descripcion = 'Albarán núm.: ' . $model->albaran_num . ' / ' . Yii::$app->formatter->asDate($model->albaran_fecha, 'dd-MM-yyyy') ;
        $fModelItems->item_precio = 0;
        if ($fModelItems->validate()){
            $fModelItems->save();
        }else{
            $fModel->getErrors();
        }
        
        foreach ($modelItems as $albaranItems){
            $fModelItems = new Facturaitem();
            $fModelItems->factura_num = $num_factura;
            $fModelItems->item_cantidad = $albaranItems->item_cantidad;
            $fModelItems->item_descripcion = $albaranItems->item_descripcion;
            $fModelItems->item_precio = $albaranItems->item_precio;
            $fModelItems->save();
        }
        // Guardamos en el albarán el número de la factura para saber que está facturado
        $model->albaran_factura_num = $num_factura;
        if ($model->validate()){
            $model->save();
            $this->redirect('@web/factura/index');
        }else{
            $model->getErrors();
        }
    }

}
