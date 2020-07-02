<?php


/**
 * OrganizationSearch represents the model behind the search form about `app\models\Organization`.
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Organization;

class OrganizationSearch extends Organization
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['org_id', 'created_by', 'updated_by'], 'integer'],
            [['org_name', 'org_alias', 'org_address_line1', 'org_address_line2', 'org_phone', 'org_email', 'org_website', 'org_logo', 'org_logo_type', 'created_at', 'updated_at'], 'safe'],
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
        $query = Organization::find();

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
            'org_id' => $this->org_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'org_name', $this->org_name])
            ->andFilterWhere(['like', 'org_alias', $this->org_alias])
            ->andFilterWhere(['like', 'org_address_line1', $this->org_address_line1])
            ->andFilterWhere(['like', 'org_address_line2', $this->org_address_line2])
            ->andFilterWhere(['like', 'org_phone', $this->org_phone])
            ->andFilterWhere(['like', 'org_email', $this->org_email])
            ->andFilterWhere(['like', 'org_website', $this->org_website])
            ->andFilterWhere(['like', 'org_logo', $this->org_logo])
            ->andFilterWhere(['like', 'org_logo_type', $this->org_logo_type]);

        return $dataProvider;
    }
}
