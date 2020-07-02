<?php



namespace app\modules\fees\controllers;
use yii\helpers\Html;
use yii\web\Controller;
use Yii;
class DependentController extends Controller
{

	//Get fees category based on batch selection in fees collection
	public function actionGetFeesCategory($id) 
	{
		$rows = \app\modules\fees\models\FeesCollectCategory::find()->where(['is_status'=>0, 'fees_collect_batch_id'=>$id])->all();	
		echo Html::tag('option', Html::encode(Yii::t('fees','Select Fees Collect Category')), ['value'=>'']); 
		foreach($rows as $row)
			echo Html::tag('option',Html::encode($row->fees_collect_name), ['value'=>$row->fees_collect_category_id]); 
    	}

}
