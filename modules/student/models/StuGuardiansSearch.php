<?php

namespace app\modules\student\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\student\models\StuGuardians;

class StuGuardiansSearch extends StuGuardians
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stu_guardian_id', 'guardian_mobile_no', 'guardia_stu_master_id'], 'integer'],
            [['guardian_name', 'guardian_relation', 'guardian_phone_no', 'guardian_qualification', 'guardian_occupation', 'guardian_income', 'guardian_email', 'guardian_home_address', 'guardian_office_address'], 'safe'],
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
        $query = StuGuardians::find()->where(['is_status' => 0]);

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
            'stu_guardian_id' => $this->stu_guardian_id,
            'guardian_mobile_no' => $this->guardian_mobile_no,
            'guardia_stu_master_id' => $this->guardia_stu_master_id,
        ]);

        $query->andFilterWhere(['like', 'guardian_name', $this->guardian_name])
            ->andFilterWhere(['like', 'guardian_relation', $this->guardian_relation])
            ->andFilterWhere(['like', 'guardian_phone_no', $this->guardian_phone_no])
            ->andFilterWhere(['like', 'guardian_qualification', $this->guardian_qualification])
            ->andFilterWhere(['like', 'guardian_occupation', $this->guardian_occupation])
            ->andFilterWhere(['like', 'guardian_income', $this->guardian_income])
            ->andFilterWhere(['like', 'guardian_email', $this->guardian_email])
            ->andFilterWhere(['like', 'guardian_home_address', $this->guardian_home_address])
            ->andFilterWhere(['like', 'guardian_office_address', $this->guardian_office_address]);

        return $dataProvider;
    }

    public function getGuardians($params)
    {
        $query = StuGuardians::find()->where(['is_status' => 0]);
	$query->join('join', 'stu_guardians as sg', 'sg.guardia_stu_master_id = stu_master.stu_master_id'
	)
	//->join('join', 'stu_info as si', 'si.stu_info_id = stu_master.stu_master_stu_info_id')
	->where(['stu_master.stu_master_id' => $params['id']]);

	$query->joinWith(['guardiaStuMaster']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }
}
