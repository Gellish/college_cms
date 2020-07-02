<?php



namespace app\modules\student\controllers;

use yii\web\Controller;
use Yii;

class DependentController extends Controller
{

	// get student batch based on course selection -------------------

	public function actionStudbatch($id){

		$rows = \app\modules\course\models\Batches::find()->where(['batch_course_id' => $id, 'is_status' => 0])->all();
	 
		echo "<option value=''>".Yii::t('stu', ' --- Select Batch --- ')."</option>";
	 
		if(count($rows)>0){
		    foreach($rows as $row){
		        echo "<option value='$row->batch_id'>$row->batch_name</option>";
		    }
		}
		else{
		    echo "";
		}
 
    	}

	// get student section based on batch selection -------------------

	public function actionStudsection($id){

		$rows = \app\modules\course\models\Section::find()->where(['section_batch_id' => $id, 'is_status' => 0])->all();
	 
		echo "<option value=''>".Yii::t('stu', '--- Select Section ---')."</option>";
	 
		if(count($rows)>0){
		    foreach($rows as $row){
		        echo "<option value='$row->section_id'>$row->section_name</option>";
		    }
		}
		else{
		    echo "";
		}
 
    	}
	
	// get student country's state based on current country updation -----------

	public function actionUstud_c_state($id){

		$rows = \app\models\State::find()->where(['state_country_id' => $id, 'is_status' => 0])->all();
	 
		echo "<option value=''>".Yii::t('stu', '--- Select State ---')."</option>";
	 
		if(count($rows)>0){
		    foreach($rows as $row){
		        echo "<option value='$row->state_id'>$row->state_name</option>";
		    }
		}
		else{
		    echo "";
		}
 
    	}

	// get student state's city based on current state updation -----------

	public function actionUstud_c_city($id){

		$rows = \app\models\City::find()->where(['city_state_id' => $id, 'is_status' => 0])->all();
	 
		echo "<option value=''>".Yii::t('stu', '--- Select City ---')."</option>";
	 
		if(count($rows)>0){
		    foreach($rows as $row){
		        echo "<option value='$row->city_id'>$row->city_name</option>";
		    }
		}
		else{
		    echo "";
		}
 
    	}
	
	// get student country's state based on international country updation -----------

	public function actionUstud_p_state($id){

		$rows = \app\models\State::find()->where(['state_country_id' => $id, 'is_status' => 0])->all();
	 
		echo "<option value=''>".Yii::t('stu', '--- Select State ---')."</option>";
	 
		if(count($rows)>0){
		    foreach($rows as $row){
		        echo "<option value='$row->state_id'>$row->state_name</option>";
		    }
		}
		else{
		    echo "";
		}
 
    	}

	// get student state's city based on international state updation -----------

	public function actionUstud_p_city($id){

		$rows = \app\models\City::find()->where(['city_state_id' => $id, 'is_status' => 0])->all();
	 
		echo "<option value=''>".Yii::t('stu', '--- Select City ---')."</option>";
	 
		if(count($rows)>0){
		    foreach($rows as $row){
		        echo "<option value='$row->city_id'>$row->city_name</option>";
		    }
		}
		else{
		    echo "";
		}
 
    	}
}
