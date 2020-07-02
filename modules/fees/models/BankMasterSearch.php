<?php




namespace app\modules\fees\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\fees\models\BankMaster;

class BankMasterSearch extends BankMaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bank_master_id', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['bank_master_name', 'bank_alias', 'created_at', 'updated_at'], 'safe'],
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
        $query = BankMaster::find()->where(['is_status' => 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'sort'=> ['defaultOrder' => ['bank_master_id'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'bank_master_id' => $this->bank_master_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_status' => $this->is_status,
        ]);

        $query->andFilterWhere(['like', 'bank_master_name', $this->bank_master_name])
            ->andFilterWhere(['like', 'bank_alias', $this->bank_alias]);

	unset($_SESSION['exportData']);
	$_SESSION['exportData'] = $dataProvider;

        return $dataProvider;
    }

    public static function getExportData() 
    {
	$data = [
			'data'=>$_SESSION['exportData'],
			'fileName'=>'Bank-Master-List', 
			'title'=>'Bank Master Report',
			'exportFile'=>'@app/modules/fees/views/bank-master/BankMasterExportPdfExcel',
		];

	return $data;
    }
}
