<?php




namespace app\modules\employee\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\employee\models\EmpCategory;

/**
 * 
 */
class EmpCategorySearch extends EmpCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_category_id', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['emp_category_name', 'emp_category_alias', 'created_at', 'updated_at'], 'safe'],
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
        $query = EmpCategory::find()->where(['is_status' => 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'sort'=> ['defaultOrder' => ['emp_category_id'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'emp_category_id' => $this->emp_category_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_status' => $this->is_status,
        ]);

        $query->andFilterWhere(['like', 'emp_category_name', $this->emp_category_name])
            ->andFilterWhere(['like', 'emp_category_alias', $this->emp_category_alias]);

	unset($_SESSION['exportData']);
	$_SESSION['exportData'] = $dataProvider;	

        return $dataProvider;
    }
    public static function getExportData() 
    {
		$data = [
			'data'=>$_SESSION['exportData'],
			'fileName'=>'Employee-Category-List', 
			'title'=>'Employee Category Report',
			'exportFile'=>'@app/modules/employee/views/emp-category/EmpCategoryExportPdfExcel',
		];

	return $data;
    }
}
