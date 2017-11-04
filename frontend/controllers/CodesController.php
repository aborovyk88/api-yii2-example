<?php namespace frontend\controllers;

use common\models\Codes;
use common\models\CodesSearch;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use common\components\Alert;

/**
 * Code controller
 */
class CodesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['list', 'update', 'create', 'delete'],
                'rules' => [
                    [
                        'actions' => ['list', 'update', 'create', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionList() {
        $searchModel = new CodesSearch();
        $searchModel->load(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search();

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate() {
        $model = new Codes();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Alert::addSuccess('Item has been successfully created');
            return $this->redirect(['list']);
        }

        return $this->render('form', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id) {
        $model = Codes::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Alert::addSuccess('Item has been successfully updated');
            return $this->redirect(['list']);
        }

        return $this->render('form', [
            'model' => $model,
        ]);

    }

    public function actionDelete($id) {
        try {
            $model = Codes::findOne($id);
            if($model->delete())
                Alert::addSuccess('Item has been successfully deleted');
        } catch(\Exception $e) {
            Alert::addError('Item has not been deleted', $e->getMessage());
        }
        return $this->redirect(['list']);
    }
}
