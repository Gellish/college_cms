<?php


namespace app\modules\employee\models;

use Yii;
use app\models\Nationality;
use app\models\User;
/**
 * This is the model class for table "emp_master".
 *
 * @property integer $emp_master_id
 * @property integer $emp_master_emp_info_id
 * @property integer $emp_master_user_id
 * @property integer $emp_master_department_id
 * @property integer $emp_master_designation_id
 * @property integer $emp_master_category_id
 * @property integer $emp_master_nationality_id
 * @property integer $emp_master_emp_address_id
 * @property integer $emp_master_status_id
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_status
 *
 * @property EmpDocs[] $empDocs
 * @property EmpInfo[] $empInfos
 * @property Users $updatedBy
 * @property EmpInfo $empMasterEmpInfo
 * @property Users $empMasterUser
 * @property EmpDepartment $empMasterDepartment
 * @property EmpDesignation $empMasterDesignation
 * @property EmpCategory $empMasterCategory
 * @property Nationality $empMasterNationality
 * @property EmpAddress $empMasterEmpAddress
 * @property EmpStatus $empMasterStatus
 * @property Users $createdBy
 * @property EmpSectionAllot[] $empSectionAllots
 * @property SubjectAllocate[] $subjectAllocates
 */
class EmpMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'emp_master';
    }


    public static function find()
    {
        return parent::find()->andWhere(['<>', 'emp_master.is_status', 2]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_master_emp_info_id','emp_master_department_id', 'emp_master_category_id','emp_master_emp_address_id'], 'required', 'message'=>''],
            [['emp_master_emp_info_id', 'emp_master_user_id', 'emp_master_department_id', 'emp_master_designation_id', 'emp_master_category_id', 'emp_master_nationality_id', 'emp_master_emp_address_id', 'emp_master_status_id', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['emp_master_emp_info_id'], 'unique'],
            [['emp_master_user_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'emp_master_id' => Yii::t('emp', 'Employee ID'),
            'emp_master_emp_info_id' => Yii::t('emp', 'Emp Master Emp Info ID'),
            'emp_master_user_id' => Yii::t('emp', 'User'),
            'emp_master_department_id' => Yii::t('emp', 'Department'),
            'emp_master_designation_id' => Yii::t('emp', 'Designation'),
            'emp_master_category_id' => Yii::t('emp', 'Category'),
            'emp_master_nationality_id' => Yii::t('emp', 'Nationality'),
            'emp_master_emp_address_id' => Yii::t('emp', 'Address'),
            'emp_master_status_id' => Yii::t('emp', 'Status'),
            'created_at' => Yii::t('emp', 'Created At'),
            'created_by' => Yii::t('emp', 'Created By'),
            'updated_at' => Yii::t('emp', 'Updated At'),
            'updated_by' => Yii::t('emp', 'Updated By'),
            'is_status' => Yii::t('emp', 'Active/InActive'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpDocs()
    {
        return $this->hasMany(EmpDocs::className(), ['emp_docs_emp_master_id' => 'emp_master_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpInfos()
    {
        return $this->hasMany(EmpInfo::className(), ['emp_info_emp_master_id' => 'emp_master_id']);
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
    public function getEmpMasterEmpInfo()
    {
        return $this->hasOne(EmpInfo::className(), ['emp_info_id' => 'emp_master_emp_info_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpMasterUser()
    {
        return $this->hasOne(\app\models\User::className(), ['user_id' => 'emp_master_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpMasterDepartment()
    {
        return $this->hasOne(EmpDepartment::className(), ['emp_department_id' => 'emp_master_department_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpMasterDesignation()
    {
        return $this->hasOne(EmpDesignation::className(), ['emp_designation_id' => 'emp_master_designation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpMasterCategory()
    {
        return $this->hasOne(EmpCategory::className(), ['emp_category_id' => 'emp_master_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpMasterNationality()
    {
        return $this->hasOne(Nationality::className(), ['nationality_id' => 'emp_master_nationality_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpMasterEmpAddress()
    {
        return $this->hasOne(EmpAddress::className(), ['emp_address_id' => 'emp_master_emp_address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpMasterStatus()
    {
        return $this->hasOne(EmpStatus::className(), ['emp_status_id' => 'emp_master_status_id']);
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
    public function getEmpSectionAllots()
    {
        return $this->hasMany(EmpSectionAllot::className(), ['emp_id' => 'emp_master_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjectAllocates()
    {
        return $this->hasMany(SubjectAllocate::className(), ['sub_allocate_emp_id' => 'emp_master_id']);
    }
}
