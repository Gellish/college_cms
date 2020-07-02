<?php




namespace app\modules\dashboard\models;

use Yii;
use app\models\User;
/**
 * This is the model class for table "notice".
 *
 * @property integer $notice_id
 * @property string $notice_title
 * @property string $notice_description
 * @property string $notice_user_type
 * @property string $notice_date
 * @property string $notice_file_path
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_status
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class Notice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notice';
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
            [['notice_title', 'notice_user_type', 'created_at', 'created_by'], 'required', 'message' => ''],
            [['notice_date', 'created_at', 'updated_at', 'notice_file_path'], 'safe'],
            [['created_by', 'updated_by', 'is_status'], 'integer'],
            [['notice_title'], 'string', 'max' => 25],
            [['notice_description'], 'string', 'max' => 255],
            [['notice_user_type'], 'string', 'max' => 3],
            [['notice_file_path'], 'file', 'extensions' => 'jpg, gif, png, pdf, txt, jpeg, doc, docx']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'notice_id' => Yii::t('dash', 'Notice ID'),
            'notice_title' => Yii::t('dash', 'Title'),
            'notice_description' => Yii::t('dash', 'Description'),
            'notice_user_type' => Yii::t('dash', 'User Type'),
            'notice_date' => Yii::t('dash', 'Date'),
            'notice_file_path' => Yii::t('dash', 'Notice File'),
            'created_at' => Yii::t('dash', 'Created At'),
            'created_by' => Yii::t('dash', 'Created By'),
            'updated_at' => Yii::t('dash', 'Updated At'),
            'updated_by' => Yii::t('dash', 'Updated By'),
            'is_status' => Yii::t('dash', 'Active'),
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
