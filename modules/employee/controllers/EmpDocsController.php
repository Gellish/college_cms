<?php



namespace app\modules\employee\controllers;

use Yii;
use app\modules\employee\models\EmpDocs;
use app\modules\employee\models\EmpDocsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\bootstrap\ActiveForm;
use yii\helpers\Json;
use yii\web\UploadedFile;
use app\models\Category;
use yii\helpers\Url;

class EmpDocsController extends Controller
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
     * Lists all EmpDocs models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmpDocsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmpDocs model.
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
     * Creates a new EmpDocs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmpDocs();
         if ($model->load(Yii::$app->request->post())) {
    		$model->attributes = $_POST['EmpDocs'];
    		$model->emp_docs_path = UploadedFile::getInstance($model,'emp_docs_path');
    		$model->emp_docs_path->saveAs(Yii::$app->basePath.'/web/data/emp_docs/' .$model->emp_docs_path);
    		$model->created_by = Yii::$app->getid->getId();
    		$model->emp_docs_submited_at = new \yii\db\Expression('NOW()');
    		$model->emp_docs_emp_master_id=3;
    		if($model->save(false))
                return $this->redirect(['view', 'id' => $model->emp_docs_id]);
    		else
                return $this->render('create', ['model' => $model]);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EmpDocs model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
        	$model->attributes = $_POST['EmpDocs'];
        	$model->emp_docs_path = UploadedFile::getInstance($model,'emp_docs_path');
        	$model->emp_docs_path->saveAs(Yii::$app->basePath.'/web/data/emp_docs/' .$model->emp_docs_path);
        	$model->created_by = Yii::$app->getid->getId();
        	$model->emp_docs_submited_at = new \yii\db\Expression('NOW()');
        	$model->emp_docs_emp_master_id=3;
        	if($model->save(false))
                return $this->redirect(['view', 'id' => $model->emp_docs_id]);
        	else
                return $this->render('create', ['model' => $model]);

            return $this->redirect(['view', 'id' => $model->emp_docs_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EmpDocs model.
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
     * Finds the EmpDocs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmpDocs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmpDocs::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
