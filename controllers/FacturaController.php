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

/**
 * FacturaController implements the CRUD actions for Factura model.
 */
class FacturaController extends Controller {

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
        $model = Factura::find()
                ->orderBy('facturador_id, factura_num DESC')
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
        $model = new Factura();
        $modelItem = new FacturaItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $data = (Yii::$app->request->getBodyParams());
            /*
             * Esta es la esctructura de datos que tiene que tener el array $data para que se procese.
             *
             * $data['FacturaItem'][0] = ['factura_num'=>'12ab', 'item_cantidad'=>10,00, 'item_descripcion'=>'holaa', 'item_precio'=>100,00];
             */

            $count = count($data['FacturaItem']);
            $models = [new FacturaItem()];

            for ($i = 1; $i < $count; $i++) {
                $models[$i] = new FacturaItem();
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
            return $this->redirect(['view', 'id' => $model->factura_id]);
        } else {
            return $this->render('factura', [
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
      return $this->redirect(['view', 'id' => $model->factura_id]);
      } else {
      return $this->render('factura', [
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
        /* Código original acción update

          $model = $this->findModel($id);
          if ($model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['view', 'id' => $model->factura_id]);
          } else {
          return $this->render('update', [
          'model' => $model,
          ]);
          }
         */

        $model = $this->findModel($id);
        $models = $model['facturaitems'];



        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $data = (Yii::$app->request->getBodyParams());
            /*
             * Esta es la esctructura de datos que tiene que tener el array $data para que se procese.
             *
             * $data['FacturaItem'][0] = ['factura_num'=>'12ab', 'item_cantidad'=>10,00, 'item_descripcion'=>'holaa', 'item_precio'=>100,00];
             */

            $count = count($data['FacturaItem']);


            //$models = [new FacturaItem()];

            /*
              for($i = 1; $i < $count; $i++) {
              $models[$i] = new FacturaItem();
              }
             */
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
            return $this->redirect(['view', 'id' => $model->factura_id]);
        } else {
            return $this->render('_factura', [
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
        if (($model = Factura::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPrintfactura($id) {
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
        $facturaPdf = $mpdf->Output('factura.pdf', 'D');
    }

    public function actionSendfactura($id) {
        // Recogemos los datos enviados desde modalSendFactura form.
        $datosmodel = Yii::$app->request->post();
        $mailto = $datosmodel['Identidad']['mail'];
        $asunto = $datosmodel['Identidad']['asunto'];
        $body = $datosmodel['Identidad']['body'];

        $this->layout = 'viewLayout';
        $mpdf = new mPDF('UTF-8', 'A4', '', '', 10, 10, 20, 20, '', '', 'P');
        $mpdf->WriteHTML($this->render('view', ['model' => $this->findModel($id)]));
        $facturaPdf = $mpdf->Output('factura.pdf', 'S');


        $message = Yii::$app->mailer->compose()
                ->setFrom('ernest@portucajabonita.com')
                ->setTo($mailto)
                ->setSubject($asunto)
                ->setTextBody($body)
                ->setHtmlBody($body)
                ->attachContent($facturaPdf, ['fileName' => 'factura.pdf', 'contentType' => 'application/pdf'])
                ->send();

        //exit;

        return $this->redirect(['index']);
    }

    public function actionModalsendfactura($id) {
        $modelFactura = $this->findModel($id);

        $model = Identidad::findOne($modelFactura->cliente_id);
        return $this->renderAjax('modalSendFactura', [
                    'model' => $model,
                    'numFactura' => $id,
        ]);
    }

    public function actionReportfacturascliente($id) {
        $model = Factura::find()
                ->where (['cliente_id'=> $id])
                ->orderBy('factura_fecha ASC')
                ->all();
        return $this->render('reportFacturasCliente', [
                    'model' => $model
        ]);
    }

}