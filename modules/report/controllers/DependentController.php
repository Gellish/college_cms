<?php



namespace app\modules\report\controllers;
use yii\helpers\Html;
use Yii;

class DependentController extends \yii\web\Controller
{
	/* for stuinforeport get batch of selected course */
	public function actionStudbatch($id)
	{
		$rows = \app\modules\course\models\Batches::find()->where(['batch_course_id' => $id, 'is_status' => 0])->all();	 
		echo "<option value=''>" .Yii::t('app', '--- Select Batch ---'). "</option>";
	 
		if(count($rows) > 0){
		    foreach($rows as $row){
		        echo "<option value='$row->batch_id'>$row->batch_name</option>";
		    }
		}
		else{
		    echo "";
		}
 
    	}

	// get student section based on batch selection -------------------

	public function actionStudsection($id)
	{
		$rows = \app\modules\course\models\Section::find()->where(['section_batch_id' => $id, 'is_status' => 0])->all();
	 
		echo "<option value=''>" .Yii::t('app', '--- Select Section ---'). "</option>";
	 
		if(count($rows) > 0){
		    foreach($rows as $row){
		        echo "<option value='$row->section_id'>$row->section_name</option>";
		    }
		}
		else{
		    echo "";
		}
 
    	}
        public function actionIndex()
        {
            return $this->render('index');
        }

}
