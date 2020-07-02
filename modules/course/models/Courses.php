<?php





namespace app\modules\course\models;

use Yii;
use app\models\User;
/**
 * This is the model class for table "courses".
 *
 * @property integer $course_id
 * @property string $course_name
 * @property string $course_code
 * @property string $course_alias
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_status
 *
 * @property Batches[] $batches
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property StuAdmissionMaster[] $stuAdmissionMasters
 * @property StuMaster[] $stuMasters
 */
class Courses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'courses';
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
            [['course_name', 'course_code', 'course_alias', 'created_at', 'created_by'], 'required', 'message' => ''],
            [['created_at', 'updated_at'], 'safe', 'message' => ''],
            [['created_by', 'updated_by', 'is_status'], 'integer', 'message' => ''],
            [['course_name'], 'string', 'max' => 100],
            [['course_code'], 'string', 'max' => 50],
            [['course_alias'], 'string', 'max' => 35],
            [['course_name', 'course_code'], 'unique', 'targetAttribute' => ['course_name', 'course_code'], 'message' => Yii::t('course', 'Course Already Exists with this Course code.')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'course_id' => Yii::t('course', 'Course ID'),
            'course_name' => Yii::t('course', 'Course Name'),
            'course_code' => Yii::t('course', 'Course Code'),
            'course_alias' => Yii::t('course', 'Course Alias'),
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
    public function getBatches()
    {
        return $this->hasMany(Batches::className(), ['batch_course_id' => 'course_id']);
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
    public function getStuAdmissionMasters()
    {
        return $this->hasMany(StuAdmissionMaster::className(), ['stu_master_course_id' => 'course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuMasters()
    {
        return $this->hasMany(StuMaster::className(), ['stu_master_course_id' => 'course_id']);
    }

	/**
	* @return all course
	*/
	public static function getStuCourse()
	{
		$dataTmp = Courses::find()->where(['is_status' => 0])->orderBy('course_name')->all();
		$result = yii\helpers\ArrayHelper::map($dataTmp, 'course_id', 'course_name');
		return $result;
	}
}
