<?php




namespace app\modules\student\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\student\models\StuAddress;

class StuAddressSearch extends StuAddress
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stu_address_id', 'stu_cadd_city', 'stu_cadd_state', 'stu_cadd_country', 'stu_cadd_pincode', 'stu_padd_city', 'stu_padd_state', 'stu_padd_country', 'stu_padd_pincode'], 'integer'],
            [['stu_cadd', 'stu_cadd_house_no', 'stu_cadd_phone_no', 'stu_padd', 'stu_padd_house_no', 'stu_padd_phone_no'], 'safe'],
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
        $query = StuAddress::find();

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
            'stu_address_id' => $this->stu_address_id,
            'stu_cadd_city' => $this->stu_cadd_city,
            'stu_cadd_state' => $this->stu_cadd_state,
            'stu_cadd_country' => $this->stu_cadd_country,
            'stu_cadd_pincode' => $this->stu_cadd_pincode,
            'stu_padd_city' => $this->stu_padd_city,
            'stu_padd_state' => $this->stu_padd_state,
            'stu_padd_country' => $this->stu_padd_country,
            'stu_padd_pincode' => $this->stu_padd_pincode,
        ]);

        $query->andFilterWhere(['like', 'stu_cadd', $this->stu_cadd])
            ->andFilterWhere(['like', 'stu_cadd_house_no', $this->stu_cadd_house_no])
            ->andFilterWhere(['like', 'stu_cadd_phone_no', $this->stu_cadd_phone_no])
            ->andFilterWhere(['like', 'stu_padd', $this->stu_padd])
            ->andFilterWhere(['like', 'stu_padd_house_no', $this->stu_padd_house_no])
            ->andFilterWhere(['like', 'stu_padd_phone_no', $this->stu_padd_phone_no]);

        return $dataProvider;
    }
}
