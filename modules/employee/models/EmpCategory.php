<?php


namespace app\modules\employee\models;

use Yii;
use app\models\User;
/**
 * This is the model class for table "emp_category".
 *
 * @property integer $emp_category_id
 * @property string $emp_category_name
 * @property string $emp_category_alias
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
class EmpCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'emp_category';
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
            [['emp_category_name', 'emp_category_alias', 'created_at', 'created_by'], 'required','message'=>''],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'is_status'], 'integer'],
            [['emp_category_name'], 'string', 'max' => 50],
            [['emp_category_alias'], 'string', 'max' => 10],
            [['emp_category_name'], 'unique'],
            [['emp_category_alias'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'emp_category_id' => Yii::t('emp', 'Category ID'),
            'emp_category_name' => Yii::t('emp', 'Category Name'),
            'emp_category_alias' => Yii::t('emp', 'Category Alias'),
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
        return $this->hasMany(EmpMaster::className(), ['emp_master_category_id' => 'emp_category_id']);
    }
}
