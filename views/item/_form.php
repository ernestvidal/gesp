<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Identidad;

/* @var $this yii\web\View */
/* @var $model app\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $this->registerJsFile('@web/js/item.js', ['depends' => [\yii\web\JqueryAsset::className()]]) ?>
<div class="item-form">
    <div class="row">
        <div class="col-md-12"><?php $form = ActiveForm::begin(); ?></div>
        <div class="col-md-12"><?= $form->field($model, 'item_descripcion')->textarea(['maxlength' => true]) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'item_referencia')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'item_referencia_cliente')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'item_modelo')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-2"><?= $form->field($model, 'item_size')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-5"><?= $form->field($model, 'item_acabado')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-5"><?= $form->field($model, 'item_material')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-12">
            <?=
            $form->field($model, 'item_identidad_id')->dropDownList(
                    ArrayHelper::map(Identidad::find()->all(), 'identidad_id', 'identidad_nombre'), [
                'prompt' => 'Quien va a albaranr...',
                'id' => 'item_identidad_id',
                'class' => 'form-control'])
            ?>
        </div>
        <div class="col-md-12"><?= $form->field($model, 'item_url_imagen')->textarea(['maxlength' => true]) ?></div></div>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
