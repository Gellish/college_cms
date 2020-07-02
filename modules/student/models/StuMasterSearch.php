<?php



namespace app\modules\student\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\student\models\StuMaster;

class StuMasterSearch extends StuMaster
{
    public $stu_unique_id, $stu_first_name, $stu_last_name , $user_login_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stu_master_id', 'stu_master_stu_info_id', 'stu_master_user_id', 'stu_master_nationality_id', 'stu_master_category_id', 'stu_master_course_id', 'stu_master_batch_id', 'stu_master_section_id', 'stu_master_stu_status_id', 'stu_master_stu_address_id', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['created_at', 'updated_at','stu_first_name', 'stu_last_name', 'stu_unique_id', 'user_login_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = StuMaster::find()->where(['is_status' => 0]);
	$query->joinWith(['stuMasterStuInfo', 'stuMasterUser']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
	    'sort'=> ['defaultOrder' => ['stu_master_id'=>SORT_DESC]]
        ]);

	$dataProvider->sort->attributes['stu_first_name'] = [
        'asc' => ['stu_info.stu_first_name' => SORT_ASC],
        'desc' => ['stu_info.stu_first_name' => SORT_DESC],
        ];
	$dataProvider->sort->attributes['stu_last_name'] = [
        'asc' => ['stu_info.stu_last_name' => SORT_ASC],
        'desc' => ['stu_info.stu_last_name' => SORT_DESC],
        ];
	$dataProvider->sort->attributes['stu_unique_id'] = [
        'asc' => ['stu_info.stu_unique_id' => SORT_ASC],
        'desc' => ['stu_info.stu_unique_id' => SORT_DESC],
        ];
	$dataProvider->sort->attributes['user_login_id'] = [
        'asc' => ['users.user_login_id' => SORT_ASC],
        'desc' => ['users.user_login_id' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'stu_master_id' => $this->stu_master_id,
            'stu_master_stu_info_id' => $this->stu_master_stu_info_id,
            'stu_master_user_id' => $this->stu_master_user_id,
            'stu_master_nationality_id' => $this->stu_master_nationality_id,
            'stu_master_category_id' => $this->stu_master_category_id,
            'stu_master_course_id' => $this->stu_master_course_id,
            'stu_master_batch_id' => $this->stu_master_batch_id,
            'stu_master_section_id' => $this->stu_master_section_id,
            'stu_master_stu_status_id' => $this->stu_master_stu_status_id,
            'stu_master_stu_address_id' => $this->stu_master_stu_address_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_status' => $this->is_status,
        ]);
	$query->andFilterWhere(['like', 'stu_info.stu_first_name', $this->stu_first_name])
	      ->andFilterWhere(['like', 'stu_info.stu_unique_id', $this->stu_unique_id])
	      ->andFilterWhere(['like', 'users.user_login_id', $this->user_login_id])
	      ->andFilterWhere(['like', 'stu_info.stu_last_name', $this->stu_last_name]);

	unset($_SESSION['exportData']);
	$_SESSION['exportData'] = $dataProvider;

        return $dataProvider;
    }

    public static function getExportData() 
    {
	$data = [
			'data'=>$_SESSION['exportData'],
			'fileName'=>'Student-Master-List', 
			'title'=>'Student Master Report',
			'exportFile'=>'@app/modules/student/views/stu-master/StuMasterExportPdfExcel',
		];

	return $data;
    }
}
