<?php



namespace app\models;
use Yii;

/**
 * This is the model class for table "organization".
 *
 * @property integer $org_id
 * @property string $org_name
 * @property string $org_alias
 * @property string $org_address_line1
 * @property string $org_address_line2
 * @property string $org_phone
 * @property string $org_email
 * @property string $org_website
 * @property resource $org_logo
 * @property string $org_logo_type
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property Users $updatedBy
 * @property Users $createdBy
 */
class Organization extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'organization';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['org_name', 'org_alias', 'org_address_line1', 'org_logo_type', 'created_at', 'org_stu_prefix', 'org_emp_prefix'], 'required'],
	    [['org_logo'], 'required', 'on'=>'insert'],
	    [['org_logo'], 'file', 'extensions' => 'jpg, jpeg, gif, png', 'skipOnEmpty' => true, 
'checkExtensionByMimeType'=>false],
            [['org_logo'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['org_name', 'org_address_line1', 'org_address_line2'], 'string', 'max' => 255],
            [['org_alias', 'org_phone'], 'string', 'max' => 25],
            [['org_email'], 'string', 'max' => 65],
 	    [['org_stu_prefix', 'org_emp_prefix'], 'string', 'max' => 10],
            [['org_website'], 'string', 'max' => 120],
            [['org_logo_type'], 'string', 'max' => 35],
            [['org_name'], 'unique'],
            [['org_alias'], 'unique'],
	    [['org_email'], 'email'],
	    [['org_website'], 'url'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'org_id' => Yii::t('app', 'Institute ID'),
            'org_name' => Yii::t('app', 'Name'),
            'org_alias' => Yii::t('app', 'Alias'),
            'org_address_line1' => Yii::t('app', 'Address Line 1'),
            'org_address_line2' => Yii::t('app', 'Address Line 2'),
            'org_phone' => Yii::t('app', 'Phone'),
            'org_email' => Yii::t('app', 'Email'),
            'org_website' => Yii::t('app', 'Website'),
            'org_logo' => Yii::t('app', 'Logo'),
            'org_logo_type' => Yii::t('app', 'Logo Type'),
            'org_stu_prefix' => Yii::t('app', 'Student Login Prefix'),
            'org_emp_prefix' => Yii::t('app', 'Employee Login Prefix'),
            'created_at' => Yii::t('app', 'Created Time'),
            'created_by' => Yii::t('app', 'Created User'),
            'updated_at' => Yii::t('app', 'Updated Time'),
            'updated_by' => Yii::t('app', 'Updated User'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), ['user_id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), ['user_id' => 'created_by']);
    }
}
