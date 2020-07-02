<?php



namespace app\modules\dashboard\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\dashboard\models\Events;

class EventsSearch extends Events
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'event_type', 'event_all_day', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['event_title', 'event_detail', 'event_start_date', 'event_end_date', 'event_url', 'created_at', 'updated_at'], 'safe'],
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
        $query = Events::find();

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
            'event_id' => $this->event_id,
            'event_start_date' => $this->event_start_date,
            'event_end_date' => $this->event_end_date,
            'event_type' => $this->event_type,
            'event_all_day' => $this->event_all_day,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_status' => $this->is_status,
        ]);

        $query->andFilterWhere(['like', 'event_title', $this->event_title])
            ->andFilterWhere(['like', 'event_detail', $this->event_detail])
            ->andFilterWhere(['like', 'event_url', $this->event_url]);

        return $dataProvider;
    }
}
