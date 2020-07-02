<?php





namespace app\modules\employee\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\employee\models\EmpStatus;

class EmpStatusSearch extends EmpStatus
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_status_id', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['emp_status_name', 'emp_status_description', 'created_at', 'updated_at'], 'safe'],
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
        $query = EmpStatus::find()->where(['is_status' => 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'sort'=> ['defaultOrder' => ['emp_status_id'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'emp_status_id' => $this->emp_status_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_status' => $this->is_status,
        ]);

        $query->andFilterWhere(['like', 'emp_status_name', $this->emp_status_name])
            ->andFilterWhere(['like', 'emp_status_description', $this->emp_status_description]);

	unset($_SESSION['exportData']);
	$_SESSION['exportData'] = $dataProvider;	

        return $dataProvider;
    }
	
    public static function getExportData() 
    {
		$data = [
			'data'=>$_SESSION['exportData'],
			'fileName'=>'Employee-Status-List', 
			'title'=>'Employee Status Report',
			'exportFile'=>'@app/modules/employee/views/emp-status/EmpStatusExportPdfExcel',
		];

	return $data;
    }
}
