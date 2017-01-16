<?php

namespace app\controllers;

use Yii;
use mPDF;
use app\models\Proforma;
use app\models\Proformaitem;
// use app\models\FacturaItem;
use app\models\Identidad;
use app\models\ProformaSearch;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;

/**
 * FacturaController implements the CRUD actions for Factura model.
 */
class ProformaController extends Controller {

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
     * Lists all Factura models.
     * @return mixed
     */
    public function actionIndex() {
        $model = Proforma::find()
                ->orderBy('facturador_id, proforma_num DESC')
                ->all();
        return $this->render('index', [
                    'model' => $model
        ]);
    }

    /**
     * Displays a single Factura model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {

        return $this->render('view', [
                    'model' => $this->findModel($id)
        ]);
    }

    /**
     * Creates a new Factura model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Proforma();
        $modelItem = new ProformaItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $data = (Yii::$app->request->getBodyParams());
            /*
             * Esta es la esctructura de datos que tiene que tener el array $data para que se procese.
             *
             * $data['FacturaItem'][0] = ['proforma_num'=>'12ab', 'item_cantidad'=>10,00, 'item_descripcion'=>'holaa', 'item_precio'=>100,00];
             */

            $count = count($data['FacturaItem']);
            $models = [new ProformaItem()];

            for ($i = 1; $i < $count; $i++) {
                $models[$i] = new ProformaItem();
            }

