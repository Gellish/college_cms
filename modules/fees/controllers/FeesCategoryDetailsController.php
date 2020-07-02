<?php



namespace app\modules\fees\controllers;

use Yii;
use app\modules\fees\models\FeesCategoryDetails;
use app\modules\fees\models\FeesCategoryDetailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class FeesCategoryDetailsController extends Controller
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
     * Lists all FeesCategoryDetails models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FeesCategoryDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FeesCategoryDetails model.
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
     * Creates a new FeesCategoryDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($fcc_id)
    {
        $model = new FeesCategoryDetails();
	if(!empty($fcc_id))
		$feescc_id = $fcc_id;
	else
		throw new NotFoundHttpException('The requested page does not exist.');

        if ($model->load(Yii::$app->request->post())) {
		
		$model->attributes = $_POST['FeesCategoryDetails'];
		$model->fees_details_category_id = $feescc_id;
		$model->created_by = Yii::$app->getid->getId(); 
		$model->created_at = new \yii\db\Expression('NOW()');

		if($model->save())
			return $this->redirect(['fees-collect-category/view', 'id' => $model->fees_details_category_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FeesCategoryDetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($fcd_id)
    {
        $model = $this->findModel($fcd_id);

        if ($model->load(Yii::$app->request->post())) {

		$model->attributes = $_POST['FeesCategoryDetails'];
		$model->updated_by = Yii::$app->getid->getId(); 
		$model->updated_at = new \yii\db\Expression('NOW()');

		if($model->save())
			return $this->redirect(['fees-collect-category/view', 'id' => $model->fees_details_category_id]);
           
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FeesCategoryDetails model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($fcd_id, $fcc_id)
    {
        $model = FeesCategoryDetails::findOne($fcd_id);
	$model->is_status = 2;
	$model->updated_by = Yii::$app->getid->getId(); 
	$model->updated_at = new \yii\db\Expression('NOW()');
	$model->save();

        return $this->redirect(['fees-collect-category/view', 'id' => $fcc_id]);
    }

    /**
     * Finds the FeesCategoryDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FeesCategoryDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FeesCategoryDetails::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
