<?php


namespace app\modules\employee\models;

use Yii;
use app\models\User;
/**
 * This is the model class for table "emp_status".
 *
 * @property integer $emp_status_id
 * @property string $emp_status_name
 * @property string $emp_status_description
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_status
 *
 * @property EmpMaster[] $empMasters
 * @property Users $updatedBy
 * @property Users $createdBy
 */
class EmpStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'emp_status';
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
            [['emp_status_name', 'created_at', 'created_by'], 'required','message'=>''],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'is_status'], 'integer'],
            [['emp_status_name'], 'string', 'max' => 50],
            [['emp_status_description'], 'string', 'max' => 100],
            [['emp_status_name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'emp_status_id' => Yii::t('emp', 'Status ID'),
            'emp_status_name' => Yii::t('emp', 'Status Name'),
            'emp_status_description' => Yii::t('emp', 'Status Description'),
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
    public function getEmpMasters()
    {
        return $this->hasMany(EmpMaster::className(), ['emp_master_status_id' => 'emp_status_id']);
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
}
