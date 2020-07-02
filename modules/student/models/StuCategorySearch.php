<?php




namespace app\modules\student\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\student\models\StuCategory;

class StuCategorySearch extends StuCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stu_category_id', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['stu_category_name', 'created_at', 'updated_at'], 'safe'],
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
        $query = StuCategory::find()->where(['is_status' => 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'sort'=> ['defaultOrder' => ['stu_category_id'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'stu_category_id' => $this->stu_category_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_status' => $this->is_status,
        ]);

        $query->andFilterWhere(['like', 'stu_category_name', $this->stu_category_name]);

	unset($_SESSION['exportData']);
	$_SESSION['exportData'] = $dataProvider;

        return $dataProvider;
    }

    public static function getExportData() 
    {
	$data = [
			'data'=>$_SESSION['exportData'],
			'fileName'=>'Student-Category-List', 
			'title'=>'Student Category Report',
			'exportFile'=>'@app/modules/student/views/stu-category/StuCategoryExportPdfExcel',
		];

	return $data;
    }
}
