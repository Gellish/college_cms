<?php



namespace app\modules\employee\models;

use Yii;
use app\models\User;
/**
 * This is the model class for table "emp_department".
 *
 * @property integer $emp_department_id
 * @property string $emp_department_name
 * @property string $emp_department_alias
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_status
 *
 * @property Users $updatedBy
 * @property Users $createdBy
 * @property EmpMaster[] $empMasters
 */
class EmpDepartment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'emp_department';
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
            [['emp_department_name', 'emp_department_alias', 'created_at', 'created_by'], 'required','message'=>''],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'is_status'], 'integer'],
            [['emp_department_name'], 'string', 'max' => 65],
            [['emp_department_alias'], 'string', 'max' => 10],
            [['emp_department_name'], 'unique'],
            [['emp_department_alias'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
  			'emp_department_id' => Yii::t('emp', 'Department ID'),
            'emp_department_name' => Yii::t('emp', 'Department Name'),
            'emp_department_alias' => Yii::t('emp', 'Department Alias'),
            'created_at' => Yii::t('emp', 'Created At'),
            'created_by' => Yii::t('emp', 'Created By'),
            'updated_at' => Yii::t('emp', 'Updated At'),
            'updated_by' => Yii::t('emp', 'Updated By'),
            'is_status' => Yii::t('emp', 'Is Status'),
        ];
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
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpMasters()
    {
        return $this->hasMany(EmpMaster::className(), ['emp_master_department_id' => 'emp_department_id']);
    }
}
