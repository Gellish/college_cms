<?php

namespace app\components;

use Yii;
use yii\base\Component;

class GetUserId extends Component
{         
        public function getId()
        {
                $id = ((Yii::$app->user->id) ? Yii::$app->user->id : 1);
                return $id;
        }
}
?>
