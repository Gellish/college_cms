<?php




namespace app\modules\dashboard\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\dashboard\models\Notice;

class NoticeSearch extends Notice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notice_id', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['notice_title', 'notice_description', 'notice_user_type', 'notice_date', 'notice_file_path', 'created_at', 'updated_at'], 'safe'],
	    [['notice_date'], 'default', 'value'=>null],
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
        $query = Notice::find()->where('is_status <> 2');

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'sort'=> ['defaultOrder' => ['notice_id'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'notice_id' => $this->notice_id,
            'notice_date' => $this->dbDateSearch($this->notice_date),
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_status' => $this->is_status,
        ]);

        $query->andFilterWhere(['like', 'notice_title', $this->notice_title])
            ->andFilterWhere(['like', 'notice_description', $this->notice_description])
            ->andFilterWhere(['like', 'notice_user_type', $this->notice_user_type])
            ->andFilterWhere(['like', 'notice_file_path', $this->notice_file_path]);

	unset($_SESSION['exportData']);
	$_SESSION['exportData'] = $dataProvider;

        return $dataProvider;
    }

    public static function getExportData() 
    {
	$data = [
			'data'=>$_SESSION['exportData'],
			'fileName'=>'Notice-List', 
			'title'=>'Notice Report',
			'exportFile'=>'@app/modules/dashboard/views/notice/NoticeExportPdfExcel',
		];

	return $data;
    }

    private function dbDateSearch($value)
    {
            if($value != "" && preg_match('/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/', $value,$matches))
                return date("Y-m-d",strtotime($matches[0]));
            else
                return $value;
    }
}
