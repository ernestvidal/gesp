<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Identidad;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $this->registerJsFile('@web/js/item.js', ['depends' => [\yii\web\JqueryAsset::className()]]) ?>
<div class="item-form">
    <div class="row">
       
        <div class="col-md-12"><?php $form = ActiveForm::begin(); ?></div>
        <div class="col-md-12">
         <?=
        $form->field($model, 'item_identidad_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(Identidad::find()->all(), 'identidad_id', 'identidad_nombre'),
            'options' => ['placeholder' => 'Seleccionar'],
            'pluginOptions' => [
                'allowClear' => true
            ],
            'id' => 'item_identidad_id',
            'class' => 'form-control'
        ]);
        ?>
              </div>
        <div class="col-md-3"><?= $form->field($model, 'item_referencia')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-3"><?= $form->field($model, 'item_referencia_cliente')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-3"><?= $form->field($model, 'item_modelo')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-3"><?= $form->field($model, 'item_numero_pantalla')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-1"><?= $form->field($model, 'item_ancho')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-1"><?= $form->field($model, 'item_largo')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'item_acabado')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'item_material')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-2"><?=
        $form->field($model, 'item_sistema_impresion')->dropDownList([
            'SERIGRAFIA' => 'SERIGRAFIA',
            'SERIGRAFIA DIGITAL' => 'SERIGRAFIA DIGITAL',
            'LASER' => 'LASER',
            'OFFSET' => 'OFFSET',
            'DIGITAL' => 'DIGITAL',
            'SUBLIMACION' => 'SUBLIMACION'], ['prompt' => 'Seleccionar ....'])
        ?></div>
        <div class="col-md-3"><?= $form->field($model, 'item_precio_venta')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-3"><?= $form->field($model, 'item_precio_compra')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-12"><?= $form->field($model, 'item_descripcion')->textarea(['maxlength' => true]) ?></div>
        <div class="col-md-12"><?= $form->field($model, 'item_url_imagen')->textarea(['maxlength' => true]) ?></div></div>

    <?php if (isset($action)){ ?>
             <div class="form-group">
        <?= Html::submitButton('Duplicate',['class' =>'btn btn-success']) ?>
    </div>
        <?php }else{ ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
        <?php } ?>
    
    
    <?php ActiveForm::end(); ?>
</div>

</div>
