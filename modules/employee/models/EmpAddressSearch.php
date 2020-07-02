<?php




namespace app\modules\employee\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\employee\models\EmpAddress;

class EmpAddressSearch extends EmpAddress
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_address_id', 'emp_cadd_city', 'emp_cadd_state', 'emp_cadd_country', 'emp_cadd_pincode', 'emp_padd_city', 'emp_padd_state', 'emp_padd_country', 'emp_padd_pincode'], 'integer'],
            [['emp_cadd', 'emp_cadd_house_no', 'emp_cadd_phone_no', 'emp_padd', 'emp_padd_house_no', 'emp_padd_phone_no'], 'safe'],
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
        $query = EmpAddress::find();

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
            'emp_address_id' => $this->emp_address_id,
            'emp_cadd_city' => $this->emp_cadd_city,
            'emp_cadd_state' => $this->emp_cadd_state,
            'emp_cadd_country' => $this->emp_cadd_country,
            'emp_cadd_pincode' => $this->emp_cadd_pincode,
            'emp_padd_city' => $this->emp_padd_city,
            'emp_padd_state' => $this->emp_padd_state,
            'emp_padd_country' => $this->emp_padd_country,
            'emp_padd_pincode' => $this->emp_padd_pincode,
        ]);

        $query->andFilterWhere(['like', 'emp_cadd', $this->emp_cadd])
            ->andFilterWhere(['like', 'emp_cadd_house_no', $this->emp_cadd_house_no])
            ->andFilterWhere(['like', 'emp_cadd_phone_no', $this->emp_cadd_phone_no])
            ->andFilterWhere(['like', 'emp_padd', $this->emp_padd])
            ->andFilterWhere(['like', 'emp_padd_house_no', $this->emp_padd_house_no])
            ->andFilterWhere(['like', 'emp_padd_phone_no', $this->emp_padd_phone_no]);

        return $dataProvider;
    }
}
