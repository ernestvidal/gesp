<?php

namespace app\controllers;

use Yii;
use mPDF;
use app\models\Pedido;
use app\models\Pedidoitem;
// use app\models\FacturaItem;
use app\models\Identidad;
use app\models\PedidoSearch;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;

/**
 * PedidoController implements the CRUD actions for Pedido model.
 */
class PedidoController extends Controller
{

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
     * Lists all Pedido models.
     * @return mixed
     */
    public function actionIndex($pedidos = NULL)
    {
         if (isset($pedidos) <> 'pendientes') {
            $model = Pedido::find()
                    ->where(['pedido_factura_num' => 'pendiente'])
                    ->orderBy('facturador_id, pedido_num DESC')
                    ->all();
            return $this->render('index', [
                        'model' => $model
            ]);
        } else {

            $model = Pedido::find()
                    ->orderBy('facturador_id, pedido_num DESC')
                    ->all();
            return $this->render('index', [
                        'model' => $model
            ]);
        }
    }

    /**
     * Displays a single Pedido model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id, $modo_vista = NULL)
    {

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modo_vista' => $modo_vista,
            'id' => $id
        ]);
    }

    /**
     * Creates a new Pedido model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pedido();
        $modelItem = new PedidoItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()){
            $data = (Yii::$app->request->getBodyParams());
            /*
             * Esta es la esctructura de datos que tiene que tener el array $data para que se procese.
             *
             * $data['PedidoItem'][0] = ['pedido_num'=>'12ab', 'item_cantidad'=>10,00, 'item_descripcion'=>'holaa', 'item_precio'=>100,00];
             */

            $count = count($data['PedidoItem']);
            $models = [new PedidoItem()];

            for($i = 1; $i < $count; $i++) {
                $models[$i] = new PedidoItem();
            }

