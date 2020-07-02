<?php




namespace app\modules\student\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\student\models\StuDocs;

class StuDocsSearch extends StuDocs
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stu_docs_id', 'stu_docs_category_id', 'stu_docs_submited_at', 'stu_docs_status', 'stu_docs_stu_master_id', 'created_by'], 'integer'],
            [['stu_docs_details', 'stu_docs_path'], 'safe'],
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
        $query = StuDocs::find();

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
            'stu_docs_id' => $this->stu_docs_id,
            'stu_docs_category_id' => $this->stu_docs_category_id,
            'stu_docs_submited_at' => $this->stu_docs_submited_at,
            'stu_docs_status' => $this->stu_docs_status,
            'stu_docs_stu_master_id' => $this->stu_docs_stu_master_id,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'stu_docs_details', $this->stu_docs_details])
            ->andFilterWhere(['like', 'stu_docs_path', $this->stu_docs_path]);

        return $dataProvider;
    }
}
