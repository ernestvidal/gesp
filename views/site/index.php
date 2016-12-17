<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Identidad;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Por tu caja bonita - App';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                     <?= Html::a('Presupuestos', 'presupuesto/index') ?>
                </div>
                <div class="panel-body">
                    
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' =>'',
                        // Descomentar si se quiere filtrar el gridview
                        //'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            ['attribute'=>'presupuesto_fecha',
                                'format'=> ['date', 'php:d/m/Y']
                            ],
                            'presupuesto_num',
                            ['attribute'=>'cliente_id',
                             'value'=> function($model){
                                    $name = Identidad::findOne($model->cliente_id);
                                    return $name->identidad_nombre;
                             },
                            ],

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'controller' => 'presupuesto',
                            ],
                                     
                        ],
                    ]); 
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                     <?= Html::a('Facturas', 'factura/index') ?>
                </div>
                <div class="panel-body">
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $factura_dataProvider,
                        'summary' =>'',
                        // Descomentar si se quiere filtrar el gridview
                        //'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            ['attribute'=>'factura_fecha',
                                'format'=> ['date', 'php:d/m/Y']
                            ],
                            'factura_num',
                            ['attribute'=>'cliente_id',
                             'value'=> function($model){
                                    $name = Identidad::findOne($model->cliente_id);
                                    return $name->identidad_nombre;
                             },
                            ],

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'controller' => 'factura',
                            ],
                                     
                        ],
                    ]); 
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <?= Html::a('Albaranes', 'albaran/index') ?>
                </div>
                <div class="panel-body">
                     <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $albaran_dataProvider,
                        'summary' =>'',
                        // Descomentar si se quiere filtrar el gridview
                        //'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            ['attribute'=>'albaran_fecha',
                                'format'=> ['date', 'php:d/m/Y']
                            ],
                            'albaran_num',
                            ['attribute'=>'cliente_id',
                             'value'=> function($model){
                                    $name = Identidad::findOne($model->cliente_id);
                                    return $name->identidad_nombre;
                             },
                            ],

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'controller' => 'albaran',
                            ],
                                     
                        ],
                    ]); 
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                     <?= Html::a('Pedidos', 'pedido/index') ?>
                </div>
                <div class="panel-body">
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $pedido_dataProvider,
                        'summary' =>'',
                        // Descomentar si se quiere filtrar el gridview
                        //'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            ['attribute'=>'pedido_fecha',
                                'format'=> ['date', 'php:d/m/Y']
                            ],
                            'pedido_num',
                            ['attribute'=>'cliente_id',
                             'value'=> function($model){
                                    $name = Identidad::findOne($model->cliente_id);
                                    return $name->identidad_nombre;
                             },
                            ],

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'controller' => 'pedido',
                            ],
                                     
                        ],
                    ]); 
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div>   
            <p><a href="http://www.yiiframework.com"> Link a Yii framework &raquo;</a></p>
            <p><a href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            <p><a href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            <p><a href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>

        </div>
    </div>
</div>
