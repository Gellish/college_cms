<?php



/**
 * CitySearch represents the model behind the search form about `app\models\City`.
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\City;

class CitySearch extends City
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id', 'city_state_id', 'city_country_id', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['city_name', 'created_at', 'updated_at'], 'safe'],
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
        $query = City::find()->where(['is_status'=>0]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'sort'=> ['defaultOrder' => ['city_id'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'city_id' => $this->city_id,
            'city_state_id' => $this->city_state_id,
            'city_country_id' => $this->city_country_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_status' => $this->is_status,
        ]);

        $query->andFilterWhere(['like', 'city_name', $this->city_name]);

	unset($_SESSION['exportData']);
	$_SESSION['exportData'] = $dataProvider;

        return $dataProvider;
    }

    public static function getExportData() 
    {
	$data = [
			'data'=>$_SESSION['exportData'],
			'fileName'=>'City-List', 
			'title'=>'City Report',
			'exportFile'=>'/city/CityExportPdfExcel',
		];

	return $data;
    }
}
