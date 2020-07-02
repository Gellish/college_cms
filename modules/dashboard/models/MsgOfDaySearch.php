<?php




namespace app\modules\dashboard\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\dashboard\models\MsgOfDay;

class MsgOfDaySearch extends MsgOfDay
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['msg_of_day_id', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['msg_details', 'msg_user_type', 'created_at', 'updated_at'], 'safe'],
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
        $query = MsgOfDay::find()->where('is_status <> 2');

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'sort'=> ['defaultOrder' => ['msg_of_day_id'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'msg_of_day_id' => $this->msg_of_day_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_status' => $this->is_status,
        ]);

        $query->andFilterWhere(['like', 'msg_details', $this->msg_details])
            ->andFilterWhere(['like', 'msg_user_type', $this->msg_user_type]);

	unset($_SESSION['exportData']);
	$_SESSION['exportData'] = $dataProvider;

        return $dataProvider;
    }

    public static function getExportData() 
    {
	$data = [
			'data'=>$_SESSION['exportData'],
			'fileName'=>'Message-Of-Day-List', 
			'title'=>'Message Of Day Report',
			'exportFile'=>'@app/modules/dashboard/views/msg-of-day/MsgOfDayExportPdfExcel',
		];

	return $data;
    }
}
