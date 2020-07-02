<?php



namespace app\models;

use Yii;
use app\models\User;
/**
 * This is the model class for table "country".
 *
 * @property integer $country_id
 * @property string $country_name
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_status
 *
 * @property City[] $cities
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property EmpAddress[] $empAddresses
 * @property State[] $states
 * @property StuAddress[] $stuAddresses
 * @property StuAdmissionMaster[] $stuAdmissionMasters
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
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
            [['country_name', 'created_at', 'created_by'], 'required', 'message'=>''],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'is_status'], 'integer'],
            [['country_name'], 'string', 'max' => 35],
            [['country_name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'country_id' => Yii::t('app', 'Country ID'),
            'country_name' => Yii::t('app', 'Country Name'),
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
    public function getCities()
    {
        return $this->hasMany(City::className(), ['city_country_id' => 'country_id']);
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
    public function getEmpAddresses()
    {
        return $this->hasMany(EmpAddress::className(), ['emp_cadd_country' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStates()
    {
        return $this->hasMany(State::className(), ['state_country_id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuAddresses()
    {
        return $this->hasMany(StuAddress::className(), ['stu_padd_country' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuAdmissionMasters()
    {
        return $this->hasMany(StuAdmissionMaster::className(), ['stu_padd_country' => 'country_id']);
    }
	
	/**
	* @return get all Country
	*/ 
	public static function getAllCountry()
    {
    	$dataTmp = self::find()->where(['is_status' => 0])->orderBy('country_name')->all();
		$result = yii\helpers\ArrayHelper::map($dataTmp, 'country_id', 'country_name');
		return $result;
    }
}
