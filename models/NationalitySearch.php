<?php



/**
 * NationalitySearch represents the model behind the search form about `app\models\Nationality`.
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Nationality;


class NationalitySearch extends Nationality
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nationality_id', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['nationality_name', 'created_at', 'updated_at'], 'safe'],
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
        $query = Nationality::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'sort'=> ['defaultOrder' => ['nationality_id'=>SORT_DESC]],

        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'nationality_id' => $this->nationality_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_status' => $this->is_status,
        ]);

        $query->andFilterWhere(['like', 'nationality_name', $this->nationality_name]);

	unset($_SESSION['exportData']);
	$_SESSION['exportData'] = $dataProvider;

        return $dataProvider;
    }

    public static function getExportData() 
    {
	$data = [
			'data'=>$_SESSION['exportData'],
			'fileName'=>'Nationality-List', 
			'title'=>'Nationality Report',
			'exportFile'=>'/nationality/NationalityExportPdfExcel',
		];

	return $data;
    }
}
