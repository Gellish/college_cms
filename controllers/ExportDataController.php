<?php



namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

class ExportDataController extends Controller
{
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
					'actions' => [
				],
			],
		];
	}

	public function actionExportToPdf($model)
	{
		$data = $model::getExportData();
		//print_r($data); exit;
		$type = 'Pdf';

		$html = $this->renderPartial($data['exportFile'], 
				['model'=>$data['data'],'type' => $type,
			]);

		return Yii::$app->pdf->exportData($data['title'], $data['fileName'],$html);

	}

	public function actionExportExcel($model) 
	{
		$data = $model::getExportData();
		$type = 'Excel';

		$file = $this->renderPartial($data['exportFile'], 
				['model'=>$data['data'],
				 'type'=>$type,
			]);
		$fileName = $data['fileName'].'.xls';
		$options = ['mimeType'=>'application/vnd.ms-excel'];

		return Yii::$app->excel->exportExcel($file, $fileName, $options);
	
	}

}
?>
