<?php

/* @var $this yii\web\View */
/* @var $model common\models\Codes */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use common\models\Codes;
?>

<div class="code-form">
    <br>
    <?php $form = ActiveForm::begin([
        'id' => 'code-post-form',
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'status')->dropDownList(Codes::statuses()) ?>

    <?= $form->field($model, 'start_date')->textInput() ?>

    <?= $form->field($model, 'end_date')->textInput() ?>

    <?= $form->field($model, 'tariff_zone')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'customer_reward')->textInput(['maxlength' => 50]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
