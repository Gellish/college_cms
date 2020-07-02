<?php



namespace app\modules\fees\models;

use Yii;
use app\models\User;
/**
 * This is the model class for table "bank_master".
 *
 * @property integer $bank_master_id
 * @property string $bank_master_name
 * @property string $bank_alias
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_status
 *
 * @property Users $updatedBy
 * @property Users $createdBy
 * @property FeesPaymentTransaction[] $feesPaymentTransactions
 */
class BankMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bank_master';
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
            [['bank_master_name', 'bank_alias', 'created_at', 'created_by'], 'required','message'=>''],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'is_status'], 'integer'],
            [['bank_master_name'], 'string', 'max' => 255],
            [['bank_alias'], 'string', 'max' => 10],
            [['bank_master_name'], 'unique'],
            [['bank_alias'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'bank_master_id' => Yii::t('fees', 'Bank'),
            'bank_master_name' => Yii::t('fees', 'Bank Name'),
            'bank_alias' => Yii::t('fees', 'Bank Alias'),
            'created_at' => Yii::t('fees', 'Created At'),
            'created_by' => Yii::t('fees', 'Created By'),
            'updated_at' => Yii::t('fees', 'Updated At'),
            'updated_by' => Yii::t('fees', 'Updated By'),
            'is_status' => Yii::t('fees', 'Is Status'),
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
    public function getFeesPaymentTransactions()
    {
        return $this->hasMany(FeesPaymentTransaction::className(), ['fees_pay_tran_bank_id' => 'bank_master_id']);
    }
}
