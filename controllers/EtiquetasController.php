<?php

namespace app\controllers;

use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AlbaranController implements the CRUD actions for Albaran model.
 */
class EtiquetasController extends Controller {

    public $tipusImpressio = [
            'offset' => [
                'medidas_impresion' => ['ancho' => 480, 'alto' => 340],
                'medidas_soporte' => ['ancho' => 700, 'alto' => 500],
                'cantidades_tarificar' => [500, 1000, 2000, 3000, 5000],
                'coste_impresion' => 125,
                'coste_hoja' => 0.90,
            ]
        ];
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

    /*
     * Tarificación etiquetas
     */

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionTarificar() {


        $model = new \yii\base\DynamicModel([
            'ancho_etiqueta',
            'largo_etiqueta',
            'ancho_soporte',
            'largo_soporte',
            'precio_soporte',
            'coste_impresion',
            'coste_transporte',
            'coste_corte',
            'sistema_impresion'
        ]);
        
        $model->addRule(['ancho_etiqueta', 'largo_etiqueta', 'ancho_soporte', 'largo_soporte'], 'required')
                ->addRule('ancho_etiqueta','number', ['max'=> $this->tipusImpressio['offset']['medidas_impresion']['ancho']])
                ->addRule('largo_etiqueta','number', ['max'=> $this->tipusImpressio['offset']['medidas_impresion']['ancho']]);
                

        return $this->render('_form', ['model' => $model, 'tipusImpressio'=> $this->tipusImpressio]);
    }

    public function actionValorar() {

        $data = Yii::$app->request->post();
        $modelo = $data['DynamicModel'];
        

        function calcularNumeroEtiquetas($offset, $modelo) {
            $a1 = intval($offset['medidas_impresion']['ancho'] / $modelo['ancho_etiqueta']);
            $a2 = intval($offset['medidas_impresion']['ancho'] / $modelo['largo_etiqueta']);
            $b1 = intval($offset['medidas_impresion']['alto'] / $modelo['ancho_etiqueta']);
            $b2 = intval($offset['medidas_impresion']['alto'] / $modelo['largo_etiqueta']);
            $anchomayor = ($a1 > $a2) ? $a1 : $a2;
            $anchomenor = ($a1 < $a2) ? $a1 : $a2;
            $largomayor = ($b1 > $b2) ? $b1 : $b2;
            $largomenor = ($b1 < $b2) ? $b1 : $b2;
            $etiquetas1 = $anchomayor * $largomenor;
            $etiquetas2 = $anchomenor * $largomayor;

            print_r($etiquetas2);
            $num_etiquetas = ($etiquetas1 > $etiquetas2) ? $etiquetas1 : $etiquetas2;
            return $num_etiquetas;
        }

        $numEtiquetas = calcularNumeroEtiquetas($offset, $modelo);

        if ($data['DynamicModel']['sistema_impresion'] == 'offset') {
            return $this->render('view', [
                        'model' => $modelo,
                        'datos' => $offset,
                        'eti' => $numEtiquetas
            ]);
        }
    }

    public function actionView() {

        $model = Yii::$app->request->post();

        return $this->render('view', [
                    'model' => $model
        ]);
    }

}
