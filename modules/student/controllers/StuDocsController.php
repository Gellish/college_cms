<?php

namespace app\modules\student\controllers;

use Yii;
use app\modules\student\models\StuDocs;
use app\modules\student\models\StuDocsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\bootstrap\ActiveForm;
use yii\helpers\Json;
use yii\web\UploadedFile;

class StuDocsController extends Controller
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
     * Lists all StuDocs models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StuDocsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StuDocs model.
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
     * Creates a new StuDocs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StuDocs();

        if ($model->load(Yii::$app->request->post())) {

		$model->attributes = $_POST['StuDocs'];
		$model->created_by = Yii::$app->getid->getId();
		$model->stu_docs_stu_master_id = 3;
		$model->stu_docs_submited_at = new \yii\db\Expression('NOW()');
		$model->stu_docs_path = UploadedFile::getInstance($model,'stu_docs_path');
		$model->stu_docs_path->saveAs(Yii::$app->basePath.'/web/data/stu_docs/' .$model->stu_docs_path);

			if($model->save(false))
				return $this->redirect(['view', 'id' => $model->stu_docs_id]);
			else
				return $this->render('create', ['model' => $model,]);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing StuDocs model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

		$model->attributes = $_POST['StuDocs'];
		$model->stu_docs_stu_master_id = 3;
		//$model->stu_docs_submited_at = new \yii\db\Expression('NOW()');
		$model->stu_docs_path = UploadedFile::getInstance($model,'stu_docs_path');
		$model->stu_docs_path->saveAs(Yii::$app->basePath.'/web/data/stu_docs/' .$model->stu_docs_path);
			if($model->save(false))
				return $this->redirect(['view', 'id' => $model->stu_docs_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing StuDocs model.
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
     * Finds the StuDocs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StuDocs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StuDocs::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
