<?php



namespace app\modules\fees\controllers;

use Yii;
use app\modules\fees\models\BankMaster;
use app\modules\fees\models\BankMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\bootstrap\ActiveForm;

class BankMasterController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all BankMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BankMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
	$model = new BankMaster();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
	    'model' => $model,
        ]);
    }

    /**
     * Displays a single BankMaster model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BankMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BankMaster();
       $searchModel = new BankMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

	if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
       	}
        if ($model->load(Yii::$app->request->post())) {

		$model->attributes = $_POST['BankMaster'];
		$model->created_by = Yii::$app->getid->getId();
		$model->created_at= new \yii\db\Expression('NOW()');
		if($model->save())
			return $this->redirect(['index']);

            }
	    return $this->render('index', ['model' => $model, 'searchModel' => $searchModel,'dataProvider' => $dataProvider,]);
    }

    /**
     * Updates an existing BankMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
	$searchModel = new BankMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

	if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
       	}

        if ($model->load(Yii::$app->request->post())) {
		$model->attributes = $_POST['BankMaster'];
		$model->updated_by = Yii::$app->getid->getId();
		$model->updated_at= new \yii\db\Expression('NOW()');
		if($model->save())
           		return $this->redirect(['index']);
        }
	return $this->render('index', ['model' => $model, 'searchModel' => $searchModel,'dataProvider' => $dataProvider,]);
    }

    /**
     * Deletes an existing BankMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
	$model = BankMaster::findOne($id);
	$model->is_status = 2;
	$model->updated_by = Yii::$app->getid->getId();
	$model->updated_at = new \yii\db\Expression('NOW()');
	$model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BankMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BankMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BankMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
