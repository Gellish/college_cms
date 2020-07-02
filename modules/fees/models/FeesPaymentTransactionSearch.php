<?php




namespace app\modules\fees\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\fees\models\FeesPaymentTransaction;

class FeesPaymentTransactionSearch extends FeesPaymentTransaction
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fees_pay_tran_id', 'fees_pay_tran_collect_id', 'fees_pay_tran_stu_id', 'fees_pay_tran_batch_id', 'fees_pay_tran_course_id', 'fees_pay_tran_section_id', 'fees_pay_tran_mode', 'fees_pay_tran_cheque_no', 'fees_pay_tran_bank_id', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['fees_pay_tran_amount'], 'number'],
            [['fees_pay_tran_date', 'created_at', 'updated_at'], 'safe'],
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
        $query = FeesPaymentTransaction::find();

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
            'fees_pay_tran_id' => $this->fees_pay_tran_id,
            'fees_pay_tran_collect_id' => $this->fees_pay_tran_collect_id,
            'fees_pay_tran_stu_id' => $this->fees_pay_tran_stu_id,
            'fees_pay_tran_batch_id' => $this->fees_pay_tran_batch_id,
            'fees_pay_tran_course_id' => $this->fees_pay_tran_course_id,
            'fees_pay_tran_section_id' => $this->fees_pay_tran_section_id,
            'fees_pay_tran_mode' => $this->fees_pay_tran_mode,
            'fees_pay_tran_cheque_no' => $this->fees_pay_tran_cheque_no,
            'fees_pay_tran_bank_id' => $this->fees_pay_tran_bank_id,
            'fees_pay_tran_amount' => $this->fees_pay_tran_amount,
            'fees_pay_tran_date' => $this->fees_pay_tran_date,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_status' => $this->is_status,
        ]);

        return $dataProvider;
    }
}
