<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IdentidadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->context->layout = 'viewLayout';
$this->title = 'Identidades';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="identidad-index">
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

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'identidad_id',
                    'identidad_nombre',
                    'identidad_direccion',
                    'identidad_poblacion',
                    'identidad_nif',
                    'identidad_mail',
                    'identidad_persona_contacto',
                    'identidad_phone',
                    'identidad_role',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>

            <p>
                <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        <div class="col-lg-1"></div>
    </div>
</div>
