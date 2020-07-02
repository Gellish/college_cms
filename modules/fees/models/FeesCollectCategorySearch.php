<?php



namespace app\modules\fees\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\fees\models\FeesCollectCategory;

class FeesCollectCategorySearch extends FeesCollectCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fees_collect_category_id', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['fees_collect_name', 'fees_collect_details', 'fees_collect_start_date', 'fees_collect_end_date', 'fees_collect_due_date', 'fees_collect_batch_id', 'created_at', 'updated_at'], 'safe'],
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
        //$query = FeesCollectCategory::find()->where(['fees_collect_category.is_status' => 0 ]);
	$query = FeesCollectCategory::find();
	//$query->joinWith(['feesCollectBatch']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'sort'=> ['defaultOrder' => ['fees_collect_category_id'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'fees_collect_category_id' => $this->fees_collect_category_id,
            'fees_collect_start_date' => $this->dbDateSearch($this->fees_collect_start_date),
            'fees_collect_end_date' => $this->dbDateSearch($this->fees_collect_end_date),
            'fees_collect_due_date' => $this->dbDateSearch($this->fees_collect_due_date),
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_status' => $this->is_status,
        ]);

        $query->andFilterWhere(['like', 'fees_collect_name', $this->fees_collect_name])
              ->andFilterWhere(['like', 'fees_collect_details', $this->fees_collect_details])
	      ->andFilterWhere(['like', 'fees_collect_batch_id', $this->fees_collect_batch_id]);

	unset($_SESSION['exportData']);
	$_SESSION['exportData'] = $dataProvider;

        return $dataProvider;
    }

    public static function getExportData() 
    {
	$data = [
			'data'=>$_SESSION['exportData'],
			'fileName'=>'Fees-Category-List', 
			'title'=>'Fees Category Report',
			'exportFile'=>'@app/modules/fees/views/fees-collect-category/FeesCollectCategoryExportPdfExcel',
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
