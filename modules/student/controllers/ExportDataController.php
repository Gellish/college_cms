<?php




namespace app\modules\student\controllers;

use yii\web\Controller;
use Yii;
use app\modules\student\models\StuDocs;
use app\modules\student\models\StuMaster;
use app\modules\student\models\StuInfo;
use app\modules\student\models\StuAddress;
use app\modules\student\models\StuCategory;
use app\modules\course\models\Courses;
use app\modules\course\models\Batches;
use app\modules\course\models\Section;
use app\modules\student\models\StuGuardians;
use app\models\Nationality;

class ExportDataController extends Controller
{
	public function actionStudentProfilePdf($sid)
	{
		$nationality = $stuAdd =  [];

		$stuMaster = StuMaster::findOne($sid);
		$stuDocs = StuDocs::find()->where(['stu_docs_stu_master_id' => $sid])->join('join','document_category dc', 'dc.doc_category_id = stu_docs_category_id AND dc.is_status <> 2')->all();
		$stuInfo = StuInfo::find()->where(['stu_info_stu_master_id' => $sid])->one();
		$stuCourse = Courses::findOne($stuMaster->stu_master_course_id);
		$stuBatch = Batches::findOne($stuMaster->stu_master_batch_id);
		$stuSection = Section::findOne($stuMaster->stu_master_section_id);
		$stuGuard = StuGuardians::findAll(['guardia_stu_master_id' => $sid]);
		$sDocs = new StuDocs;
		
		if($stuMaster->stu_master_nationality_id !== null)
			$nationality = Nationality::findOne($stuMaster->stu_master_nationality_id)->nationality_name;

		if($stuMaster->stu_master_stu_address_id !== null)
			$stuAdd = StuAddress::findOne($stuMaster->stu_master_stu_address_id);
		 
		$html = $this->renderPartial('/stu-master/stuprofilepdf',
			[
				'stuDocs' => $stuDocs,
				'stuMaster' => $stuMaster,
				'stuInfo' => $stuInfo,	
				'nationality' => $nationality,
				'stuBatch' => $stuBatch,
				'stuCourse' => $stuCourse,
				'stuSection' => $stuSection,
				'stuAdd' => $stuAdd,
				'stuGuard' => $stuGuard,
				'sDocs' => $sDocs,
			]);
		$fName = $stuInfo->stu_first_name."_".$stuInfo->stu_last_name."_".date('Ymd-His');
		return Yii::$app->pdf->exportData(Yii::t('report','Student Report'),$fName,$html);
	}
}
