<?php






namespace app\models;

use Yii;

/**
 * This is the model class for table "document_category".
 *
 * @property integer $doc_category_id
 * @property string $doc_category_name
 * @property string $doc_category_user_type
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_active
 * @property integer $is_status
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class DocumentCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'document_category';
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
            [['doc_category_name', 'created_at', 'created_by', 'doc_category_user_type'], 'required', 'message' => ''],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'is_status'], 'integer'],
            [['doc_category_name'], 'string', 'max' => 50],
            [['doc_category_user_type'], 'string', 'max' => 2],
            [['doc_category_name', 'doc_category_user_type'], 'unique', 'targetAttribute' => ['doc_category_name', 'doc_category_user_type'], 'message' => Yii::t('app', 'The combination of Document Category and User Type has already been taken.')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'doc_category_id' => Yii::t('app', 'Doc Category ID'),
            'doc_category_name' => Yii::t('app', 'Category'),
            'doc_category_user_type' => Yii::t('app', 'User Type'),
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
