<?php



namespace app\modules\employee\controllers;

use yii\web\Controller;
use Yii;

class DependentController extends Controller
{

	// Get Employee state based on current country 

	public function actionEmp_c_state($id){

		$rows = \app\models\State::find()->where(['state_country_id' => $id,'is_status' => 0])->all();
	 
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

	// get Employee city based on current state 

	public function actionEmp_c_city($id){

		$rows = \app\models\City::find()->where(['city_state_id' => $id,'is_status' => 0])->all();
	 
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
	
	// get Employee state based on Permanent country 

	public function actionEmp_p_state($id){

		$rows = \app\models\State::find()->where(['state_country_id' => $id,'is_status' => 0])->all();
	 
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

	// get Employee city based on Permenant state 

	public function actionEmp_p_city($id){

		$rows = \app\models\City::find()->where(['city_state_id' => $id,'is_status' => 0])->all();
	 
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
