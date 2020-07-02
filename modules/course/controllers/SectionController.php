<?php




namespace app\modules\course\controllers;

use Yii;
use app\modules\course\models\Section;
use app\modules\course\models\SectionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\bootstrap\ActiveForm;
use yii\helpers\Json;
use pheme\grid\actions\ToggleAction;


class SectionController extends Controller
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
		    'modelClass' => 'app\modules\course\models\Section',
		    'attribute' => 'is_status',
		    // Uncomment to enable flash messages
		    'setFlash' => true,
		],
	    ];
    } 
    /**
     * Lists all Section models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SectionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Section model.
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
     * Creates a new Section model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Section();

	if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
        	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        	return ActiveForm::validate($model);
       	}
	if ($model->load(Yii::$app->request->post())) {
		
			$model->attributes = $_POST['Section'];
			$model->created_at = new \yii\db\Expression('NOW()');
			$model->created_by = Yii::$app->getid->getId();
			$model->save();
			return $this->redirect(['index']);
       	}
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Section model.
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

		$model->attributes = $_POST['Section'];
		$model->updated_at = new \yii\db\Expression('NOW()');
		$model->updated_by = Yii::$app->getid->getId();
		$model->save();
		return $this->redirect(['view', 'id' => $model->section_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Section model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = Section::findOne($id);
	$model->is_status = 2;
	$model->update();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Section model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Section the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Section::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
