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
    public function actionView($id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id)
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
                    
                </table> ' ;
         
        $this->layout = 'viewLayout';
        
        $mpdf=new mPDF('UTF-8','A4','','',15,15,15,20,'',5,'P');
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($this->render('view', ['model' => $this->findModel($id)]));
        $pedidoPdf = $mpdf->Output('pedido.pdf','I');
        $pedidoPdf = $mpdf->Output('../../../mis documentos/portucajabonita/pedidos/2017/' . $num .' '.$name . '.pdf','F');
    }

    public function actionSendpedido($id)
    {
        // Recogemos los datos enviados desde modalSendPedido form.
        $datosmodel = Yii::$app->request->post();
        $mailto = $datosmodel['Identidad']['mail'];
        $asunto = $datosmodel['Identidad']['asunto'];
        $body = $datosmodel['Identidad']['body'];

        $this->layout = 'viewLayout';
        $mpdf=new mPDF('UTF-8','A4','','',10,10,20,20,'','','P');
        $mpdf->WriteHTML($this->render('view', ['model' => $this->findModel($id)]));
        $pedidoPdf = $mpdf->Output('pedido.pdf','S');


        $message = Yii::$app->mailer->compose()
            ->setFrom('vidal@inmobiliariavidal.es')
            ->setTo($mailto)
            ->setSubject($asunto)
            ->setTextBody($body)
            ->setHtmlBody($body)
            ->attachContent($pedidoPdf, ['fileName' => 'pedido.pdf', 'contentType' => 'application/pdf'])
            ->send();

        //exit;

         return $this->redirect(['index']);

    }

    public function actionModalsendpedido($id) {
        $modelPedido = $this->findModel($id);

        $model = Identidad::findOne($modelPedido->cliente_id);
        return $this->renderAjax('modalSendPedido',
            [
                'model' => $model,
                'numPedido' => $id,
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
