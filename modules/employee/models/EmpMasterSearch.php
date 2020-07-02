<?php



namespace app\modules\employee\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\employee\models\EmpMaster;

class EmpMasterSearch extends EmpMaster
{
    /**
     * @inheritdoc
     */
	public $emp_unique_id,$emp_first_name,$emp_middle_name,$emp_last_name,$user_login_id;

    public function rules()
    {
        return [
            [['emp_master_id', 'emp_master_emp_info_id', 'emp_master_user_id', 'emp_master_department_id', 'emp_master_designation_id', 'emp_master_category_id', 'emp_master_nationality_id', 'emp_master_emp_address_id', 'emp_master_status_id', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
	    [['emp_unique_id','emp_first_name','emp_middle_name','emp_last_name'],'safe'],	
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
        $query = EmpMaster::find()->where(['is_status' => 0]);
	$query->joinWith(['empMasterEmpInfo','empMasterUser']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'sort' => ['enableMultiSort' => true],
	    'sort'=> ['defaultOrder' => ['emp_master_id'=>SORT_DESC]]
        ]);
	$dataProvider->sort->attributes['emp_unique_id'] = [
        'asc' => ['emp_info.emp_unique_id' => SORT_ASC],
        'desc' => ['emp_info.emp_unique_id' => SORT_DESC],
        ];
	$dataProvider->sort->attributes['emp_first_name'] = [
        'asc' => ['emp_info.emp_first_name' => SORT_ASC],
        'desc' => ['emp_info.emp_first_name' => SORT_DESC],
        ];
	$dataProvider->sort->attributes['emp_middle_name'] = [
        'asc' => ['emp_middle_name' => SORT_ASC],
        'desc' => ['emp_middle_name' => SORT_DESC],
        ];
	$dataProvider->sort->attributes['emp_last_name'] = [
        'asc' => ['emp_last_name' => SORT_ASC],
        'desc' => ['emp_last_name' => SORT_DESC],
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
            'emp_master_id' => $this->emp_master_id,
            'emp_master_emp_info_id' => $this->emp_master_emp_info_id,
            'emp_master_user_id' => $this->emp_master_user_id,
            'emp_master_department_id' => $this->emp_master_department_id,
            'emp_master_designation_id' => $this->emp_master_designation_id,
            'emp_master_category_id' => $this->emp_master_category_id,
            'emp_master_nationality_id' => $this->emp_master_nationality_id,
            'emp_master_emp_address_id' => $this->emp_master_emp_address_id,
            'emp_master_status_id' => $this->emp_master_status_id,
	    'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_status' => $this->is_status,
        ]);
	$query->andFilterWhere(['like', 'emp_info.emp_first_name', $this->emp_first_name])
	      ->andFilterWhere(['like', 'emp_info.emp_last_name', $this->emp_last_name])
	      ->andFilterWhere(['like','emp_info.emp_middle_name',$this->emp_middle_name])
	      ->andFilterWhere(['like', 'users.user_login_id', $this->user_login_id])
	      ->andFilterWhere(['like','emp_info.emp_unique_id',$this->emp_unique_id]);	
	
	unset($_SESSION['exportData']);
	$_SESSION['exportData'] = $dataProvider;
	
        return $dataProvider;
    }

    public static function getExportData() 
    {
		$data = [
			'data'=>$_SESSION['exportData'],
			'fileName'=>'Employee-Master-List', 
			'title'=>'Employee Master Report',
			'exportFile'=>'@app/modules/employee/views/emp-master/EmpMasterExportPdfExcel',
		];
		//print_r($data);exit;

	return $data;
    }
}
