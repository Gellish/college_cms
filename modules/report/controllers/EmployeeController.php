<?php



namespace app\modules\report\controllers;

use yii\web\Controller;
use Yii;
use app\modules\employee\models\EmpMasterSearch;
use app\modules\student\models\StuMasterSearch;
use app\modules\student\models\StuMaster;
use app\modules\student\models\StuInfo;
use app\models\City;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\web\NotFoundHttpException;

class EmployeeController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /* Employee Info Dynamic Report */
    public function actionEmpinforeport()
    {
        $employee_data = $selected_list = array();
        if(!empty(Yii::$app->request->post('e_info')))
        {
            $selected_list = Yii::$app->request->post('e_info');
            $employee_d = new \yii\db\Query();
            $employee_d ->select('*')
            	->from('emp_master emp')
            	->join('join','emp_info e_info', 'e_info.emp_info_id = emp.emp_master_emp_info_id')
            	->join('join','emp_department emp_dep','emp_dep.emp_department_id = emp.emp_master_department_id ')
            	->join('join','emp_designation emp_des','emp_des.emp_designation_id = emp.emp_master_designation_id ')
            	->join('join','emp_category emp_cat','emp_cat.emp_category_id = emp. 	emp_master_category_id')
            	->leftJoin('emp_address eadd', 'eadd.emp_address_id = emp.emp_master_emp_address_id')
            	->where(['emp.is_status' => 0])
                ->andFilterWhere(['emp.emp_master_department_id' => Yii::$app->request->post('department')])
                ->andFilterWhere(['emp.emp_master_designation_id' => Yii::$app->request->post('designation')])
                ->andFilterWhere(['emp.emp_master_emp_address_id' => Yii::$app->request->post('city')])
                ->andFilterWhere(['emp.emp_master_category_id' => Yii::$app->request->post('category')])
                ->andFilterWhere(['e_info.emp_gender' => Yii::$app->request->post('gender')]);

            $command = $employee_d->createCommand();
            $employee_data = $command->queryAll();
            Yii::$app->session->set('data["empData"]',$employee_data);
            Yii::$app->session->set('data["selection"]',$selected_list);
            if(empty($employee_data))
            {
                \Yii::$app->getSession()->setFlash('emperror',"<i class='fa fa-exclamation-triangle'></i> <b>".Yii::t('report', 'No Record Found For This Criteria.')."</b>");
            	return $this->redirect(['empinforeport']);
            }
            return $this->render('emp_info_report',[
            	'employee_data'=>$employee_data, 'selected_list'=>$selected_list, //'query'=>$query,
            ]);
        } else if(Yii::$app->request->get('exportExcel')) {
            $file = $this->renderPartial('emp_info_report_excel', array(
                'employee_data' => Yii::$app->session->get('data["empData"]'),
                'selected_list' => Yii::$app->session->get('data["selection"]'),
            ));
            $fileName = "Employee_info_report".date('YmdHis').'.xls';
            $options = ['mimeType'=>'application/vnd.ms-excel'];
            return Yii::$app->excel->exportExcel($file, $fileName, $options);
        } else if(Yii::$app->request->get('exportPDF')) {
			$html = $this->renderPartial('emp_info_report_pdf', array(
                'employee_data' => Yii::$app->session->get('data["empData"]'),
                'selected_list' => Yii::$app->session->get('data["selection"]'),
			));
			ob_clean();
			return Yii::$app->pdf->exportData('Employee Info Report','Employee_info_report',$html);
        }
        return $this->render('emp_report_view',['selected_list'=>$selected_list]);
    }
}
