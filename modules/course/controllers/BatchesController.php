<?php


namespace app\modules\course\controllers;

use Yii;
use app\modules\course\models\Batches;
use app\modules\course\models\BatchesSearch;
use app\modules\course\models\Section;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use yii\bootstrap\ActiveForm;
use yii\helpers\Json;
use pheme\grid\actions\ToggleAction;

class BatchesController extends Controller
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
    public function actions() 
    {
	    return [
		'toggle' => [
		    'class' => ToggleAction::className(),
		    'modelClass' => 'app\modules\course\models\Batches',
		    'attribute' => 'is_status',
		    // Uncomment to enable flash messages
		    'setFlash' => true,
		],
	    ];
    } 
    /**
     * Lists all Batches models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BatchesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Batches model.
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
     * Creates a new Batches model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Batches();

	if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
        	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        	return ActiveForm::validate($model);
       	}

        if ($model->load(Yii::$app->request->post())) {

		$model->attributes = $_POST['Batches'];
		$model->start_date = Yii::$app->dateformatter->getDateFormat($_POST['Batches']['start_date']);
		$model->end_date = Yii::$app->dateformatter->getDateFormat($_POST['Batches']['end_date']);
		$model->created_by = Yii::$app->getid->getId();
		$model->created_at= new \yii\db\Expression('NOW()');
		if($model->save())
			return $this->redirect(['index']);
		else
			return $this->render('create', ['model' => $model,]);
	
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Batches model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

	if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
        	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        	return ActiveForm::validate($model);
       	}
        if ($model->load(Yii::$app->request->post())) {

		$model->attributes = $_POST['Batches'];
		$model->start_date = Yii::$app->dateformatter->getDateFormat($_POST['Batches']['start_date']);
		$model->end_date = Yii::$app->dateformatter->getDateFormat($_POST['Batches']['end_date']);
		$model->updated_by = Yii::$app->getid->getId();
		$model->updated_at= new \yii\db\Expression('NOW()');
		if($model->save())
			return $this->redirect(['view', 'id' => $model->batch_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Batches model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
	$section = Section::find()->where(['section_batch_id' => $id, 'is_status' => 0])->exists();
	if($section)
	{
		$err_msg = 'Section';
	}
	else
	{
		$err_msg = '';
	}

	if(!empty($err_msg))
		throw new HttpException(400,'You can not delete this record because it is used in '.$err_msg.' table.');
	else {
		$model = Batches::findOne($id);
        	$model->is_status = 2;
		$model->update();
	}
        return $this->redirect(['index']);
    }

    /**
     * Finds the Batches model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Batches the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Batches::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
