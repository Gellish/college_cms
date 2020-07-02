<?php



namespace app\modules\employee\models;

use Yii;
use app\models\DocumentCategory;
use app\models\User;
/**
 * This is the model class for table "emp_docs".
 *
 * @property integer $emp_docs_id
 * @property string $emp_docs_details
 * @property integer $emp_docs_category_id
 * @property string $emp_docs_path
 * @property string $emp_docs_submited_at
 * @property integer $emp_docs_status
 * @property integer $emp_docs_emp_master_id
 * @property integer $created_by
 *
 * @property Users $createdBy
 * @property EmpMaster $empDocsEmpMaster
 */
class EmpDocs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $emp_docs_category_id_temp;
    public static function tableName()
    {
        return 'emp_docs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_docs_category_id','emp_docs_submited_at', 'emp_docs_emp_master_id', 'created_by'], 'required','message'=>''],
            [['emp_docs_category_id', 'emp_docs_status', 'emp_docs_emp_master_id', 'created_by'], 'integer'],
            [['emp_docs_submited_at','emp_docs_path','emp_docs_category_id_temp'], 'safe'],
            [['emp_docs_details','emp_docs_category_id_temp'], 'string', 'max' => 100],
            [['emp_docs_path'],'file', 'extensions' => 'jpg, png, pdf, txt, jpeg, doc, docx']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'emp_docs_id' => Yii::t('emp', 'Document'),
            'emp_docs_details' => Yii::t('emp', 'Document Details'),
            'emp_docs_category_id' => Yii::t('emp', 'Category'),
            'emp_docs_path' => Yii::t('emp', 'Document'),
            'emp_docs_submited_at' => Yii::t('emp', 'Submited Date'),
            'emp_docs_status' => Yii::t('emp', 'Status'),
            'emp_docs_emp_master_id' => Yii::t('emp', 'Employee'),
            'created_by' => Yii::t('emp', 'Created By'),
	   		'emp_docs_category_id_temp' => Yii::t('emp', 'Category'),	
			
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
    public function getEmpDocsEmpMaster()
    {
        return $this->hasOne(EmpMaster::className(), ['emp_master_id' => 'emp_docs_emp_master_id']);
    }

	/**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpDocsCategory()
    {
        return $this->hasOne(DocumentCategory::className(), ['doc_category_id' => 'emp_docs_category_id']);
    }
	
}
