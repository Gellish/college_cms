<?php



namespace app\modules\employee\controllers;

use Yii;
use app\modules\employee\models\EmpAddress;
use app\modules\employee\models\EmpAddressSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\City;
use app\models\Country;
use app\models\State;
use yii\helpers\Json;
use yii\bootstrap\ActiveForm;

class EmpAddressController extends Controller
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
     * Lists all EmpAddress models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmpAddressSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmpAddress model.
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
     * Creates a new EmpAddress model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmpAddress();
        if ($model->load(Yii::$app->request->post())) {
    	    $model->attributes = $_POST['EmpAddress'];
    	    if($model->save())
                return $this->redirect(['view', 'id' => $model->emp_address_id]);
    		else
    			return $this->render('create', ['model' => $model,]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EmpAddress model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
	     $model->attributes = $_POST['EmpAddress'];
            if($model->save())
			return $this->redirect(['view', 'id' => $model->emp_address_id]);
		else
			return $this->render('create', ['model' => $model,]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EmpAddress model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EmpAddress model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmpAddress the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmpAddress::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
