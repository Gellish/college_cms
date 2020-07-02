<?php



namespace app\modules\course\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\course\models\Section;

class SectionSearch extends Section
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_id', 'section_batch_id', 'intake', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['section_name', 'created_at', 'updated_at'], 'safe'],
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
        $query = Section::find()->where(['<>', 'is_status', 2]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'sort'=> ['defaultOrder' => ['section_id'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'section_id' => $this->section_id,
            'section_batch_id' => $this->section_batch_id,
            'intake' => $this->intake,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_status' => $this->is_status,
        ]);

        $query->andFilterWhere(['like', 'section_name', $this->section_name]);

    	unset($_SESSION['exportData']);
    	$_SESSION['exportData'] = $dataProvider;

        return $dataProvider;
    }

    public static function getExportData()
    {
	$data = [
			'data'=>$_SESSION['exportData'],
			'fileName'=>'Sections-List',
			'title'=>'Section Report',
			'exportFile'=>'@app/modules/course/views/section/SectionExportPdfExcel',
		];

	return $data;
    }
}
