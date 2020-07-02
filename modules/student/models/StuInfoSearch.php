<?php




namespace app\modules\student\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\student\models\StuInfo;

class StuInfoSearch extends StuInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stu_info_id', 'stu_mobile_no', 'stu_info_stu_master_id'], 'integer'],
            [['stu_unique_id', 'stu_title', 'stu_first_name', 'stu_middle_name', 'stu_last_name', 'stu_gender', 'stu_dob', 'stu_email_id', 'stu_bloodgroup', 'stu_birthplace', 'stu_religion', 'stu_admission_date', 'stu_photo', 'stu_languages'], 'safe'],
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
        $query = StuInfo::find();

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
            'stu_info_id' => $this->stu_info_id,
            'stu_dob' => $this->stu_dob,
            'stu_admission_date' => $this->stu_admission_date,
            'stu_mobile_no' => $this->stu_mobile_no,
            'stu_info_stu_master_id' => $this->stu_info_stu_master_id,
        ]);

        $query->andFilterWhere(['like', 'stu_unique_id', $this->stu_unique_id])
            ->andFilterWhere(['like', 'stu_title', $this->stu_title])
            ->andFilterWhere(['like', 'stu_first_name', $this->stu_first_name])
            ->andFilterWhere(['like', 'stu_middle_name', $this->stu_middle_name])
            ->andFilterWhere(['like', 'stu_last_name', $this->stu_last_name])
            ->andFilterWhere(['like', 'stu_gender', $this->stu_gender])
            ->andFilterWhere(['like', 'stu_email_id', $this->stu_email_id])
            ->andFilterWhere(['like', 'stu_bloodgroup', $this->stu_bloodgroup])
            ->andFilterWhere(['like', 'stu_birthplace', $this->stu_birthplace])
            ->andFilterWhere(['like', 'stu_religion', $this->stu_religion])
            ->andFilterWhere(['like', 'stu_photo', $this->stu_photo])
            ->andFilterWhere(['like', 'stu_languages', $this->stu_languages]);

        return $dataProvider;
    }
}
