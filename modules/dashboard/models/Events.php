<?php




namespace app\modules\dashboard\models;

use Yii;

/**
 * This is the model class for table "events".
 *
 * @property integer $event_id
 * @property string $event_title
 * @property string $event_detail
 * @property string $event_start_date
 * @property string $event_end_date
 * @property integer $event_type
 * @property string $event_url
 * @property integer $event_all_day
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_status
 */
class Events extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'events';
    }
  
    public static function find()
    {
	return parent::find()->andWhere(['<>', 'is_status', 2]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_title', 'event_detail', 'event_start_date', 'event_end_date', 'event_type', 'created_at', 'created_by'], 'required', 'message' => ''],
            [['event_start_date', 'event_end_date', 'created_at', 'updated_at'], 'safe'],
            [['event_type', 'event_all_day', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['event_title'], 'string', 'max' => 80],
            [['event_detail', 'event_url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'event_id' => Yii::t('dash', 'Event ID'),
            'event_title' => Yii::t('dash', 'Title'),
            'event_detail' => Yii::t('dash', 'Detail'),
            'event_start_date' => Yii::t('dash', 'Start Date'),
            'event_end_date' => Yii::t('dash', 'End Date'),
            'event_type' => Yii::t('dash', 'Event Type'),
            'event_url' => Yii::t('dash', 'Url'),
            'event_all_day' => Yii::t('dash', 'All Day'),
            'created_at' => Yii::t('dash', 'Created At'),
            'created_by' => Yii::t('dash', 'Created By'),
            'updated_at' => Yii::t('dash', 'Updated At'),
            'updated_by' => Yii::t('dash', 'Updated By'),
            'is_status' => Yii::t('dash', 'Is Status'),
        ];
    }
}
