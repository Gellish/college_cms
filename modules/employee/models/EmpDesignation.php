<?php



namespace app\modules\employee\models;

use Yii;
use app\models\User;
/**
 * This is the model class for table "emp_designation".
 *
 * @property integer $emp_designation_id
 * @property string $emp_designation_name
 * @property string $emp_designation_alias
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
class EmpDesignation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'emp_designation';
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
            [['emp_designation_name', 'emp_designation_alias', 'created_at', 'created_by'], 'required','message'=>''],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'is_status'], 'integer'],
            [['emp_designation_name'], 'string', 'max' => 50],
            [['emp_designation_alias'], 'string', 'max' => 10],
            [['emp_designation_name'], 'unique'],
            [['emp_designation_alias'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'emp_designation_id' => Yii::t('emp', 'Designation ID'),
            'emp_designation_name' => Yii::t('emp', 'Designation Name'),
            'emp_designation_alias' => Yii::t('emp', 'Designation Alias'),
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
        return $this->hasMany(EmpMaster::className(), ['emp_master_designation_id' => 'emp_designation_id']);
    }
}
