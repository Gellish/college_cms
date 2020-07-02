<?php




namespace app\modules\course\controllers;

use yii\web\Controller;
use Yii;

class DefaultController extends Controller
{
    public function actionIndex()
    {
	if(Yii::$app->session->get('stu_id') || Yii::$app->session->get('emp_id'))
		return $this->redirect(['/course/courses/index']);

	$actCourseData = \app\modules\course\models\Courses::find()->where(['is_status'=>0])->all();
        return $this->render('index', ['actCourseData'=>$actCourseData]);
    }
}
