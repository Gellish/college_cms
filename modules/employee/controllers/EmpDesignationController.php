<?php



namespace app\modules\employee\controllers;

use Yii;
use app\modules\employee\models\EmpDesignation;
use app\modules\employee\models\EmpDesignationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\bootstrap\ActiveForm;

class EmpDesignationController extends Controller
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
     * Lists all EmpDesignation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmpDesignationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new EmpDesignation();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
	    'model' => $model,
        ]);
    }

    /**
     * Displays a single EmpDesignation model.
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
     * Creates a new EmpDesignation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmpDesignation();
        $searchModel = new EmpDesignationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if ($model->load(Yii::$app->request->post())) {
		if (Yii::$app->request->isAjax) {
                        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ActiveForm::validate($model);
       		}
		$model->attributes = $_POST['EmpDesignation'];
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
                'model' => $model,'searchModel' => $searchModel,'dataProvider' => $dataProvider,
            ]);
        }

    }

    /**
     * Updates an existing EmpDesignation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $searchModel = new EmpDesignationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if ($model->load(Yii::$app->request->post())) {
		if (Yii::$app->request->isAjax) {
                        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ActiveForm::validate($model);
       		}
		$model->attributes = $_POST['EmpDesignation'];
		$model->updated_by = Yii::$app->getid->getId();
		$model->updated_at = new \yii\db\Expression('NOW()');

		if($model->save())
           	      return $this->redirect(['index']);
		else
			return $this->render('index', [
               		 'model' => $model,'searchModel' => $searchModel,
			    'dataProvider' => $dataProvider,
			]);
        } else {
            return $this->render('index', [
                'model' => $model,
'               searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Deletes an existing EmpDesignation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = EmpDesignation::findOne($id);
        $model->is_status = 2;
        $model->updated_by = Yii::$app->getid->getId();
        $model->updated_at = new \yii\db\Expression('NOW()');
        $model->update();
        return $this->redirect(['index']);
    }

    /**
     * Finds the EmpDesignation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmpDesignation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmpDesignation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
