<?php





namespace app\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property integer $city_id
 * @property string $city_name
 * @property integer $city_state_id
 * @property integer $city_country_id
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_status
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property State $cityState
 * @property Country $cityCountry
 * @property EmpAddress[] $empAddresses
 * @property StuAddress[] $stuAddresses
 * @property StuAdmissionMaster[] $stuAdmissionMasters
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
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
            [['city_name', 'city_state_id', 'city_country_id', 'created_at', 'created_by'], 'required', 'message' => ''],
            [['city_state_id', 'city_country_id', 'created_by', 'updated_by', 'is_status'], 'integer', 'message' => ''],
            [['created_at', 'updated_at'], 'safe'],
            [['city_name'], 'string', 'max' => 35],
            [['city_name', 'city_state_id'], 'unique', 'targetAttribute' => ['city_name', 'city_state_id'], 'message' => Yii::t('app', 'The combination of City Name and State has already been taken.')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'city_id' => Yii::t('app', 'City ID'),
            'city_name' => Yii::t('app', 'City/Town'),
            'city_state_id' => Yii::t('app', 'State/Province'),
            'city_country_id' => Yii::t('app', 'Country'),
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
    public function getCityState()
    {
        return $this->hasOne(State::className(), ['state_id' => 'city_state_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityCountry()
    {
        return $this->hasOne(Country::className(), ['country_id' => 'city_country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpAddresses()
    {
        return $this->hasMany(EmpAddress::className(), ['emp_padd_city' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuAddresses()
    {
        return $this->hasMany(StuAddress::className(), ['stu_padd_city' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuAdmissionMasters()
    {
        return $this->hasMany(StuAdmissionMaster::className(), ['stu_padd_city' => 'city_id']);
    }

	/**
	* @return get all city
	*/ 
	public static function getAllCity()
    {
    	$dataTmp = self::find()->where(['is_status' => 0])->orderBy('city_name')->all();
		$result = yii\helpers\ArrayHelper::map($dataTmp, 'city_id', 'city_name');
		return $result;
    }
}
