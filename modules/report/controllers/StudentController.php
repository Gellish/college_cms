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

class StudentController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionStuinforeport()
    {

    	$student_data = $selected_list = [];
    	$model = new StuMaster();
    	$info = new StuInfo();

        if($model->load(Yii::$app->request->post()) && $info->load(Yii::$app->request->post()))
        {
            if (Yii::$app->request->isAjax) {
    			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    			return ActiveForm::validateMultiple([$model,$info]);
            }


    		$selected_list = $_POST['s_info'];

    		$query1 = new \yii\db\Query();
    		$query1->select('*')
                ->from('stu_master stu')
                ->join('join','stu_info s_info','s_info.stu_info_id = stu.stu_master_stu_info_id')
                ->join('join','stu_address add', 'add.stu_address_id = stu.stu_master_stu_address_id')
                ->where(['stu.is_status' => 0])
                ->andFilterWhere(['stu.stu_master_course_id' => $model->stu_master_course_id])
                ->andFilterWhere(['stu.stu_master_batch_id' => $model->report_batch_id])
                ->andFilterWhere(['stu.stu_master_section_id' => $model->report_section_id])
                ->andFilterWhere(['add.stu_cadd_city' => $model->report_city])
                ->andFilterWhere(['s_info.stu_gender' => $info->stu_gender]);

    		$command=$query1->createCommand();
    		$student_data=$command->queryAll();
            Yii::$app->session->set('data["stuData"]',$student_data);
            Yii::$app->session->set('data["selection"]',$selected_list);

    		if(empty($student_data)){
    			 \Yii::$app->getSession()->setFlash('studerror',"<i class='fa fa-exclamation-triangle'></i> <b> ".Yii::t('report', 'No Record Found For This Criteria.')."</b>");
    				return $this->redirect(['stuinforeport']);
    		}
    	return $this->render('stu_info_report',[
    		'student_data'=>$student_data,
            'selected_list'=>$selected_list,
    	]);

    	} else if(Yii::$app->request->get('exportExcel')) {
            $file = $this->renderPartial('stu_info_report_excel', array(
                'student_data' => Yii::$app->session->get('data["stuData"]'),
                'selected_list' => Yii::$app->session->get('data["selection"]'),
            ));
            $fileName = "Employee_info_report".date('YmdHis').'.xls';
            $options = ['mimeType'=>'application/vnd.ms-excel'];
            return Yii::$app->excel->exportExcel($file, $fileName, $options);

        } else if(Yii::$app->request->get('exportPDF')) {
            $html = $this->renderPartial('stu_info_report_pdf', array(
                'student_data' => Yii::$app->session->get('data["stuData"]'),
                'selected_list' => Yii::$app->session->get('data["selection"]'),
            ));
            ob_clean();
            return Yii::$app->pdf->exportData('Employee Info Report','Employee_info_report',$html);
        }
    	return $this->render('stu_report_view',[
            'model'=>$model,
            'info'=>$info,
    		'selected_list'=>$selected_list,
    	]);
    }
}
