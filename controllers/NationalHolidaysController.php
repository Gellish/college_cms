<?php



/**
 * NationalHolidaysController implements the CRUD actions for NationalHolidays model.
 */

namespace app\controllers;

use Yii;
use app\models\NationalHolidays;
use app\models\NationalHolidaysSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\bootstrap\ActiveForm;
use yii\helpers\Json;

class NationalHolidaysController extends Controller
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
     * Lists all NationalHolidays models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NationalHolidaysSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
	$model = new NationalHolidays();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
	    'model' => $model,
        ]);
    }

    /**
     * Displays a single NationalHolidays model.
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
     * Creates a new NationalHolidays model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NationalHolidays();
	$searchModel = new NationalHolidaysSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
	$model = new NationalHolidays();
        if ($model->load(Yii::$app->request->post())) {
		if (Yii::$app->request->isAjax) {
                        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ActiveForm::validate($model);
       		}

		$model->attributes = $_POST['NationalHolidays'];
		$model->national_holiday_date = date('Y-m-d', strtotime($_POST['NationalHolidays']['national_holiday_date']));
		$model->created_by = Yii::$app->getid->getId();
		$model->created_at = new \yii\db\Expression('NOW()');
		if($model->save())
			return $this->redirect(['index']);
		else
			 return $this->render('index', ['model' => $model,'model' => $model,
				'searchModel' => $searchModel,'dataProvider' => $dataProvider,
            		]);
		            
        } else {
            return $this->render('index', [
                'model' => $model,'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Updates an existing NationalHolidays model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
	$searchModel = new NationalHolidaysSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if ($model->load(Yii::$app->request->post())) {
		if (Yii::$app->request->isAjax) {
                        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ActiveForm::validate($model);
       		}
		$model->attributes = $_POST['NationalHolidays'];
		$model->national_holiday_date = date('Y-m-d', strtotime($_POST['NationalHolidays']['national_holiday_date']));
		$model->updated_by = Yii::$app->getid->getId();
		$model->updated_at= new \yii\db\Expression('NOW()');
		if($model->save())
			return $this->redirect(['index']);
		else
			 return $this->render('index', ['model' => $model,'model' => $model,
				'searchModel' => $searchModel,'dataProvider' => $dataProvider,
            		]);
            
        } else {
            return $this->render('index', [
                'model' => $model,
		 'model' => $model,'searchModel' => $searchModel,
          	 'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Deletes an existing NationalHolidays model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
	$model = NationalHolidays::findOne($id);
	$model->is_status = 2;
	$model->updated_by = Yii::$app->getid->getId();
	$model->updated_at = new \yii\db\Expression('NOW()');
	$model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the NationalHolidays model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NationalHolidays the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NationalHolidays::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
