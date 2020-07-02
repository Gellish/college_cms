<?php

namespace app\modules\course\models;

use Yii;
use app\models\User;

class Batches extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'batches';
    }

    public static function find()
    {
	return parent::find()->andWhere(['<>', 'is_status', 2]);
    }

   /* public static function defaultScope($query)
    {
        $query->andWhere(['is_status' => self::STATUS_OPEN]);
    }*/
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['batch_name', 'batch_course_id', 'batch_alias', 'start_date', 'end_date', 'created_at', 'created_by'], 'required', 'message' => ''],
            [['batch_course_id', 'created_by', 'updated_by', 'is_status'], 'integer', 'message' => ''],
            [['start_date', 'end_date', 'created_at', 'updated_at'], 'safe', 'message' => ''],
            [['batch_name'], 'string', 'max' => 120],
            [['batch_alias'], 'string', 'max' => 35],
            [['batch_name', 'batch_course_id'], 'unique', 'targetAttribute' => ['batch_name', 'batch_course_id'], 'message' => yii::t('course', 'Batch Already Exists for this Course.'), 'when' => function ($model){ return $model->is_status == 0;}],
            [['batch_alias'], 'unique', 'targetAttribute' => ['batch_alias'],]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'batch_id' => Yii::t('course', 'Batch ID'),
            'batch_name' => Yii::t('course', 'Batch Name'),
            'batch_course_id' => Yii::t('course', 'Batch Course'),
            'batch_alias' => Yii::t('course', 'Batch Alias'),
            'start_date' => Yii::t('course', 'Start Date'),
            'end_date' => Yii::t('course', 'End Date'),
            'created_at' => Yii::t('course', 'Created At'),
            'created_by' => Yii::t('course', 'Created By'),
            'updated_at' => Yii::t('course', 'Updated At'),
            'updated_by' => Yii::t('course', 'Updated By'),
            'is_status' => Yii::t('course', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBatchSubjectAllots()
    {
        return $this->hasMany(BatchSubjectAllot::className(), ['batch_sub_allot_batch_id' => 'batch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBatchCourse()
    {
        return $this->hasOne(Courses::className(), ['course_id' => 'batch_course_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSections()
    {
        return $this->hasMany(Section::className(), ['section_batch_id' => 'batch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuMasters()
    {
        return $this->hasMany(StuMaster::className(), ['stu_master_batch_id' => 'batch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjectAllocates()
    {
        return $this->hasMany(SubjectAllocate::className(), ['sub_allocate_batch_id' => 'batch_id']);
    }

    public function getCheckUniq()
    {
	return $this->is_status = 0;
    }

	/**
	* @return all batches
	*/
	public static function getStuBatches()
	{
		$dataTmp = Batches::find()->where(['is_status' => 0])->orderBy('batch_name')->all();
		$result = yii\helpers\ArrayHelper::map($dataTmp, 'batch_id', 'batch_name');
		return $result;
	}
}
