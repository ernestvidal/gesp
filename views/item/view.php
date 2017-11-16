<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Item */

$this->title = $model->item_id;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            Yii::$app->formatter->asNtext('item_id'),
            'item_descripcion',
            'item_referencia',
            'item_referencia_cliente',
            'item_numero_pantalla',
            'item_modelo',
            'item_ancho',
            'item_largo',
            'item_acabado',
            'item_material',
            'item_sistema_impresion',
            'item_identidad_id',
            array(
                'label'=>'cliente',
                'value'=>$model['itemIdentidad']['identidad_nombre'],
                ),
            'item_precio_venta',
            'item_url_imagen'

        ],
    ]) ?>
    
    <p>
        <img src="<?='file://'.$model->item_url_imagen?>" alt="imagen"/>
    </p>
    
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->item_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->item_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
