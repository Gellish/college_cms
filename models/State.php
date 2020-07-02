<?php





namespace app\models;

use Yii;
use app\models\User;

/**
 * This is the model class for table "state".
 *
 * @property integer $state_id
 * @property string $state_name
 * @property integer $state_country_id
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_status
 *
 * @property City[] $cities
 * @property EmpAddress[] $empAddresses
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property Country $stateCountry
 * @property StuAddress[] $stuAddresses
 * @property StuAdmissionMaster[] $stuAdmissionMasters
 */
class State extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'state';
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
            [['state_name', 'state_country_id', 'created_at', 'created_by'], 'required', 'message' => ''],
            [['state_country_id', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['state_name'], 'string', 'max' => 35],
            [['state_name', 'state_country_id'], 'unique', 'targetAttribute' => ['state_name', 'state_country_id'], 'message' => Yii::t('app', 'The combination of State Name and Country has already been taken.')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'state_id' => Yii::t('app', 'State ID'),
            'state_name' => Yii::t('app', 'State/Province'),
            'state_country_id' => Yii::t('app', 'Country'),
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
        return $this->hasMany(City::className(), ['city_state_id' => 'state_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpAddresses()
    {
        return $this->hasMany(EmpAddress::className(), ['emp_padd_state' => 'state_id']);
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
    public function getStateCountry()
    {
        return $this->hasOne(Country::className(), ['country_id' => 'state_country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuAddresses()
    {
        return $this->hasMany(StuAddress::className(), ['stu_padd_state' => 'state_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuAdmissionMasters()
    {
        return $this->hasMany(StuAdmissionMaster::className(), ['stu_padd_state' => 'state_id']);
    }

	/**
	* @return get all state
	*/ 
	public static function getAllState()
    {
    	$dataTmp = self::find()->where(['is_status' => 0])->orderBy('state_name')->all();
		$result = yii\helpers\ArrayHelper::map($dataTmp, 'state_id', 'state_name');
		return $result;
    }
}
