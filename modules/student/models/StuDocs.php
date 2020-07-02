<?php






namespace app\modules\student\models;

use Yii;
use app\models\DocumentCategory;
/**
 * This is the model class for table "stu_docs".
 *
 * @property integer $stu_docs_id
 * @property string $stu_docs_details
 * @property integer $stu_docs_category_id
 * @property string $stu_docs_path
 * @property integer $stu_docs_submited_at
 * @property integer $stu_docs_status
 * @property integer $stu_docs_stu_master_id
 * @property integer $created_by
 *
 * @property StuMaster $stuDocsStuMaster
 * @property Users $createdBy
 */
class StuDocs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $stu_docs_category_id_temp;
    public static function tableName()
    {
        return 'stu_docs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stu_docs_category_id', 'stu_docs_stu_master_id', 'created_by'], 'required'],
            [['stu_docs_category_id', 'stu_docs_submited_at', 'stu_docs_status', 'stu_docs_stu_master_id', 'created_by'], 'integer'],
            [['stu_docs_details', 'stu_docs_category_id_temp'], 'string', 'max' => 100],
	    [['stu_docs_submited_at', 'stu_docs_path'], 'safe'],
            [['stu_docs_path'], 'file', 'extensions' => 'jpg, png, pdf, txt, jpeg, doc, docx',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'stu_docs_id' => Yii::t('stu', 'Stu Docs ID'),
            'stu_docs_details' => Yii::t('stu', 'Document Details'),
            'stu_docs_category_id' => Yii::t('stu', 'Category'),
            'stu_docs_path' => Yii::t('stu', 'Document'),
            'stu_docs_submited_at' => Yii::t('stu', 'Submited Date'),
            'stu_docs_status' => Yii::t('stu', 'Status'),
            'stu_docs_category_id_temp' => Yii::t('stu', 'Category'),
            'stu_docs_stu_master_id' => Yii::t('stu', 'Student'),
            'created_by' => Yii::t('stu', 'Created By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuDocsStuMaster()
    {
        return $this->hasOne(StuMaster::className(), ['stu_master_id' => 'stu_docs_stu_master_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuDocsCategory()
    {
        return $this->hasOne(DocumentCategory::className(), ['doc_category_id' => 'stu_docs_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'created_by']);
    }
    
}
