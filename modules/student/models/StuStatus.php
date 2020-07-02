<?php



namespace app\modules\student\models;

use Yii;
use app\models\User;
/**
 * This is the model class for table "stu_status".
 *
 * @property integer $stu_status_id
 * @property string $stu_status_name
 * @property string $stu_status_description
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_status
 *
 * @property StuMaster[] $stuMasters
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class StuStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stu_status';
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
            [['stu_status_name', 'stu_status_description', 'created_at', 'created_by'], 'required', 'message' => ''],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'is_status'], 'integer'],
            [['stu_status_name'], 'string', 'max' => 50],
            [['stu_status_description'], 'string', 'max' => 100],
            [['stu_status_name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'stu_status_id' => Yii::t('stu', 'Stu Status ID'),
            'stu_status_name' => Yii::t('stu', 'Name'),
            'stu_status_description' => Yii::t('stu', 'Description'),
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
    public function getStuMasters()
    {
        return $this->hasMany(StuMaster::className(), ['stu_master_stu_status_id' => 'stu_status_id']);
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
}
