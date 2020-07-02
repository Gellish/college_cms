<?php



/**
 * LoginDetailsSearch represents the model behind the search form about `app\models\LoginDetails`.
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LoginDetails;

class LoginDetailsSearch extends LoginDetails
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login_detail_id', 'login_user_id', 'login_status'], 'integer'],
            [['login_at', 'logout_at', 'user_ip_address'], 'safe'],
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
        $query = LoginDetails::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'sort' => [ 'defaultOrder' => [ 'login_detail_id' => SORT_DESC] ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'login_detail_id' => $this->login_detail_id,
            'login_user_id' => $this->login_user_id,
            'login_status' => $this->login_status,
            'login_at' => $this->login_at,
            'logout_at' => $this->logout_at,
        ]);

        $query->andFilterWhere(['like', 'user_ip_address', $this->user_ip_address]);

        return $dataProvider;
    }
}
