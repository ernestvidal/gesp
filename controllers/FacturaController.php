<?php

namespace app\controllers;

use Yii;
use mPDF;
use app\models\Factura;
use app\models\Facturaitem;
use app\models\Identidad;
//use app\models\FacturaSearch;
//use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;
use yii\bootstrap\Alert;

/**
 * FacturaController implements the CRUD actions for Factura model.
 */
class FacturaController extends Controller {

    public $footer = ' 

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
    public function actionView($id, $modo_vista = NULL) {

        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'modo_vista' => $modo_vista,
                    'id' => $id
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

        $model = $this->findModel($id);
        $models = $model['facturaitems'];
        $counter_models = count($models);


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $data = (Yii::$app->request->getBodyParams());
            /*
             * Esta es la esctructura de datos que tiene que tener el array $data para que se procese.
             *
             * $data['FacturaItem'][0] = ['factura_num'=>'12ab', 'item_cantidad'=>10,00, 'item_descripcion'=>'holaa', 'item_precio'=>100,00];
             */

            /**
             * Cuando queremos añadir un nuevo registro en el escenario de edición o update.
             * Calculamos la diferencia entre los modelos guardados y los modelos editados y la diferencia nos permite saber
             * cuantos modelos nuevos tenemos que crear
             */
            $count = count($data['FacturaItem']);
            $diferencia = $count - $counter_models;
            if ($diferencia > 0) {
                for ($i = $counter_models; $i < $diferencia + $counter_models; $i++) {
                    $models[$i] = new FacturaItem();
                }
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

    public function actionPrintfactura($id, $num, $name) {
        $this->layout = 'viewLayout';
        $mpdf = new mPDF('UTF-8', 'A4', '', '', 10, 10, 15, 40, '', 5, 'P');
        $mpdf->SetHTMLFooter($this->footer);
        $mpdf->WriteHTML($this->render('view', ['model' => $this->findModel($id), 'modo_vista'=>'Imprimir']));
        $facturaPdf = $mpdf->Output('factura.pdf', 'I');
        $facturaPdf = $mpdf->Output('../../../mis documentos/portucajabonita/facturas/2017/' . $num . ' ' . $name . '.pdf', 'F');
    }

    public function actionSendfactura($id, $num, $name) {

        // Recogemos los datos enviados desde modalSendFactura form.
        $datosmodel = Yii::$app->request->post();
        $mailto = $datosmodel['Identidad']['identidad_mail'];
        $asunto = $datosmodel['Identidad']['asunto'];
        $body = $datosmodel['Identidad']['body'];

        $this->layout = 'viewLayout';
        $mpdf = new mPDF('UTF-8', 'A4', '', '', 15, 15, 15, 40, '', 5, 'P');
        $mpdf->SetHTMLFooter($this->footer);
        $mpdf->WriteHTML($this->render('view', ['model' => $this->findModel($id)]));
        //$facturaPdf = $mpdf->Output('../../../mis documentos/portucajabonita/facturas/2017/' . $num . ' ' . $name .'.pdf', 'S');
        $facturaPdf = $mpdf->Output('', 'S');



        $message = Yii::$app->mailer->compose()
                ->setFrom('admin@portucajabonita.com')
                ->setTo($mailto)
                ->setSubject($asunto)
                ->setTextBody($body)
                ->setHtmlBody($body)
                ->setReadReceiptTo('admin@portucajabonita.com')
                ->attachContent($facturaPdf, ['fileName' => $num . ' ' . $name . '.pdf', 'contentType' => 'application/pdf']);
        //->send();
        $result = Yii::$app->mailer->send($message);





        //En el  paso anterior generamos el pdf que aduntamos al correo y enviamos al cliente. En dicho paso no se guarda en 
        //el sistema local de archivos porque al mandarlo como adjunto, lo manda como si fuese un fichero vacio. Por eso en este paso
        //en el cual nos auto enviamos el correo a nuestra bandeja de saida para tener una copia de los mails enviados y dado 
        //que en el paso anterior, no hemos guardado el pdf, lo volvemos a generar y lo adjuntamos de nuevo. De momento es lo 
        //que me funciona.

        if ($result == TRUE) {

            $confirmationFrom = 'admin@portucajabonita.com';
            $facturaPdf = $mpdf->Output('../../../mis documentos/portucajabonita/facturas/2017/' . $num . ' ' . $name . '.pdf', 'F');
            $subject = "$asunto";
            $stream = imap_open("{cp193.webempresa.eu/novalidate-cert}INBOX.Sent", "admin@portucajabonita.com", "adminprT204249");
            $boundary = "------=" . md5(uniqid(rand()));
            $header = "MIME-Version: 1.0\r\n";
            $header .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
            $header .= "Disposition-Notification-To: $confirmationFrom\r\n";
            $header .= "X-Confirm-Reading-To: $confirmationFrom\r\n";
            $header .= "Read-Receipt-To: $confirmationFrom\r\n";
            $header .= "\r\n";
            $file = "../../../mis documentos/portucajabonita/facturas/2017/" . $num . " " . $name . ".pdf";
            $filename = $num . " " . $name . ".pdf";
            $ouv = fopen("$file", "rb");
            $lir = fread($ouv, filesize("$file"));
            fclose($ouv);
            $attachment = chunk_split(base64_encode($lir));
            $msg2 .= "--$boundary\r\n";
            $msg2 .= "Content-Transfer-Encoding: base64\r\n";
            $msg2 .= "Content-Type: application/pdf; name=\"$filename\"\r\n";
            $msg2 .= "Content-Disposition: attachment; filename=\"$filename\"\r\n";
            $msg2 .= "\r\n";
            $msg2 .= $attachment . "\r\n";
            $msg2 .= "\r\n\r\n";
            $cuerpo .= "--$boundary\r\n";
            $cuerpo .= "Content-Type: text/html;\r\n\tcharset=\"ISO-8859-1\"\r\n";
            $cuerpo .= "Content-Transfer-Encoding: 8bit \r\n";
            $cuerpo .= "\r\n\r\n";
            $cuerpo .= "$body\r\n";
            $cuerpo .= "\r\n\r\n";
            $msg3 .= "--$boundary--\r\n";
            imap_append($stream, "{cp193.webempresa.eu/novalidate-cert}INBOX.Sent", "From: admin@portucajabonita.com\r\n" . "To: $mailto\r\n" . "Subject: $subject\r\n" . "$header\r\n" . "$cuerpo\r\n" . "$msg2\r\n" . "$msg3\r\n");
            imap_close($stream);

            // Guardamos en la base de datos la fecha de envío

            $model = $this->findModel($id);
            $model->factura_fecha_envio = Yii::$app->formatter->asDate('now', 'yyyy-MM-dd');
            $model->save();

            return $this->redirect(['index']);
        } else {

            return $this->redirect(['index']);
        }
    }

    public function actionModalsendfactura($id, $num, $name) {
        $modelFactura = $this->findModel($id);

        $model = Identidad::findOne($modelFactura->cliente_id);

        return $this->renderAjax('modalSendFactura', [
                    'model' => $model,
                    'idFactura' => $id,
                    'numFactura' => $num,
                    'name' => $name,
                    'cliente_id' => $model->identidad_id,
        ]);
    }

    public function actionReportfacturascliente($id) {
        $model = Factura::find()
                ->where(['cliente_id' => $id])
                ->orderBy('factura_fecha ASC')
                ->all();
        return $this->render('reportFacturasCliente', [
                    'model' => $model
        ]);
    }
    
    /**
     * 
     * Función que guarda la fecha en la que hemos verificado que nuestro
     * cliente ha recibido nuestra factura.
     */
    
     public function actionConfirmacionrecepcion($id){
         
        $model = $this->findModel($id);
        $model->factura_fecha_recepcion = date('Y-m-d');
        if ($model->validate()){
            $model->save();
            return $this->redirect('@web/factura/index');
        } else {
            $model->getErrors();
        }        
    }

}
