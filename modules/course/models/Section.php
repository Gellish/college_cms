<?php




namespace app\modules\course\models;

use Yii;
use app\models\User;
/**
 * This is the model class for table "section".
 *
 * @property integer $section_id
 * @property string $section_name
 * @property integer $section_batch_id
 * @property integer $intake
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_status
 *
 * @property Batches $sectionBatch
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property StuMaster[] $stuMasters
 */
class Section extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'section';
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
            [['section_name', 'section_batch_id', 'created_at', 'created_by'], 'required', 'message' => ''],
            [['section_batch_id', 'intake', 'created_by', 'updated_by', 'is_status'], 'integer', 'message' => ''],
            [['created_at', 'updated_at'], 'safe', 'message' => ''],
            [['section_name'], 'string', 'max' => 50],
            [['section_name', 'section_batch_id'], 'unique', 'targetAttribute' => ['section_name', 'section_batch_id'], 'message' => Yii::t('course', 'Section Already Exists of this Batch.')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'section_id' => Yii::t('course', 'Section ID'),
            'section_name' => Yii::t('course', 'Section Name'),
            'section_batch_id' => Yii::t('course', 'Section Batch'),
            'intake' => Yii::t('course', 'Intake'),
            'created_at' => Yii::t('course', 'Created At'),
            'created_by' => Yii::t('course', 'Created By'),
            'updated_at' => Yii::t('course', 'Updated At'),
            'updated_by' => Yii::t('course', 'Updated By'),
            'is_status' => Yii::t('course', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectionBatch()
    {
        return $this->hasOne(Batches::className(), ['batch_id' => 'section_batch_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuMasters()
    {
        return $this->hasMany(StuMaster::className(), ['stu_master_section_id' => 'section_id']);
    }

	/**
	* @return all Section
	*/
	public static function getStuSection()
	{
		$dataTmp = Section::find()->where(['is_status' => 0])->orderBy('section_name')->all();
		$result = yii\helpers\ArrayHelper::map($dataTmp, 'section_id', 'section_name');
		return $result;
	}
}
