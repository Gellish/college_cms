<?php




namespace app\models;

use Yii;

/**
 * This is the model class for table "login_details".
 *
 * @property integer $login_detail_id
 * @property integer $login_user_id
 * @property integer $login_status
 * @property string $login_at
 * @property string $logout_at
 * @property string $user_ip_address
 *
 * @property Users $loginUser
 */
class LoginDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'login_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login_user_id', 'login_at', 'logout_at', 'user_ip_address'], 'required'],
            [['login_user_id', 'login_status'], 'integer'],
            [['login_at', 'logout_at'], 'safe', 'default' => NULL],
            [['user_ip_address'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'login_detail_id' => Yii::t('app', 'Login Detail ID'),
            'login_user_id' => Yii::t('app', 'Username'),
            'login_status' => Yii::t('app', 'Status'),
            'login_at' => Yii::t('app', 'Login At'),
            'logout_at' => Yii::t('app', 'Logout At'),
            'user_ip_address' => Yii::t('app', 'IP Address'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoginUser()
    {
        return $this->hasOne(Users::className(), ['user_id' => 'login_user_id']);
    }
}
