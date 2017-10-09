<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IdentidadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//$this->context->layout = 'viewLayout';
$this->title = 'Identidades';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="identidad-index">


    <br>
    <div class="row">

            <!--<h1><?= Html::encode($this->title) ?></h1>-->
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    </div>



    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-8">

                <?= Html::a('Clientes', ['index?IdentidadSearch[identidad_role]=CLIENTE']) ?>
                <?= ' / ' ?>
                <?= Html::a('Captación', ['index?IdentidadSearch[identidad_role]=CAPTACION']) ?>
                <?= ' / ' ?>
                <?= Html::a('Proveedores', ['index?IdentidadSearch[identidad_role]=PROVEEDOR']) ?>

            </div>
            <div class="col-md-4">
                <div class="btn-group">

                    <?= Html::a('<span class="glyphicon glyphicon-refresh"></span>', 'index', ['class' => 'btn  btn-default']) ?>
                </div>


                <?=
                Html::a('Create', '#', [
                    'id' => 'crear-identidad-link',
                    'class' => 'btn btn-primary',
                    'data-toggle' => 'modal',
                    'data-target' => '#modal',
                    'data-url' => Url::to(['create']),
                    'data-pjax' => '0',]);
                ?>
            </div>
        </div>
    </div>






<div class="row">

    <div class="col-md-12">

        <?php Pjax::begin() ?>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'id' => 'identidad-grid',
            'summary' => '',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                //'identidad_id',
                [ 'attribute' => 'identidad_nombre',
                    'label' => 'Nombre',
                    'format' => 'raw',
                    'value' => function($data) {
                        return Html::a($data->identidad_nombre, ['update', 'id' => $data->identidad_id]);
                    }],
                        //'identidad_direccion',
                        'identidad_poblacion',
                        'identidad_provincia',
                        'identidad_actividad',
                        ['attribute' => 'identidad_web',
                            'format' => 'raw',
                            'value' => function($data) {
                                return Html::a($data->identidad_web, 'http://' . $data->identidad_web, ['target' => '_blank']);
                            }],
                                'identidad_persona_contacto',
                                'identidad_phone',
                                'identidad_role',
                                ['class' => 'yii\grid\ActionColumn',
                                    'template' => '{delete}',
                                ],
                            ],
                        ]);
                        ?>

                        <?php Pjax::end() ?>
                    </div>
                </div>
                </div>

                <?php
                $this->registerJs(
                        "$(document).on('click', '#crear-identidad-link', (function() {
        $.get(
            $(this).data('url'),
            function (data) {
                $('.modal-body').html(data);
                $('#modal').modal();
            }
        );
    }));"
                );
                ?>

                <?php
                Modal::begin([
                    'id' => 'modal',
                    'header' => '<h4 class="modal-title">Create identidad</h4>',
                    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Cerrar</a>',
                ]);

                echo "<div class='well'></div>";

                Modal::end();
                ?>