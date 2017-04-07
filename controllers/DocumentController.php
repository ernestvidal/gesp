<?php

namespace app\controllers;

use Yii;
use app\models\Presupuesto;
use app\models\Presupuestoitem;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Description of DocumentController
 *
 * @author ernest
 */
class DocumentController extends Controller {

    public function actionCreate() {
        
       

        $model = new Presupuesto();
        
        $num_documento = '2017.'. substr('000'.(substr($model->find()->max('presupuesto_num'), 5)+1),-3,3);
        
        $model->presupuesto_num = $num_documento;
        $model->facturador_id = 7;
        $model->cliente_id = 9;
        $model->presupuesto_fecha = Yii::$app->formatter->asDate('now', 'yyyy-MM-dd');
        $model->presupuesto_rate_descuento = 0;
        $model->presupuesto_rate_iva = 21;
        $model->presupuesto_rate_irpf = 0;
        $model->forma_pago = 'TRANSFERENCIA ES39 1465 0100 9619 0045 6354';
        
        $modelLine_0 = new Presupuestoitem();
        $modelLine_0->presupuesto_num =$num_documento;
        $modelLine_0->item_cantidad = 72;
        $modelLine_0->item_precio = 1.65;
        $modelLine_0->item_descripcion = 'Cinta adhesiva 48 mm x 66 m'. PHP_EOL .'Color cinta : Blanca'.PHP_EOL.'Impresión : 1 Tinta'.PHP_EOL;
        
        $modelLine_1 = new Presupuestoitem();
        $modelLine_1->presupuesto_num =$num_documento;
        $modelLine_1->item_cantidad = 1;
        $modelLine_1->item_precio = 6.65;
        $modelLine_1->item_descripcion = 'Portes 24/48 horas península';
        
        $modelLine_2 = new Presupuestoitem();
        $modelLine_2->presupuesto_num =$num_documento;
        $modelLine_2->item_cantidad = 0;
        $modelLine_2->item_precio = 0;
        $modelLine_2->item_descripcion = 'Clichés / pantallas';
        
        $modelLine_3 = new Presupuestoitem();
        $modelLine_3->presupuesto_num =$num_documento;
        $modelLine_3->item_cantidad = 0;
        $modelLine_3->item_precio = 0;
        $modelLine_3->item_descripcion = 'Boceto / revisión fichero';
        
        
        if ($model->save() && $modelLine_0->save() && $modelLine_1->save() && $modelLine_2->save() && $modelLine_3->save()  ){
        
        echo 'holaaaaaaaaa';
         }
    }

}
