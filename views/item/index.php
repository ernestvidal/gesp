<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchItem */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'item_id',
            'item_descripcion',
            'item_referencia',
            'item_referencia_cliente',
            'item_modelo',
            'item_precio_compra',
            'item_identidad_id',

            ['class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'additional_icon' => function ($url, $model, $key) {
                    return Html::a ('<span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span>', ['duplicate', 'id' => $key]);
                },
            ],
            'template' => '{update} {view} {delete} {additional_icon}'


        ],

            
          //  ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
