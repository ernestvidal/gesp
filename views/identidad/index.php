<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IdentidadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->context->layout = 'viewLayout';
$this->title = 'Identidades';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="identidad-index">
    <br>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-3">
            <div class="btn-group">
                <a class="btn btn-sm btn-default" href="index.php?page=compras_proveedores">
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    <span class="hidden-xs hidden-sm">&nbsp; Identidades</span>
                </a>
                <?= Html::a('<span class="glyphicon glyphicon-refresh"></span>', 'index',['class'=>'btn btn-sm btn-default']) ?>
            </div>
        </div>
        <div class="col-lg-8"></div>
    </div>
    <br>
    <div class="row">

        <div class="col-lg-1"></div>
        <div class="col-lg-10">


            <!--<h1><?= Html::encode($this->title) ?></h1>-->
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <div class="well">
                <?= Html::a('Clientes', ['index?IdentidadSearch[identidad_role]=CLIENTE']) ?>
                <?= ' / ' ?>
                <?= Html::a('Captación', ['index?IdentidadSearch[identidad_role]=CAPTACION']) ?>
                <?= ' / ' ?>
                <?= Html::a('Proveedores', ['index?IdentidadSearch[identidad_role]=PROVEEDOR']) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">

            <?php Pjax::begin() ?>

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'id' => 'identidad-grid',
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
                            //'identidad_nif',
                            'identidad_mail',
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

                    <p>

                        <?=
                        Html::a('Create', '#', [
                            'id' => 'crear-identidad-link',
                            'class' => 'btn btn-success',
                            'data-toggle' => 'modal',
                            'data-target' => '#modal',
                            'data-url' => Url::to(['create']),
                            'data-pjax' => '0',]);
                        ?>
                    </p>
                </div>
                <div class="col-lg-1"></div>
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
            'header' => '<h4 class="modal-title">Create /update identidad</h4>',
            'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Cerrar</a>',
        ]);

        echo "<div class='well'></div>";

        Modal::end();
        ?>