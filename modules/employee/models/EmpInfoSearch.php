<?php




namespace app\modules\employee\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\employee\models\EmpInfo;

class EmpInfoSearch extends EmpInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_info_id', 'emp_mobile_no', 'emp_experience_year', 'emp_experience_month', 'emp_guardian_mobile_no', 'emp_info_emp_master_id'], 'integer'],
            [['emp_unique_id', 'emp_attendance_card_id', 'emp_title', 'emp_first_name', 'emp_middle_name', 'emp_last_name', 'emp_name_alias', 'emp_mother_name', 'emp_gender', 'emp_dob', 'emp_religion', 'emp_bloodgroup', 'emp_joining_date', 'emp_birthplace', 'emp_email_id', 'emp_maritalstatus', 'emp_photo', 'emp_languages', 'emp_bankaccount_no', 'emp_qualification', 'emp_specialization', 'emp_hobbies', 'emp_reference', 'emp_guardian_name', 'emp_guardian_relation', 'emp_guardian_qualification', 'emp_guardian_occupation', 'emp_guardian_income', 'emp_guardian_homeadd', 'emp_guardian_officeadd', 'emp_guardian_phone_no', 'emp_guardian_email_id'], 'safe'],
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
        $query = EmpInfo::find();

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
            'emp_info_id' => $this->emp_info_id,
            'emp_dob' => $this->emp_dob,
            'emp_joining_date' => $this->emp_joining_date,
            'emp_mobile_no' => $this->emp_mobile_no,
            'emp_experience_year' => $this->emp_experience_year,
            'emp_experience_month' => $this->emp_experience_month,
            'emp_guardian_mobile_no' => $this->emp_guardian_mobile_no,
            'emp_info_emp_master_id' => $this->emp_info_emp_master_id,
        ]);

        $query->andFilterWhere(['like', 'emp_unique_id', $this->emp_unique_id])
            ->andFilterWhere(['like', 'emp_attendance_card_id', $this->emp_attendance_card_id])
            ->andFilterWhere(['like', 'emp_title', $this->emp_title])
            ->andFilterWhere(['like', 'emp_first_name', $this->emp_first_name])
            ->andFilterWhere(['like', 'emp_middle_name', $this->emp_middle_name])
            ->andFilterWhere(['like', 'emp_last_name', $this->emp_last_name])
            ->andFilterWhere(['like', 'emp_name_alias', $this->emp_name_alias])
            ->andFilterWhere(['like', 'emp_mother_name', $this->emp_mother_name])
            ->andFilterWhere(['like', 'emp_gender', $this->emp_gender])
            ->andFilterWhere(['like', 'emp_religion', $this->emp_religion])
            ->andFilterWhere(['like', 'emp_bloodgroup', $this->emp_bloodgroup])
            ->andFilterWhere(['like', 'emp_birthplace', $this->emp_birthplace])
            ->andFilterWhere(['like', 'emp_email_id', $this->emp_email_id])
            ->andFilterWhere(['like', 'emp_maritalstatus', $this->emp_maritalstatus])
            ->andFilterWhere(['like', 'emp_photo', $this->emp_photo])
            ->andFilterWhere(['like', 'emp_languages', $this->emp_languages])
            ->andFilterWhere(['like', 'emp_bankaccount_no', $this->emp_bankaccount_no])
            ->andFilterWhere(['like', 'emp_qualification', $this->emp_qualification])
            ->andFilterWhere(['like', 'emp_specialization', $this->emp_specialization])
            ->andFilterWhere(['like', 'emp_hobbies', $this->emp_hobbies])
            ->andFilterWhere(['like', 'emp_reference', $this->emp_reference])
            ->andFilterWhere(['like', 'emp_guardian_name', $this->emp_guardian_name])
            ->andFilterWhere(['like', 'emp_guardian_relation', $this->emp_guardian_relation])
            ->andFilterWhere(['like', 'emp_guardian_qualification', $this->emp_guardian_qualification])
            ->andFilterWhere(['like', 'emp_guardian_occupation', $this->emp_guardian_occupation])
            ->andFilterWhere(['like', 'emp_guardian_income', $this->emp_guardian_income])
            ->andFilterWhere(['like', 'emp_guardian_homeadd', $this->emp_guardian_homeadd])
            ->andFilterWhere(['like', 'emp_guardian_officeadd', $this->emp_guardian_officeadd])
            ->andFilterWhere(['like', 'emp_guardian_phone_no', $this->emp_guardian_phone_no])
            ->andFilterWhere(['like', 'emp_guardian_email_id', $this->emp_guardian_email_id]);

        return $dataProvider;
    }
}
