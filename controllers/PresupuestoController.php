<?php

namespace app\controllers;

use Yii;
use mPDF;
use app\models\Presupuesto;
use app\models\Presupuestoitem;
// use app\models\FacturaItem;
use app\models\Identidad;
use app\models\PresupuestoSearch;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;

/**
 * PresupuestoController implements the CRUD actions for Presupuesto model.
 */
class PresupuestoController extends Controller
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
     * Lists all Presupuesto models.
     * @return mixed
     */
    public function actionIndex($year=NULL)
    {
        if($year == NULL){
            $currentYear = Yii::$app->formatter->asDate('now', 'yyyy');
        } else{
            $currentYear = $year;
        }
        
        $model = Presupuesto::find()
                ->where(['Year(presupuesto_fecha)' => $currentYear])
                ->orderBy('facturador_id, presupuesto_num DESC')
                ->all();
        
        if(count($model)<=0){
            
            $currentYear --;
        
            $model = Presupuesto::find()
                ->where(['Year(presupuesto_fecha)' => $currentYear])
                ->orderBy('facturador_id, presupuesto_num DESC')
                ->all();
        }
        return $this->render('index', [
            'model' => $model
        ]);
    }

    /**
     * Displays a single Presupuesto model.
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
     * Creates a new Presupuesto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Presupuesto();
        $modelItem = new PresupuestoItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()){
            $data = (Yii::$app->request->getBodyParams());
            /*
             * Esta es la esctructura de datos que tiene que tener el array $data para que se procese.
             *
             * $data['PresupuestoItem'][0] = ['presupuesto_num'=>'12ab', 'item_cantidad'=>10,00, 'item_descripcion'=>'holaa', 'item_precio'=>100,00];
             */

            $count = count($data['PresupuestoItem']);
            $models = [new PresupuestoItem()];

            for($i = 1; $i < $count; $i++) {
                $models[$i] = new PresupuestoItem();
            }

            if ( Model::loadMultiple($models, $data, $formName = 'PresupuestoItem' ) && Model::validateMultiple($models) ) {
                foreach ($models as $modelo) {
                    // populate and save records for each model
                    if ($modelo->save()) {
                        // do something here after saving
                        $count++;
                    } else {
                        $errores = $modelo->getErrors();
                    }
                }
            } else {
                 foreach ($models as $modelo) {
                     $errores = $modelo->getErrors();
                     var_dump($errores);
                }
            }
            return $this->redirect(['view', 'id' => $model->presupuesto_id]);
        } else {
                return $this->render('presupuesto', [
                    'model' => $model,
                    'modelItem' => $modelItem,
                ]);
            }
    }



    /**
     * Updates an existing Presupuesto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
      /* Código original acción update

        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->presupuesto_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        */

        $model = $this->findModel($id);
        $models = $model['presupuestoitems'];

        if ($model->load(Yii::$app->request->post()) && $model->save()){
            $data = (Yii::$app->request->getBodyParams());
            /*
             * Esta es la esctructura de datos que tiene que tener el array $data para que se procese.
             *
             * $data['PresupuestoItem'][0] = ['presupuesto_num'=>'12ab', 'item_cantidad'=>10,00, 'item_descripcion'=>'holaa', 'item_precio'=>100,00];
             */

            $count = count($data['PresupuestoItem']);
            //$models = [new PresupuestoItem()];

            /*
            for($i = 1; $i < $count; $i++) {
                $models[$i] = new PresupuestoItem();
            }
            */
            if ( Model::loadMultiple($models, $data, $formName = 'PresupuestoItem' ) && Model::validateMultiple($models) ) {
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
            return $this->redirect(['view', 'id' => $model->presupuesto_id]);
        } else {
                return $this->render('_presupuesto', [
                    'model' => $model,
                ]);
            }


    }

    /**
     * Deletes an existing Presupuesto model.
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
     * Finds the Presupuesto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Presupuesto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Presupuesto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPrintpresupuesto($id, $num)
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
        $presupuestoPdf = $mpdf->Output('presupuesto ' . $num . '.pdf','D');
    }

    public function actionSendpresupuesto($id)
    {
        // Recogemos los datos enviados desde modalSendPresupuesto form.
        $datosmodel = Yii::$app->request->post();
        $mailto = $datosmodel['Identidad']['mail'];
        $asunto = $datosmodel['Identidad']['asunto'];
        $body = $datosmodel['Identidad']['body'];

        $this->layout = 'viewLayout';
        $mpdf=new mPDF('UTF-8','A4','','',10,10,20,20,'','','P');
        $mpdf->WriteHTML($this->render('view', ['model' => $this->findModel($id)]));
        $presupuestoPdf = $mpdf->Output('presupuesto.pdf','S');


        $message = Yii::$app->mailer->compose()
            ->setFrom('ernest@portucajabonita.com')
            ->setTo($mailto)
            ->setSubject($asunto)
            ->setTextBody($body)
            ->setHtmlBody($body)
            ->attachContent($presupuestoPdf, ['fileName' => 'presupuesto.pdf', 'contentType' => 'application/pdf'])
            ->send();

        //exit;

         return $this->redirect(['index']);

    }

    public function actionModalsendpresupuesto($id) {
        $modelPresupuesto = $this->findModel($id);

        $model = Identidad::findOne($modelPresupuesto->cliente_id);
        return $this->renderAjax('modalSendPresupuesto',
            [
                'model' => $model,
                'numPresupuesto' => $id,
            ]);
    }
}
