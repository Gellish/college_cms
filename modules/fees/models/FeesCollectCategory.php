<?php




namespace app\modules\fees\models;

use Yii;
use app\modules\course\models\Batches;
use app\models\User;
/**
 * This is the model class for table "fees_collect_category".
 *
 * @property integer $fees_collect_category_id
 * @property string $fees_collect_name
 * @property integer $fees_collect_batch_id
 * @property string $fees_collect_details
 * @property string $fees_collect_start_date
 * @property string $fees_collect_end_date
 * @property string $fees_collect_due_date
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_status
 *
 * @property FeesCategoryDetails[] $feesCategoryDetails
 * @property Users $updatedBy
 * @property Users $createdBy
 */
class FeesCollectCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fees_collect_category';
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
            [['fees_collect_name', 'fees_collect_batch_id', 'fees_collect_start_date', 'fees_collect_end_date', 'fees_collect_due_date', 'created_at', 'created_by'], 'required', 'message' => ''],
            [['fees_collect_batch_id', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['fees_collect_start_date', 'fees_collect_end_date', 'fees_collect_due_date', 'created_at', 'updated_at'], 'safe'],
	    [['fees_collect_batch_id'], 'integer',],
            [['fees_collect_name'], 'string', 'max' => 70],
            [['fees_collect_details'], 'string', 'max' => 255],
            [['fees_collect_name', 'fees_collect_batch_id'], 'unique', 'targetAttribute' => ['fees_collect_name', 'fees_collect_batch_id'], 'message' => Yii::t('fees', 'The combination of Fees Category and Batch has already been taken.')],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'fees_collect_category_id' => Yii::t('fees', 'Fees Collect Category'),
            'fees_collect_name' => Yii::t('fees', 'Name'),
            'fees_collect_batch_id' => Yii::t('fees', 'Batch'),
            'fees_collect_details' => Yii::t('fees', 'Description'),
            'fees_collect_start_date' => Yii::t('fees', 'Start Date'),
            'fees_collect_end_date' => Yii::t('fees', 'End Date'),
            'fees_collect_due_date' => Yii::t('fees', 'Due Date'),
            'created_at' => Yii::t('fees', 'Created At'),
            'created_by' => Yii::t('fees', 'Created By'),
            'updated_at' => Yii::t('fees', 'Updated At'),
            'updated_by' => Yii::t('fees', 'Updated By'),
            'is_status' => Yii::t('fees', 'Status'),
        ];
    }

    public static function getBatchFeesCategory($bid)
    {
	$batchFcc = self::find()->andWhere(['is_status'=>0, 'fees_collect_batch_id'=>$bid]);
	return $batchFcc;
    }
    
    public function getFeesCategoryDetails()
    {
        return $this->hasMany(FeesCategoryDetails::className(), ['fees_details_category_id' => 'fees_collect_category_id']);
    }

    public function getFeesCollectBatch()
    {
        return $this->hasOne(Batches::className(), ['batch_id' => 'fees_collect_batch_id']);
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'updated_by']);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'created_by']);
    }
}
