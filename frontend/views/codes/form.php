<?php

/* @var $this yii\web\View */
/* @var $model common\models\Codes */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Codes;
use kartik\date\DatePicker;
?>

<div class="code-form">
    <br>
    <?php $form = ActiveForm::begin([
        'id' => 'code-post-form',
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'status')->dropDownList(Codes::statuses()) ?>

    <?= $form->field($model, 'start_date')->widget(DatePicker::className(), [
        'options' => ['placeholder' => 'Select date ...'],
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true
        ]
    ]) ?>

    <?= $form->field($model, 'end_date')->widget(DatePicker::className(), [
        'options' => ['placeholder' => 'Select date ...'],
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true
        ]
    ]) ?>

    <?= $form->field($model, 'tariff_zone')->dropDownList(Codes::zones()) ?>

    <?= $form->field($model, 'customer_reward')->textInput(['maxlength' => 50]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
