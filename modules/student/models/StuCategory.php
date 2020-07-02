<?php




namespace app\modules\student\models;

use Yii;
use app\models\User;
/**
 * This is the model class for table "stu_category".
 *
 * @property integer $stu_category_id
 * @property string $stu_category_name
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_status
 *
 * @property StuAdmissionMaster[] $stuAdmissionMasters
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property StuMaster[] $stuMasters
 */
class StuCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stu_category';
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
            [['stu_category_name', 'created_at', 'created_by'], 'required', 'message' => ''],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'is_status'], 'integer'],
            [['stu_category_name'], 'string', 'max' => 50],
	    [['stu_category_name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'stu_category_id' => Yii::t('app', 'Stu Category ID'),
            'stu_category_name' => Yii::t('app', 'Category'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'is_status' => Yii::t('app', 'Is Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuAdmissionMasters()
    {
        return $this->hasMany(StuAdmissionMaster::className(), ['stu_master_category' => 'stu_category_id']);
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
        return $this->hasMany(StuMaster::className(), ['stu_master_category_id' => 'stu_category_id']);
    }

	/**
	* @return student category
	*/
	public function getStuCategoryId()
	{	
		$dataTmp = StuCategory::find()->where(['is_status' => 0])->orderBy('stu_category_name')->all();
		$result = yii\helpers\ArrayHelper::map($dataTmp, 'stu_category_id', 'stu_category_name');
		return $result;
	}
}
