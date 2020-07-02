<?php


namespace app\modules\employee\models;

use Yii;
use app\models\City;
use app\models\State;
use app\models\Country;

/**
 * This is the model class for table "emp_address".
 *
 * @property integer $emp_address_id
 * @property string $emp_cadd
 * @property integer $emp_cadd_city
 * @property integer $emp_cadd_state
 * @property integer $emp_cadd_country
 * @property integer $emp_cadd_pincode
 * @property string $emp_cadd_house_no
 * @property string $emp_cadd_phone_no
 * @property string $emp_padd
 * @property integer $emp_padd_city
 * @property integer $emp_padd_state
 * @property integer $emp_padd_country
 * @property integer $emp_padd_pincode
 * @property string $emp_padd_house_no
 * @property string $emp_padd_phone_no
 *
 * @property Country $empPaddCountry
 * @property City $empCaddCity
 * @property State $empCaddState
 * @property Country $empCaddCountry
 * @property City $empPaddCity
 * @property State $empPaddState
 * @property EmpMaster[] $empMasters
 */
class EmpAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'emp_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
	    [['emp_cadd_city', 'emp_cadd_state', 'emp_cadd_country', 'emp_cadd_pincode', 'emp_padd_city', 'emp_padd_state', 'emp_padd_country', 'emp_padd_pincode','emp_cadd', 'emp_padd','emp_cadd_house_no', 'emp_cadd_phone_no', 'emp_padd_house_no', 'emp_padd_phone_no'],'safe'],	
            [['emp_cadd_city', 'emp_cadd_state', 'emp_cadd_country', 'emp_cadd_pincode', 'emp_padd_city', 'emp_padd_state', 'emp_padd_country', 'emp_padd_pincode'], 'integer'],
            [['emp_cadd', 'emp_padd'], 'string', 'max' => 255],
            [['emp_cadd_house_no', 'emp_cadd_phone_no', 'emp_padd_house_no', 'emp_padd_phone_no'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'emp_address_id' => Yii::t('emp', 'Address'),
            'emp_cadd' => Yii::t('emp', 'Address'),
            'emp_cadd_city' => Yii::t('emp', 'City/Town'),
            'emp_cadd_state' => Yii::t('emp', 'State/Province'),
            'emp_cadd_country' => Yii::t('emp', 'Country'),
            'emp_cadd_pincode' => Yii::t('emp', 'Pincode'),
            'emp_cadd_house_no' => Yii::t('emp', 'House No'),
            'emp_cadd_phone_no' => Yii::t('emp', 'Phone No'),
            'emp_padd' => Yii::t('emp', 'Address'),
            'emp_padd_city' => Yii::t('emp', 'City/Town'),
            'emp_padd_state' => Yii::t('emp', 'State/Province'),
            'emp_padd_country' => Yii::t('emp', 'Country'),
            'emp_padd_pincode' => Yii::t('emp', 'Pincode'),
            'emp_padd_house_no' => Yii::t('emp', 'House No'),
            'emp_padd_phone_no' => Yii::t('emp', 'Phone No'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpPaddCountry()
    {
        return $this->hasOne(Country::className(), ['country_id' => 'emp_padd_country']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpCaddCity()
    {
        return $this->hasOne(City::className(), ['city_id' => 'emp_cadd_city']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpCaddState()
    {
        return $this->hasOne(State::className(), ['state_id' => 'emp_cadd_state']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpCaddCountry()
    {
        return $this->hasOne(Country::className(), ['country_id' => 'emp_cadd_country']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpPaddCity()
    {
        return $this->hasOne(City::className(), ['city_id' => 'emp_padd_city']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpPaddState()
    {
        return $this->hasOne(State::className(), ['state_id' => 'emp_padd_state']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpMasters()
    {
        return $this->hasMany(EmpMaster::className(), ['emp_master_emp_address_id' => 'emp_address_id']);
    }
}
