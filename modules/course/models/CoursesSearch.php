<?php




namespace app\modules\course\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\course\models\Courses;


class CoursesSearch extends Courses
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['course_name', 'course_code', 'course_alias', 'created_at', 'updated_at'], 'safe'],
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
        $query = Courses::find()->where(['<>', 'is_status', 2]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'sort'=> ['defaultOrder' => ['course_id'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'course_id' => $this->course_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_status' => $this->is_status,
        ]);

        $query->andFilterWhere(['like', 'course_name', $this->course_name])
            ->andFilterWhere(['like', 'course_code', $this->course_code])
            ->andFilterWhere(['like', 'course_alias', $this->course_alias]);

    	unset($_SESSION['exportData']);
    	$_SESSION['exportData'] = $dataProvider;

        return $dataProvider;
    }

    public static function getExportData()
    {
	$data = [
			'data'=>$_SESSION['exportData'],
			'fileName'=>'Courses-List',
			'title'=>'Courses Report',
			'exportFile'=>'@app/modules/course/views/courses/CoursesExportPdfExcel',
		];

	return $data;
    }
}