            if ( Model::loadMultiple($models, $data, $formName = 'PedidoItem' ) && Model::validateMultiple($models) ) {
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
            return $this->redirect(['view', 'id' => $model->pedido_id]);
        } else {
                return $this->render('pedido', [
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
            return $this->redirect(['view', 'id' => $model->pedido_id]);
        } else {
            return $this->render('pedido', [
                'model' => $model,
            ]);
        }
        */



    /**
     * Updates an existing Pedido model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
      /* Código original acción update

        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pedido_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        */

        $model = $this->findModel($id);
        $models = $model['pedidoitems'];
        $counter_models = count($models);



        if ($model->load(Yii::$app->request->post()) && $model->save()){
            $data = (Yii::$app->request->getBodyParams());
            /*
             * Esta es la esctructura de datos que tiene que tener el array $data para que se procese.
             *
             * $data['PedidoItem'][0] = ['pedido_num'=>'12ab', 'item_cantidad'=>10,00, 'item_descripcion'=>'holaa', 'item_precio'=>100,00];
             */

            /**
             * Cuando queremos añadir un nuevo registro en el escenario de edición o update.
             * Calculamos la diferencia entre los modelos guardados y los modelos editados y la diferencia nos permite saber
             * cuantos modelos nuevos tenemos que crear
             */
            $count = count($data['PedidoItem']);
            $diferencia = $count - $counter_models;
            if ($diferencia >0){
                for($i= $counter_models; $i < $diferencia+$counter_models; $i++){
                     $models[$i] = new PedidoItem();
                }
            }
          
          
            if ( Model::loadMultiple($models, $data, $formName = 'PedidoItem' ) && Model::validateMultiple($models) ) {
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
            return $this->redirect(['view', 'id' => $model->pedido_id]);
        } else {
                return $this->render('_pedido', [
                    'model' => $model,
                ]);
            }


    }

    /**
     * Deletes an existing Pedido model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pedido model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Pedido the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pedido::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPrintpedido($id, $num, $name)
    {
        /*
         * La variable modo_vista, se pasa junto al modelo para que cuando se
         * imprima la misma vista oculte el boton de imprimir y que no lo muestre
         * cuando se genere el pdf.
         */
         
        $this->layout = 'viewLayout';
        
        $mpdf=new mPDF('UTF-8','A4','','futuraltcondensedlight',15,15,15,20,'',5,'P');
        $mpdf->SetHTMLFooter($this->footer);
        $mpdf->WriteHTML($this->render('view', ['model' => $this->findModel($id), 'modo_vista'=>'Imprimir']));
        $pedidoPdf = $mpdf->Output('pedido.pdf','I');
        $pedidoPdf = $mpdf->Output('../../../mis documentos/portucajabonita/pedidos/2017/' . $num .' '.$name . '.pdf','F');
    }

    public function actionSendpedido($id, $num, $name)
    {
        // Recogemos los datos enviados desde modalSendPedido form.
        $datosmodel = Yii::$app->request->post();
        $mailto = $datosmodel['Identidad']['mail'];
        $asunto = $datosmodel['Identidad']['asunto'];
        $body = $datosmodel['Identidad']['body'];

        $this->layout = 'viewLayout';
        $mpdf=new mPDF('UTF-8','A4','','',15,15,15,20,'',5,'P');
        $mpdf->SetHTMLFooter($this->footer);
        $mpdf->WriteHTML($this->render('view', ['model' => $this->findModel($id), 'modo_vista'=>'Imprimir']));
        //$pedidoPdf = $mpdf->Output('../../../mis documentos/portucajabonita/pedidos/2017/' . $num .' '.$name . '.pdf','S');
        $pedidoPdf = $mpdf->Output('','S');


        $message = Yii::$app->mailer->compose()
            ->setFrom('pedidos@portucajabonita.com')
            ->setTo($mailto)
            ->setSubject($asunto)
            ->setTextBody($body)
            ->setHtmlBody($body)
            ->setReadReceiptTo('pedidos@portucajabonita.com')
            ->attachContent($pedidoPdf, ['fileName' => $num . ' ' . $name . '.pdf', 'contentType' => 'application/pdf']);
            //->send();
                
                $result = Yii::$app->mailer->send($message);

        //exit;

         //En el  paso anterior generamos el pdf que aduntamos al correo y enviamos al cliente. En dicho paso no se guarda en 
        //el sistema local de archivos porque al mandarlo como adjunto, lo manda como si fuese un fichero vacio. Por eso en este paso
        //en el cual nos auto enviamos el correo a nuestra bandeja de saida para tener una copia de los mails enviados y dado 
        //que en el paso anterior, no hemos guardado el pdf, lo volvemos a generar y lo adjuntamos de nuevo. De momento es lo 
        //que me funciona.
        
        if ($result == TRUE){
               
            $confirmationFrom = 'pedidos@portucajabonita.com';
            $facturaPdf = $mpdf->Output('../../../mis documentos/portucajabonita/pedidos/2017/' . $num . ' ' . $name .'.pdf', 'F');
            $subject = "$asunto";
            $stream = imap_open("{cp193.webempresa.eu/novalidate-cert}INBOX.Sent", "pedidos@portucajabonita.com", "pedidosprT204249");
            $boundary = "------=" . md5(uniqid(rand()));
            $header = "MIME-Version: 1.0\r\n";
            $header .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
            $header .= "Disposition-Notification-To: $confirmationFrom\r\n"; 
            $header .= "X-Confirm-Reading-To: $confirmationFrom\r\n"; 
            $header .= "Read-Receipt-To: $confirmationFrom\r\n";
            $header .= "\r\n";
            $file = "../../../mis documentos/portucajabonita/pedidos/2017/". $num ." ". $name .".pdf";
            $filename = $num . " " . $name .".pdf";
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
            imap_append($stream, "{cp193.webempresa.eu/novalidate-cert}INBOX.Sent", "From: pedidos@portucajabonita.com\r\n" . "To: $mailto\r\n" . "Subject: $subject\r\n" . "$header\r\n" . "$cuerpo\r\n" . "$msg2\r\n" . "$msg3\r\n");
            imap_close($stream);

             //Guardamos en la base de datos la fecha de envío

             $model = $this->findModel($id);
             $model->pedido_fecha_envio = Yii::$app->formatter->asDate('now', 'yyyy-MM-dd');
            $model->save();

            return $this->redirect(['index']);
        } else {
            
             return $this->redirect(['index']);
        }

    }

    public function actionModalsendpedido($id, $num, $name) {
        $modelPedido = $this->findModel($id);

        $model = Identidad::findOne($modelPedido->cliente_id);
        return $this->renderAjax('modalSendPedido',
            [
                'model' => $model,
                'idPedido' => $id,
                'numPedido' => $id,
                'name' => $name,
            ]);
    }
    
    public function actionModalfacturarpedido($id) {
        $model = $this->findModel($id);

        if ($model->pedido_factura_num == 'pendiente') {
             return $this->renderAjax('modalFacturarPedido', [
                        //'model' => $model,
                        'numPedido' => $id,
            ]);
            
        } else {
           echo 'this pedido is factured';
        }
    }
    
    public function actionFacturarpedido(){
        
        $pedido;
        $factura_num;
        
        $data_request = Yii::$app->request->post();
        
        $pedido = $data_request['pedido_id'];
        $factura_num = $data_request['num_factura'];
        
        $model = $this->findModel($pedido);
        $model->pedido_factura_num = $factura_num;
        if ($model->validate()){
            $model->save();
            return $this->redirect(['view', 'id' => $model->pedido_id]);
        } else {
            $model->getErrors();
        }        
    }
    
     public function actionReportfacturasproveedor($id) {
        $model = Pedido::find()
                ->where (['cliente_id'=> $id])
                ->orderBy('pedido_factura_num, pedido_num ASC')
                ->all();
        return $this->render('reportFacturasProveedor', [
                    'model' => $model
        ]);
    }
    
    public function actionPedidosfacturados($id=NULL){
        $model = Pedido::find()
                ->where(['cliente_id'=>$id])
                ->orderBy('pedido_factura_num, pedido_num ASC')
                ->all();
        return $this->render('pedidosFacturados', [
            'model'=>$model
        ]);
    }
}
