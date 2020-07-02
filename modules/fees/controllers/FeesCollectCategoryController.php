<?php



namespace app\modules\fees\controllers;

use Yii;
use app\modules\fees\models\FeesCollectCategory;
use app\modules\fees\models\FeesCategoryDetails;
use app\modules\fees\models\FeesCollectCategorySearch;
use app\modules\course\models\Batches;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use pheme\grid\actions\ToggleAction;
use yii\helpers\Json;

class FeesCollectCategoryController extends Controller
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
		    'modelClass' => 'app\modules\fees\models\FeesCollectCategory',
		    'attribute' => 'is_status',
		    //'type'=> 'toggle-status',
		    // Uncomment to enable flash messages
		    'setFlash' => true,
		],
	    ];
    }	
    /**
     * Lists all FeesCollectCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FeesCollectCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FeesCollectCategory model.
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
     * Creates a new FeesCollectCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FeesCollectCategory();

        if ($model->load(Yii::$app->request->post()) && isset($_POST['FeesCollectCategory'])) {

		$model->attributes = $_POST['FeesCollectCategory'];
		for($i=0;$i<count($_REQUEST['FeesCollectCategory']['fees_collect_batch_id']);$i++) :
			$model->fees_collect_category_id = NULL;
			$model->isNewRecord = true;
			$model->fees_collect_batch_id = $_POST['FeesCollectCategory']['fees_collect_batch_id'][$i];
			$model->fees_collect_name = $_POST['FeesCollectCategory']['fees_collect_name'];
			$model->fees_collect_details = $_POST['FeesCollectCategory']['fees_collect_details'];
			$model->fees_collect_start_date = Yii::$app->dateformatter->getDateFormat($_POST['FeesCollectCategory']['fees_collect_start_date']);
			$model->fees_collect_end_date = Yii::$app->dateformatter->getDateFormat($_POST['FeesCollectCategory']['fees_collect_end_date']);
			$model->fees_collect_due_date = Yii::$app->dateformatter->getDateFormat($_POST['FeesCollectCategory']['fees_collect_due_date']);
			$model->created_by = Yii::$app->getid->getId(); 
			$model->created_at = new \yii\db\Expression('NOW()');

			if($model->save()) {
			      Yii::$app->session->setFlash('green-'.$i, '<i class="fa fa-info-circle"></i> <b>Fees Category:</b> '.$_POST['FeesCollectCategory']['fees_collect_name'].' for <b>Batch: </b>'.Batches::findOne($_POST['FeesCollectCategory']['fees_collect_batch_id'][$i])->batch_name.' is created successfully');
			} else {
			      Yii::$app->session->setFlash('red-'.$i, '<i class="fa fa-warning"></i> The combination of <b>Fees Category:</b> '.$_POST['FeesCollectCategory']['fees_collect_name'].' and <b>Batch: </b>'.Batches::findOne($_POST['FeesCollectCategory']['fees_collect_batch_id'][$i])->batch_name.' has already been taken.');
			}
				
		endfor;
	
			return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FeesCollectCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

		$model->attributes = $_POST['FeesCollectCategory'];
		$model->fees_collect_start_date = Yii::$app->dateformatter->getDateFormat($_POST['FeesCollectCategory']['fees_collect_start_date']);
		$model->fees_collect_end_date = Yii::$app->dateformatter->getDateFormat($_POST['FeesCollectCategory']['fees_collect_end_date']);
		$model->fees_collect_due_date = Yii::$app->dateformatter->getDateFormat($_POST['FeesCollectCategory']['fees_collect_due_date']);
		$model->updated_by = Yii::$app->getid->getId(); 
		$model->updated_at = new \yii\db\Expression('NOW()');

		if($model->save())
			return $this->redirect(['view', 'id' => $model->fees_collect_category_id]);
		else
			return $this->render('update', ['model' => $model,]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FeesCollectCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = FeesCollectCategory::findOne($id);
	$model->is_status = 2;
	$model->updated_by = Yii::$app->getid->getId(); 
	$model->updated_at = new \yii\db\Expression('NOW()');
	$model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FeesCollectCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FeesCollectCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FeesCollectCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
