<?php


namespace app\modules\employee\controllers;

use yii\web\Controller;
use app\modules\employee\models\EmpMaster;
use Yii;

class DefaultController extends Controller
{
    public function actionIndex()
    {
    	$empDesignWise = [];
    	if(Yii::$app->session->get('stu_id'))
    		return $this->redirect(['/employee/emp-master/index']);

    	//Department wise employee display
    	$empDepWise = (new \yii\db\Query())
    		    ->select(["CONCAT(dp.emp_department_name, ' (', COUNT( emp_master_id ), ')') AS '0'", 'COUNT(emp_master_id) AS "1"'])
    		    ->from('emp_master em')
    		    ->join('JOIN', 'emp_department dp', 'dp.emp_department_id = em.emp_master_department_id')
    		    ->where(['em.is_status' => '0', 'dp.is_status' => '0'])
    		    ->groupBy('em.emp_master_department_id')
    		    ->all();

    	//Recently added student list
    	$empRecent = (new \yii\db\Query())
    		    ->select(['em.emp_master_id', 'emp_unique_id', "CONCAT(ei.emp_first_name, ' ', ei.emp_last_name) AS 'emp_name'", 'dp.emp_department_name', 'DATE_FORMAT(em.created_at, "%d-%m-%Y") AS cDate'])
    		    ->from('emp_master em')
    		    ->join('JOIN', 'emp_info ei', 'ei.emp_info_emp_master_id = em.emp_master_id')
    		    ->join('JOIN', 'emp_department dp', 'dp.emp_department_id = em.emp_master_department_id')
    		    ->where(['em.is_status' => '0'])
    		    ->orderBy('emp_master_id DESC')
    		    ->limit(10)
    		    ->all();

    	/**
    	* @Start Designation wise employee display
    	*/
    	$empDesignWise = (new \yii\db\Query())
    		    ->select(["CONCAT(ds.emp_designation_name, ' (', COUNT( emp_master_id ), ')') AS '0'", 'COUNT(emp_master_id) AS "1"'])
    		    ->from('emp_master em')
    		    ->join('JOIN', 'emp_designation ds', 'ds.emp_designation_id = em.emp_master_designation_id')
    		    ->where(['em.is_status' => '0'])
    		    ->groupBy('emp_master_designation_id')
    		    ->all();
    	$empDesignWiseNull = EmpMaster::find()->where(['is_status'=>0, 'emp_master_designation_id'=>NULL])->count();
    	if(!empty($empDesignWiseNull)) {
    		$empDesignWise[] = ['name'=>'Not Set ('.($empDesignWiseNull).')', 'y'=>$empDesignWiseNull, 'sliced'=>true, 'selected'=>true, 'color'=>'#F45B5B'];
    	}

        return $this->render('index', ['empDepWise'=>$empDepWise, 'empRecent'=>$empRecent, 'empDesignWise'=>$empDesignWise]);
    }
}
