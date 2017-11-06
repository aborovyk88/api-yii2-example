<?php
/* @var $this yii\web\View */
/* @var $searchModel common\models\CodesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Codes;
?>

<?= Html::a('Create Code', Url::to(['codes/create']), ['class' => 'btn btn-success']) ?>

<div class="code-index">

    <br>
    <?= GridView::widget([
        'id' => 'code-list',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model) {
                    /** @var $model Codes */
                    return Html::a($model->name, Url::to(['codes/update', 'id' => $model->id]), []);
                }
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    /** @var $model Codes */
                    return $model->getStatusString();
                }
            ],
            [
                'attribute' => 'start_date',
                'value' => function ($model) {
                    /** @var $model Codes */
                    $date = new DateTime($model->start_date);
                    return $date->format("d.m.Y");
                }
            ],
            [
                'attribute' => 'end_date',
                'value' => function ($model) {
                    /** @var $model Codes */
                    $date = new DateTime($model->end_date);
                    return $date->format("d.m.Y");
                }
            ],
            'tariff_zone',
            [
                'attribute' => 'customer_reward',
                'value' => function ($model) {
                    /** @var $model Codes */
                    return Yii::$app->formatter->asCurrency($model->customer_reward, 'USD');
                }
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
            ],
        ],
    ]); ?>
</div>
