<?php


namespace app\modules\fees\controllers;

use yii\web\Controller;
use Yii;

class DefaultController extends Controller
{
    public function actionIndex()
    {
	$paidData = $unPaidData = $fcCategory = [];
	if(Yii::$app->session->get('stu_id'))
		return $this->redirect(['/fees/fees-payment-transaction/stu-fees-data']);
	
	//Course Wise Collection Count
	$cateWisePaid = 0;
	$courseWiseCollect = (new \yii\db\Query())
			->select(["(cs.course_name) AS '0'", 'SUM(fpt.fees_pay_tran_amount) AS "1"'])
			->from('fees_payment_transaction fpt')
			->join('JOIN', 'courses cs', 'cs.course_id = fpt.fees_pay_tran_course_id')
			->where(['cs.is_status'=>0, 'fpt.is_status'=>0])
			->groupBy('fpt.fees_pay_tran_course_id')
			->all();

	$actFcc = \app\modules\fees\models\FeesCollectCategory::find()->where(['is_status'=>0])->asArray()->all();
	
	foreach($actFcc as $v) {
		$stuCount = \app\modules\student\models\StuMaster::find()->where(['is_status'=>0, 'stu_master_batch_id'=>$v['fees_collect_batch_id']])->count();
		$fccTotal = \app\modules\fees\models\FeesCategoryDetails::getFeeCategoryTotal($v['fees_collect_category_id']);
		$cateWisePaid+=($stuCount*$fccTotal); 
	}

	$paidTotal = (new \yii\db\Query())->from('fees_payment_transaction fpt')
		     ->join('JOIN', 'fees_collect_category fcc', 'fpt.fees_pay_tran_collect_id = fees_collect_category_id')
		    ->where(['fcc.is_status'=>0, 'fpt.is_status'=>0])
		    ->sum('fpt.fees_pay_tran_amount');


	$paidPer =' ('.(($cateWisePaid!=0) ? round(($paidTotal*100)/$cateWisePaid, 2) : 0) . '%)';
	$unPaidPer =' ('.(($cateWisePaid!=0) ? round((($cateWisePaid-$paidTotal)*100)/$cateWisePaid, 2) : 0).'%)';

	$paidUnpaidData = [
				['name'=>'Paid'.$paidPer, 'y'=>$paidTotal, 'color'=>'#77C730'],
				['name'=>'Unpaid'.$unPaidPer, 'y'=>($cateWisePaid-$paidTotal), 'color'=>'#F45B5B'],
			];

	
	//Individual Fees Collection Category Wise
	$fcWiseDetails = (new \yii\db\Query())
		    ->select(['fees_collect_category_id', 'fees_collect_batch_id', "CONCAT(fcc.fees_collect_name,'(',bt.batch_name,')') AS fc_name"]) 
		    ->from('fees_collect_category fcc')
		    ->join('JOIN', 'batches bt', 'bt.batch_id = fcc.fees_collect_batch_id')
		    ->where(['fcc.is_status' => '0'])
		    ->orderBy('fcc.fees_collect_category_id DESC')
		    ->limit('10')
		    ->all();
	$fccTotal = $fccPaid = 0;
	foreach($fcWiseDetails as $k=>$v) {
		$stuCount = \app\modules\student\models\StuMaster::find()->where(['is_status'=>0, 'stu_master_batch_id'=>$v['fees_collect_batch_id']])->count();
		$fccTotalTmp = \app\modules\fees\models\FeesCategoryDetails::getFeeCategoryTotal($v['fees_collect_category_id']);
		$fccPaidTmp = (new \yii\db\Query())->from('fees_payment_transaction fpt')->where(['fpt.is_status'=>0, 'fpt.fees_pay_tran_collect_id'=>$v['fees_collect_category_id']])->sum('fpt.fees_pay_tran_amount');

		$fccTotal = $stuCount*$fccTotalTmp;
		$fccPaid = ($fccPaidTmp===NULL) ? 0 : $fccPaidTmp;
		$fccUnPaid = $fccTotal-$fccPaid;
		$fcCategory[] = $v['fc_name'];
		$paidData[] = $fccPaid;
		$unPaidData[] = $fccUnPaid;		
	}
	
	$fccWisePaidUnPaid = [
				['name'=>'Paid Amount', 'data'=>$paidData, 'color'=>'#77C730'],
				['name'=>'Unpaid Amount', 'data'=>$unPaidData, 'color'=>'#F45B5B'],
			];

	//Recently fees transaction
	$feeRecent = (new \yii\db\Query())
		    ->select(['fpt.fees_pay_tran_id', 'fpt.fees_pay_tran_amount', 'stu_unique_id', "CONCAT(si.stu_first_name, ' ', si.stu_last_name) AS 'stu_name'", 'fcc.fees_collect_name', 'DATE_FORMAT(fpt.fees_pay_tran_date, "%d-%m-%Y") AS tranDate']) 
		    ->from('fees_payment_transaction fpt')
		    ->join('JOIN', 'fees_collect_category fcc', 'fcc.fees_collect_category_id = fpt.fees_pay_tran_collect_id')
		    ->join('JOIN', 'stu_info si', 'si.stu_info_stu_master_id = fpt.fees_pay_tran_stu_id')
		    ->where(['fpt.is_status' => '0'])
		    ->orderBy('fees_pay_tran_id DESC')
		    ->limit(10)
		    ->all();


        return $this->render('index', ['feeRecent'=>$feeRecent, 
					'courseWiseCollect'=>$courseWiseCollect,
					'paidUnpaidData'=>$paidUnpaidData,
					'fccWisePaidUnPaid'=>$fccWisePaidUnPaid,
					'fcCategory'=>$fcCategory
				      ]
			    );
    }
}
