<?php



namespace app\modules\student\controllers;

use Yii;
use app\modules\student\models\StuCategory;
use app\modules\student\models\StuCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\bootstrap\ActiveForm;

class StuCategoryController extends Controller
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
     * Lists all StuCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StuCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
	$model = new StuCategory();

        return $this->render('index', [
        	    'searchModel' => $searchModel,
        	    'dataProvider' => $dataProvider,
		    'model' => $model,
        	]);
    }

    /**
     * Displays a single StuCategory model.
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
     * Creates a new StuCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StuCategory();
        $searchModel = new StuCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if ($model->load(Yii::$app->request->post())) {

		if (Yii::$app->request->isAjax) {
                        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ActiveForm::validate($model);
       		}

		$model->attributes = $_POST['StuCategory'];
		$model->created_by = Yii::$app->getid->getId();
		$model->created_at= new \yii\db\Expression('NOW()');
		if($model->save())
			return $this->redirect(['index']);
		else
			return $this->render('index', [
               		 'model' => $model,'searchModel' => $searchModel,
			    'dataProvider' => $dataProvider,
			]);

        } else {
            	return $this->render('index', [
               		 'model' => $model,'searchModel' => $searchModel,
			    'dataProvider' => $dataProvider,
			]);
        }
    }

    /**
     * Updates an existing StuCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
	$searchModel = new StuCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if ($model->load(Yii::$app->request->post())) {

		if (Yii::$app->request->isAjax) {
                        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ActiveForm::validate($model);
       		}

		$model->attributes = $_POST['StuCategory'];
		$model->updated_by = Yii::$app->getid->getId();
		$model->updated_at= new \yii\db\Expression('NOW()');
		if($model->save())
			return $this->redirect(['index']);
		else
			return $this->render('index', [
               		 'model' => $model,'searchModel' => $searchModel,
			    'dataProvider' => $dataProvider,
			]);

        } else {
           return $this->render('index', [
               		 'model' => $model,'searchModel' => $searchModel,
			    'dataProvider' => $dataProvider,
			]);
        }
    }

    /**
     * Deletes an existing StuCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
	$model = StuCategory::findOne($id);
        $model->is_status = 2;
	$model->updated_by = Yii::$app->getid->getId();
	$model->updated_at = new \yii\db\Expression('NOW()');
	$model->update();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StuCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StuCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StuCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
