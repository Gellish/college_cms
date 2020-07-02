<?php

namespace app\modules\employee\controllers;
use yii\web\Controller;
use Yii;
use app\modules\employee\models\EmpDocs;
use app\modules\employee\models\EmpMaster;
use app\modules\employee\models\EmpAddress;
use app\modules\employee\models\EmpInfo;
use app\models\Nationality;

class ExportDataController extends Controller
{
	public function actionEmployeeProfilePdf($eid)
	{
		$nationality = $empAdd = [];

		$empMaster = EmpMaster::findOne($eid);
		$empDocs = EmpDocs::find()->where(['emp_docs_emp_master_id'=>$eid])->join('join','document_category dc', 'dc.doc_category_id = emp_docs_category_id AND dc.is_status <> 2')->all();
		$empInfo = EmpInfo::find()->where(['emp_info_emp_master_id'=>$eid])->one();

		if($empMaster->emp_master_nationality_id !== null)
			$nationality = Nationality::findOne($empMaster->emp_master_nationality_id)->nationality_name;

		if($empMaster->emp_master_emp_address_id !== null)
			$empAdd = EmpAddress::findOne($empMaster->emp_master_emp_address_id);

		$html = $this->renderPartial('/emp-master/empprofilepdf',
			[
				'empDocs'=>$empDocs,
				'empMaster'=>$empMaster,
				'empInfo'=>$empInfo,
				'nationality'=>$nationality,
				'empAdd'=>$empAdd,
			]);
		$fName = $empInfo->emp_first_name."_".$empInfo->emp_last_name."_".date('Ymd_His');
		return Yii::$app->pdf->exportData(Yii::t('emp','Employee Profile'),$fName,$html);
	}

}
