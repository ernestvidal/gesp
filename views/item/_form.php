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

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'item_descripcion')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'item_referencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'item_modelo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'item_size')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($model, 'item_identidad_id')->dropDownList(
            ArrayHelper::map(Identidad::find()->all(), 'identidad_id', 'identidad_nombre'), [
        'prompt' => 'Quien va a albaranr...',
        'id' => 'item_identidad_id',
        'class' => 'form-control'])
    ?>

    <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
