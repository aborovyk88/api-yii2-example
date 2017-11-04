<?php namespace frontend\controllers;

use Yii;
use common\models\Codes;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;

class ApiController extends ActiveController {

    public $modelClass = 'common\models\Codes';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter' ] = [
            'class' => Cors::className(),
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['delete'], $actions['create']);

        return $actions;
    }

    public function actionGetDiscountInfo() {
        $name = Yii::$app->request->getQueryParam('name');
        $code = Codes::findOne(['name' => $name]);
        if (!($code instanceof Codes)) {
            throw new NotFoundHttpException('Code in not found', 422);
        }
        return $code;
    }

    public function actionActivateDiscount () {
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException('Invalid query method', 500);
        }
        $name = Yii::$app->request->post('name');
        $zone = Yii::$app->request->post('zone');
        $token_user = Yii::$app->request->post('token_user');
        $code = Codes::find()
            ->where(['tariff_zone' => $zone])
            ->andWhere(['name' => $name])
            ->one();
        if (!($code instanceof Codes)) {
            throw new NotFoundHttpException('Code in not found', 422);
        }
        return $code->activate($token_user);
    }
}