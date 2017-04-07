<?php

namespace app\controllers;

use Yii;
use app\models\Pedidocliente;
use app\models\Pedidoitemcliente;
use app\models\PedidoclienteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;
use mPDF;

/**
 * PedidoclienteController implements the CRUD actions for Pedidocliente model.
 */
class PedidoclienteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Pedidocliente models.
     * @return mixed
     */
    public function actionIndex()
    {
       if (isset($pedidos) <> 'pendientes') {
            $model = Pedidocliente::find()
                    ->where(['pedido_factura_num' => 'pendiente'])
                    ->orderBy('facturador_id, pedido_num DESC')
                    ->all();
            return $this->render('index', [
                        'model' => $model
            ]);
        } else {

            $model = Pedidocliente::find()
                    ->orderBy('facturador_id, pedido_num DESC')
                    ->all();
            return $this->render('index', [
                        'model' => $model
            ]);
        }
    }

    /**
     * Displays a single Pedidocliente model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Pedidocliente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       $model = new Pedidocliente();
        $modelItem = new Pedidoitemcliente();

        if ($model->load(Yii::$app->request->post()) && $model->save()){
            $data = (Yii::$app->request->getBodyParams());
            /*
             * Esta es la esctructura de datos que tiene que tener el array $data para que se procese.
             *
             * $data['PedidoItem'][0] = ['pedido_num'=>'12ab', 'item_cantidad'=>10,00, 'item_descripcion'=>'holaa', 'item_precio'=>100,00];
             */

            $count = count($data['PedidoItem']);
            $models = [new Pedidoitemcliente()];

            for($i = 1; $i < $count; $i++) {
                $models[$i] = new Pedidoitemcliente();
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
                return $this->render('pedidocliente', [
                    'model' => $model,
                    'modelItem' => $modelItem,
                ]);
            }
    }

    /**
     * Updates an existing Pedidocliente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $models = $model['pedidoitemclientes'];
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
                     $models[$i] = new Pedidoitemcliente();
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
                return $this->render('_pedidocliente', [
                    'model' => $model,
                ]);
            }
    }

    /**
     * Deletes an existing Pedidocliente model.
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
     * Finds the Pedidocliente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Pedidocliente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pedidocliente::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
     public function actionCopiarpedido($id, $documento_destino) {
        $model = $this->findModel($id);

        return $this->renderAjax('copiarPedido', [
                    //'model' => $model,
                    'numPedido' => $id,
                    'documento_destino' => $documento_destino
        ]);
    }

    public function actionCopiar() {
        /**
         * Recogemos los datos enviados desde el formulario copiarProforma.php
         * Luego cargamos la proforma que queremos copiar
         * 
         */
        $fecha_documento;
        $num_documento;
        $num_pedido_id;

        $data_request = Yii::$app->request->post();
        $num_pedido_id = $data_request['pedido_id'];
        $fecha_documento = $data_request['fecha_documento'];
        $num_documento = $data_request['numero_documento'];
        $model = $this->findModel($num_pedido_id);
        $modelItems = $model['pedidoitemclientes'];
        $fModel = new Albaran();
        $fModel->albaran_num = $num_documento;
        $fModel->albaran_fecha = $fecha_documento;
        $fModel->facturador_id = $model->facturador_id;
        $fModel->cliente_id = $model->cliente_id;
        $fModel->albaran_rate_descuento = $model->pedido_rate_descuento;
        $fModel->albaran_rate_iva = 21;
        $fModel->albaran_rate_irpf = $model->pedido_rate_irpf;
        $fModel->albaran_forma_pago = ($model['cliente']['identidad_forma_pago'] <> Null) ? $model['cliente']['identidad_forma_pago'] : '';
        $fModel->albaran_cta = $model['cliente']['identidad_cta'];
        $fModel->save();

        foreach ($modelItems as $pedidoItems) {
            $fModelItems = new Albaranitem();
            $fModelItems->pedido_num = $num_documento;
            $fModelItems->item_cantidad = $pedidoItems->item_cantidad;
            $fModelItems->item_descripcion = $pedidoItems->item_descripcion;
            $fModelItems->item_precio = $pedidoItems->item_precio;
            $fModelItems->save();
        }
    }
    
    public function actionPrintpedido($id) {
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
        $albaranPdf = $mpdf->Output('pedidocliente.pdf', 'D');
    }
}
