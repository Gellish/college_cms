<?php





namespace app\modules\employee\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\employee\models\EmpDocs;

/**
 * 
 */
class EmpDocsSearch extends EmpDocs
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_docs_id', 'emp_docs_category_id', 'emp_docs_status', 'emp_docs_emp_master_id', 'created_by'], 'integer'],
            [['emp_docs_details', 'emp_docs_path', 'emp_docs_submited_at'], 'safe'],
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
        $query = EmpDocs::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'emp_docs_id' => $this->emp_docs_id,
            'emp_docs_category_id' => $this->emp_docs_category_id,
            'emp_docs_submited_at' => $this->emp_docs_submited_at,
            'emp_docs_status' => $this->emp_docs_status,
            'emp_docs_emp_master_id' => $this->emp_docs_emp_master_id,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'emp_docs_details', $this->emp_docs_details])
            ->andFilterWhere(['like', 'emp_docs_path', $this->emp_docs_path]);

        return $dataProvider;
    }
}
