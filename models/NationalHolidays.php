<?php




namespace app\models;

use Yii;
use app\models\User;
/**
 * This is the model class for table "national_holidays".
 *
 * @property integer $national_holiday_id
 * @property string $national_holiday_name
 * @property string $national_holiday_date
 * @property string $national_holiday_remarks
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_status
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class NationalHolidays extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'national_holidays';
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
            [['national_holiday_name', 'national_holiday_date', 'created_at', 'created_by'], 'required','message'=>''],
            [['national_holiday_date', 'created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'is_status'], 'integer'],
            [['national_holiday_name'], 'string', 'max' => 50],
            [['national_holiday_remarks'], 'string', 'max' => 100],
            [['national_holiday_name', 'national_holiday_date'], 'unique', 'targetAttribute' => ['national_holiday_name', 'national_holiday_date'], 'message' => Yii::t('app', 'The combination of National Holiday Name and National Holiday Date has already been taken.')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'national_holiday_id' => Yii::t('app', 'National Holiday ID'),
            'national_holiday_name' => Yii::t('app', 'Name'),
            'national_holiday_date' => Yii::t('app', 'Date'),
            'national_holiday_remarks' => Yii::t('app', 'Remarks'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'is_status' => Yii::t('app', 'Is Status'),
        ];
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
