<?php


namespace app\modules\dashboard\models;

use Yii;
use app\models\User;
/**
 * This is the model class for table "msg_of_day".
 *
 * @property integer $msg_of_day_id
 * @property string $msg_details
 * @property string $msg_user_type
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_status
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class MsgOfDay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msg_of_day';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['msg_details', 'created_at', 'created_by'], 'required', 'message' => ''],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'is_status'], 'integer'],
            [['msg_details'], 'string', 'max' => 100],
            [['msg_user_type'], 'string', 'max' => 3],
            [['msg_details'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'msg_of_day_id' => Yii::t('dash', 'Msg Of Day ID'),
            'msg_details' => Yii::t('dash', 'Details'),
            'msg_user_type' => Yii::t('dash', 'User Type'),
            'created_at' => Yii::t('dash', 'Created At'),
            'created_by' => Yii::t('dash', 'Created By'),
            'updated_at' => Yii::t('dash', 'Updated At'),
            'updated_by' => Yii::t('dash', 'Updated By'),
            'is_status' => Yii::t('dash', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'updated_by']);
    }
}
