<?php



namespace app\modules\student\models;

use Yii;

/**
 * This is the model class for table "stu_guardians".
 *
 * @property integer $stu_guardian_id
 * @property string $guardian_name
 * @property string $guardian_relation
 * @property string $guardian_mobile_no
 * @property string $guardian_phone_no
 * @property string $guardian_qualification
 * @property string $guardian_occupation
 * @property string $guardian_income
 * @property string $guardian_email
 * @property string $guardian_home_address
 * @property string $guardian_office_address
 * @property integer $guardia_stu_master_id
 *
 * @property StuMaster $guardiaStuMaster
 */
class StuGuardians extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stu_guardians';
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
            [['guardian_mobile_no', 'guardia_stu_master_id', 'created_by', 'is_emg_contact', 'updated_by', 'is_status'], 'integer'],
            [['guardia_stu_master_id', 'created_at', 'created_by', 'is_emg_contact'], 'required'],
            [['guardian_name', 'guardian_email'], 'string', 'max' => 65],
            [['guardian_relation'], 'string', 'max' => 30],
            [['guardian_phone_no'], 'string', 'max' => 25],
	    [['created_at', 'updated_at'], 'safe'],
            [['guardian_qualification', 'guardian_occupation', 'guardian_income'], 'string', 'max' => 50],
            [['guardian_home_address', 'guardian_office_address'], 'string', 'max' => 255],
            [['guardian_email'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'stu_guardian_id' => Yii::t('stu', 'Stu Guardian ID'),
            'guardian_name' => Yii::t('stu', 'Name'),
            'guardian_relation' => Yii::t('stu', 'Relation'),
            'guardian_mobile_no' => Yii::t('stu', 'Mobile No'),
            'guardian_phone_no' => Yii::t('stu', 'Phone No'),
            'guardian_qualification' => Yii::t('stu', 'Qualification'),
            'guardian_occupation' => Yii::t('stu', 'Occupation'),
            'guardian_income' => Yii::t('stu', 'Income'),
            'guardian_email' => Yii::t('stu', 'Email'),
            'guardian_home_address' => Yii::t('stu', 'Home Address'),
            'guardian_office_address' => Yii::t('stu', 'Office Address'),
            'is_emg_contact' => Yii::t('stu', 'Is Emg Contact'),
            'guardia_stu_master_id' => Yii::t('stu', 'Guardia Stu Master ID'),
            'created_at' => Yii::t('stu', 'Created At'),
            'created_by' => Yii::t('stu', 'Created By'),
            'updated_at' => Yii::t('stu', 'Updated At'),
            'updated_by' => Yii::t('stu', 'Updated By'),
            'is_status' => Yii::t('stu', 'Is Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuardiaStuMaster()
    {
        return $this->hasOne(StuMaster::className(), ['stu_master_id' => 'guardia_stu_master_id']);
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_id' => 'created_by']);
    }
}