            if (Model::loadMultiple($models, $data, $formName = 'FacturaItem') && Model::validateMultiple($models)) {
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
            return $this->redirect(['view', 'id' => $model->proforma_id]);
        } else {
            return $this->render('proforma', [
                        'model' => $model,
                        'modelItem' => $modelItem,
            ]);
        }
    }

    /*
     * Código original para la acción create creado por guii
     *
     *
      if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->proforma_id]);
      } else {
      return $this->render('proforma', [
      'model' => $model,
      ]);
      }
     */

    /**
     * Updates an existing Factura model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {

        $model = $this->findModel($id);
        $models = $model['proformaitems'];
        $counter_models = count($models);


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $data = (Yii::$app->request->getBodyParams());
            /*
             * Esta es la esctructura de datos que tiene que tener el array $data para que se procese.
             *
             * $data['FacturaItem'][0] = ['proforma_num'=>'12ab', 'item_cantidad'=>10,00, 'item_descripcion'=>'holaa', 'item_precio'=>100,00];
             */

            $count = count($data['ProformaItem']);
            $diferencia = $count - $counter_models;
            if ($diferencia > 0) {
                for ($i = $counter_models; $i < $diferencia + $counter_models; $i++) {
                    $models[$i] = new ProformaItem();
                }
            }

            //$models = [new FacturaItem()];

            /*
              for($i = 1; $i < $count; $i++) {
              $models[$i] = new FacturaItem();
              }
             */
            if (Model::loadMultiple($models, $data, $formName = 'ProformaItem') && Model::validateMultiple($models)) {
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
            return $this->redirect(['view', 'id' => $model->proforma_id]);
        } else {
            return $this->render('_proforma', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Factura model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Factura model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Factura the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Proforma::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPrintproforma($id) {
        $footer = ' 

              <table style="width: 100%">
                  <tr>
                      <td style="text-align: center">Por tu caja bonita, slu </td>
                  </tr>
                  <tr>
                      <td style="text-align: center">Nou d\'octubre, 11,1 / 46815 La Llosa de Ranes / Valencia</td>
                  </tr>
                  <tr><td style="text-align: center">Nif.: B98802622</td></tr>
                  <tr>
                      <td style="text-align: center"><h3>96 062 71 32</h3></td>
                  </tr>
                  <tr>
                    <td style="text-align: center"><h5>Inscrita en el registro mercantil de Valencia, tomo 10073, Libro 7355, Folio 76, Sección GNE, Hoja 169087</td></h5>
                    </tr>

              </table> ';



        $this->layout = 'viewLayout';
        $mpdf = new mPDF('UTF-8', 'A4', '', '', 15, 15, 15, 40, '', 5, 'P');
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($this->render('view', ['model' => $this->findModel($id)]));
        $proformaPdf = $mpdf->Output('proforma.pdf', 'D');
    }

    public function actionSendproforma($id) {
        // Recogemos los datos enviados desde modalSendFactura form.
        $datosmodel = Yii::$app->request->post();
        $mailto = $datosmodel['Identidad']['mail'];
        $asunto = $datosmodel['Identidad']['asunto'];
        $body = $datosmodel['Identidad']['body'];

        $this->layout = 'viewLayout';
        $mpdf = new mPDF('UTF-8', 'A4', '', '', 10, 10, 20, 20, '', '', 'P');
        $mpdf->WriteHTML($this->render('view', ['model' => $this->findModel($id)]));
        $proformaPdf = $mpdf->Output('proforma.pdf', 'S');


        $message = Yii::$app->mailer->compose()
                ->setFrom('ernest@portucajabonita.com')
                ->setTo($mailto)
                ->setSubject($asunto)
                ->setTextBody($body)
                ->setHtmlBody($body)
                ->attachContent($proformaPdf, ['fileName' => 'proforma.pdf', 'contentType' => 'application/pdf'])
                ->send();

        //exit;

        return $this->redirect(['index']);
    }

    public function actionModalsendproforma($id) {
        $modelFactura = $this->findModel($id);

        $model = Identidad::findOne($modelFactura->cliente_id);
        return $this->renderAjax('modalSendFactura', [
                    'model' => $model,
                    'numFactura' => $id,
        ]);
    }

    public function actionReportproformascliente($id) {
        $model = Factura::find()
                ->where(['cliente_id' => $id])
                ->orderBy('proforma_fecha ASC')
                ->all();
        return $this->render('reportFacturasCliente', [
                    'model' => $model
        ]);
    }

    public function actionCopiarproforma($id) {
        $model = $this->findModel($id);

        return $this->renderAjax('copiarProforma', [
                    //'model' => $model,
                    'numProforma' => $id,
        ]);
    }

    public function actionCopiar() {
        /**
         * Recogemos los datos enviados desde el formulario copiarProforma.php
         * Luego cargamos la proforma que queremos copiar
         * 
         */
        $fecha_proforma;
        $num_proforma;
        $num_proforma_id;

        $data_request = Yii::$app->request->post();
        $num_proforma_id = $data_request['proforma_id'];
        $fecha_proforma = $data_request['fecha_proforma'];
        $num_proforma = $data_request['numero_proforma'];
        $model = $this->findModel($num_proforma_id);
        $modelItems = $model['proformaitems'];
        $fModel = new Proforma();
        $fModel->proforma_num = $num_proforma;
        $fModel->proforma_fecha = $fecha_proforma;
        $fModel->facturador_id = $model->facturador_id;
        $fModel->cliente_id = $model->cliente_id;
        $fModel->proforma_rate_descuento = $model->proforma_rate_descuento;
        $fModel->proforma_rate_iva = 21;
        $fModel->proforma_rate_irpf = $model->proforma_rate_irpf;
        $fModel->proforma_forma_pago = ($model['cliente']['identidad_forma_pago'] <> Null) ? $model['cliente']['identidad_forma_pago'] : '';
        $fModel->proforma_cta = $model['cliente']['identidad_cta'];
        $fModel->save();
          
        
        //var_dump($modelItems);

        /**
         * Insertamos el número de albarán y la fecha en los items de la factura.
         * Lo hacemos de este modo porqué el foreach siguiente solo cuenta las líneas del albarán
         */
        /*
        $fModelItems = new Proformaitem();
        $fModelItems->proforma_num = $num_proforma;
        $fModelItems->item_cantidad = 0;
        //$fModelItems->item_descripcion = 'Albarán núm.: ' . $model->albaran_num . ' / ' . Yii::$app->formatter->asDate($model->albaran_fecha, 'dd-MM-yyyy');
        $fModelItems->item_precio = 0;
        if ($fModelItems->validate()) {
            $fModelItems->save();
        } else {
            $fModel->getErrors();
        }
*/
        foreach ($modelItems as $proformaItems) {
            $fModelItems = new Proformaitem();
            $fModelItems->proforma_num = $num_proforma;
            $fModelItems->item_cantidad = $proformaItems->item_cantidad;
            $fModelItems->item_descripcion = $proformaItems->item_descripcion;
            $fModelItems->item_precio = $proformaItems->item_precio;
            $fModelItems->save();
        }
    }

}
