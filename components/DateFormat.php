<?php


namespace app\components;

use Yii;
use yii\base\Component;

class DateFormat extends Component
{         
        public function getDateFormat($param)
        {
                $datef = (!empty($param) ? date('Y-m-d',strtotime($param)) : NULL);
                return $datef;
        }

	public function getDTFormat($param) // for event date
        {
                $datef = (!empty($param) ? date("d-m-Y H:i:s", $param) : NULL);
                return $datef;
        }

	public function getDateTimeFormat($param)
        {
                $datet = (!empty($param) ? Yii::$app->formatter->asDateTime($param) : NULL);
                return $datet;
        }

	public function storeDateTimeFormat($param)
        {
                $datet = (!empty($param) ? date('Y-m-d H:i:s',strtotime($param)) : NULL);
                return $datet;
        }

	public function getDateDisplay($param)
        {
                $datef = (!empty($param) ? Yii::$app->formatter->asDate($param) : NULL);
                return $datef;
        }
}
?>
