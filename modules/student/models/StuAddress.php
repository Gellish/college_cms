<?php




namespace app\modules\student\models;

use Yii;
use app\models\City;
use app\models\State;
use app\models\Country;
/**
 * This is the model class for table "stu_address".
 *
 * @property integer $stu_address_id
 * @property string $stu_cadd
 * @property integer $stu_cadd_city
 * @property integer $stu_cadd_state
 * @property integer $stu_cadd_country
 * @property integer $stu_cadd_pincode
 * @property string $stu_cadd_house_no
 * @property string $stu_cadd_phone_no
 * @property string $stu_padd
 * @property integer $stu_padd_city
 * @property integer $stu_padd_state
 * @property integer $stu_padd_country
 * @property integer $stu_padd_pincode
 * @property string $stu_padd_house_no
 * @property string $stu_padd_phone_no
 *
 * @property City $stuCaddCity
 * @property State $stuCaddState
 * @property Country $stuCaddCountry
 * @property City $stuPaddCity
 * @property State $stuPaddState
 * @property Country $stuPaddCountry
 * @property StuMaster[] $stuMasters
 */
class StuAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stu_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stu_cadd_city', 'stu_cadd_state', 'stu_cadd_country', 'stu_cadd_pincode', 'stu_padd_city', 'stu_padd_state', 'stu_padd_country', 'stu_padd_pincode'], 'integer'],
            [['stu_cadd', 'stu_padd'], 'string', 'max' => 255],
            [['stu_cadd_house_no', 'stu_cadd_phone_no', 'stu_padd_house_no', 'stu_padd_phone_no'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'stu_address_id' => Yii::t('stu', 'Stu Address ID'),
            'stu_cadd' => Yii::t('stu', 'Address'),
            'stu_cadd_city' => Yii::t('stu', 'City'),
            'stu_cadd_state' => Yii::t('stu', 'State'),
            'stu_cadd_country' => Yii::t('stu', 'Country'),
            'stu_cadd_pincode' => Yii::t('stu', 'Pincode'),
            'stu_cadd_house_no' => Yii::t('stu', 'House No'),
            'stu_cadd_phone_no' => Yii::t('stu', 'Phone No'),
            'stu_padd' => Yii::t('stu', 'Address'),
            'stu_padd_city' => Yii::t('stu', 'City'),
            'stu_padd_state' => Yii::t('stu', 'State'),
            'stu_padd_country' => Yii::t('stu', 'Country'),
            'stu_padd_pincode' => Yii::t('stu', 'Pincode'),
            'stu_padd_house_no' => Yii::t('stu', 'House No'),
            'stu_padd_phone_no' => Yii::t('stu', 'Phone No'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuCaddCity()
    {
        return $this->hasOne(City::className(), ['city_id' => 'stu_cadd_city']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuCaddState()
    {
        return $this->hasOne(State::className(), ['state_id' => 'stu_cadd_state']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuCaddCountry()
    {
        return $this->hasOne(Country::className(), ['country_id' => 'stu_cadd_country']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuPaddCity()
    {
        return $this->hasOne(City::className(), ['city_id' => 'stu_padd_city']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuPaddState()
    {
        return $this->hasOne(State::className(), ['state_id' => 'stu_padd_state']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuPaddCountry()
    {
        return $this->hasOne(Country::className(), ['country_id' => 'stu_padd_country']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuMasters()
    {
        return $this->hasOne(StuMaster::className(), ['stu_master_stu_address_id' => 'stu_address_id']);
    }
}
