<?php




namespace app\modules\fees\models;

use Yii;
use app\models\User;
/**
 * This is the model class for table "fees_category_details".
 *
 * @property integer $fees_category_details_id
 * @property string $fees_details_name
 * @property integer $fees_details_category_id
 * @property string $fees_details_description
 * @property string $fees_details_amount
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_status
 *
 * @property Users $updatedBy
 * @property FeesCollectCategory $feesDetailsCategory
 * @property Users $createdBy
 */
class FeesCategoryDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fees_category_details';
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
            [['fees_details_name', 'fees_details_category_id', 'fees_details_amount', 'created_at', 'created_by'], 'required', 'message' => ''],
            [['fees_details_category_id', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['fees_details_amount'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['fees_details_name'], 'string', 'max' => 70],
            [['fees_details_description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'fees_category_details_id' => Yii::t('fees', 'Fees Category Details ID'),
            'fees_details_name' => Yii::t('fees', 'Name'),
            'fees_details_category_id' => Yii::t('fees', 'Fees Category'),
            'fees_details_description' => Yii::t('fees', 'Description'),
            'fees_details_amount' => Yii::t('fees', 'Amount'),
            'created_at' => Yii::t('fees', 'Created At'),
            'created_by' => Yii::t('fees', 'Created By'),
            'updated_at' => Yii::t('fees', 'Updated At'),
            'updated_by' => Yii::t('fees', 'Updated By'),
            'is_status' => Yii::t('fees', 'Is Status'),
        ];
    }

    public static function getFeeCategoryTotal($cid)
    {
	$totalAmount = Yii::$app->db->createCommand("SELECT SUM(fees_details_amount) FROM fees_category_details WHERE fees_details_category_id=:cid AND is_status=:status")
        ->bindValues([
            ':cid' => $cid,
            ':status' => 0,
        ])
        ->queryScalar();
	return $totalAmount;
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
    public function getFeesDetailsCategory()
    {
        return $this->hasOne(FeesCollectCategory::className(), ['fees_collect_category_id' => 'fees_details_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'created_by']);
    }
}
