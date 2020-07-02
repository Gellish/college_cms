<?php




namespace app\models;

use Yii;
use app\models\User;
/**
 * This is the model class for table "nationality".
 *
 * @property integer $nationality_id
 * @property string $nationality_name
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_status
 *
 * @property EmpMaster[] $empMasters
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property StuAdmissionMaster[] $stuAdmissionMasters
 * @property StuMaster[] $stuMasters
 */
class Nationality extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nationality';
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
            [['nationality_name', 'created_at', 'created_by'], 'required','message'=>''],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'is_status'], 'integer'],
            [['nationality_name'], 'string', 'max' => 35],
            [['nationality_name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nationality_id' => Yii::t('app', 'Nationality ID'),
            'nationality_name' => Yii::t('app', 'Nationality Name'),
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
    public function getEmpMasters()
    {
        return $this->hasMany(EmpMaster::className(), ['emp_master_nationality_id' => 'nationality_id']);
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
        return $this->hasMany(StuAdmissionMaster::className(), ['stu_master_nationality_id' => 'nationality_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuMasters()
    {
        return $this->hasMany(StuMaster::className(), ['stu_master_nationality_id' => 'nationality_id']);
    }
		
	/**
     * @return all nationality data into array for dropdown
     */
    public static function getNationality()
    {
    	$dataTmp = self::find()->where(['is_status' => 0])->orderBy('nationality_name')->all();
		$result = yii\helpers\ArrayHelper::map($dataTmp, 'nationality_id', 'nationality_name');
		return $result;
    }
}
