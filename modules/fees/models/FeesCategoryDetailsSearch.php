<?php


namespace app\modules\fees\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\fees\models\FeesCategoryDetails;

class FeesCategoryDetailsSearch extends FeesCategoryDetails
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fees_category_details_id', 'fees_details_category_id', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['fees_details_name', 'fees_details_description', 'created_at', 'updated_at'], 'safe'],
            [['fees_details_amount'], 'number'],
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
        $query = FeesCategoryDetails::find()->where(['is_status' => 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'sort'=> ['defaultOrder' => ['fees_category_details_id'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'fees_category_details_id' => $this->fees_category_details_id,
            'fees_details_category_id' => $this->fees_details_category_id,
            'fees_details_amount' => $this->fees_details_amount,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_status' => $this->is_status,
        ]);

        $query->andFilterWhere(['like', 'fees_details_name', $this->fees_details_name])
            ->andFilterWhere(['like', 'fees_details_description', $this->fees_details_description]);

        return $dataProvider;
    }

    public function get_fcd($params)
    {
        $query = FeesCategoryDetails::find()->where(['fees_details_category_id' => $_REQUEST['id'], 'is_status' => 0]);

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
            'fees_category_details_id' => $this->fees_category_details_id,
            'fees_details_category_id' => $this->fees_details_category_id,
            'fees_details_amount' => $this->fees_details_amount,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_status' => $this->is_status,
        ]);

        $query->andFilterWhere(['like', 'fees_details_name', $this->fees_details_name])
            ->andFilterWhere(['like', 'fees_details_description', $this->fees_details_description]);

        return $dataProvider;
    }
}
