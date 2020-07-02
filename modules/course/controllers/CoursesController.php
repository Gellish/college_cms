<?php




namespace app\modules\course\controllers;

use Yii;
use app\modules\course\models\Courses;
use app\modules\course\models\Batches;
use app\modules\course\models\Section;
use app\modules\course\models\CoursesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\GetUserId;
use yii\bootstrap\ActiveForm;
use yii\helpers\Json;
use yii\web\HttpException;
use pheme\grid\actions\ToggleAction;


class CoursesController extends Controller
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
		    'modelClass' => 'app\modules\course\models\Courses',
		    'attribute' => 'is_status',
		    // Uncomment to enable flash messages
		    'setFlash' => true,
		],
	    ];
    }

    /**
     * Lists all Courses models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CoursesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Courses model.
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
     * Creates a new Courses model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Courses();
	$batch = new Batches();
	$section = new Section(); 

	if (($model->load(Yii::$app->request->post()) && $batch->load(Yii::$app->request->post()) && $section->load(Yii::$app->request->post())) && Yii::$app->request->isAjax) {
        	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        	return array_merge(ActiveForm::validate($model), ActiveForm::validate($batch), ActiveForm::validate($section));
 	}

        if ($model->load(Yii::$app->request->post()) && $batch->load(Yii::$app->request->post()) && $section->load(Yii::$app->request->post())) {

		$model->attributes = $_POST['Courses'];
		$model->created_by = Yii::$app->getid->getId(); 
		$model->created_at = new \yii\db\Expression('NOW()');
	
		if($model->save())
		{
		    if(isset($_POST['Batches']))
		    {
			   $batch->attributes = $_POST['Batches'];
			   $batch->batch_course_id = $model->course_id;
			   $batch->start_date = date('Y-m-d', strtotime($_POST['Batches']['start_date']));
			   $batch->end_date = date('Y-m-d', strtotime($_POST['Batches']['end_date']));
			   $batch->created_by = Yii::$app->getid->getId();
			   $batch->created_at= new \yii\db\Expression('NOW()');
			   if($batch->save())
			   {
				$section->attributes = $_POST['Section'];
				$section->section_batch_id = $batch->batch_id;
				$section->created_by = Yii::$app->getid->getId();
				$section->created_at = new \yii\db\Expression('NOW()');
				
				if($section->save())
					return $this->redirect(['index']);
				else
					return $this->render('create', ['model' => $model, 'batch' => $batch, 'section' => $section,]);	
			   }
		     }
		}
		else
		    return $this->render('create', ['model' => $model, 'batch' => $batch, 'section' => $section,]);
        }
	else {
            return $this->render('create', [
                'model' => $model, 'batch' => $batch, 'section' => $section,
            ]);
        }
    }

    /**
     * Updates an existing Courses model.
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

		$model->attributes = $_POST['Courses'];
		$model->updated_at = new \yii\db\Expression('NOW()');
		$model->updated_by = Yii::$app->getid->getId();
		$model->save();
		return $this->redirect(['view', 'id' => $model->course_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Courses model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
	$batch = Batches::find()->where('batch_course_id='.$id.' AND is_status!=2')->exists();
	if($batch)
	{
		$err_msg = 'Batch';
	}
	else
	{
		$err_msg = '';
	}

	if(!empty($err_msg))
		throw new HttpException(400,'You can not delete this record because it is used in '.$err_msg.' table.');
	else  {
        	$model = Courses::findOne($id);
		$model->is_status = 2;
		$model->update();
	}

        return $this->redirect(['index']);
    }

    /**
     * Finds the Courses model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Courses the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Courses::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
