<?php



/**
 * DocumentCategorySearch represents the model behind the search form about `app\models\DocumentCategory`.
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DocumentCategory;

class DocumentCategorySearch extends DocumentCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['doc_category_id', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['doc_category_name', 'doc_category_user_type', 'created_at', 'updated_at'], 'safe'],
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
        $query = DocumentCategory::find()->where(['is_status'=>0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'sort'=> ['defaultOrder' => ['doc_category_id'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'doc_category_id' => $this->doc_category_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_status' => $this->is_status,
        ]);

        $query->andFilterWhere(['like', 'doc_category_name', $this->doc_category_name])
            ->andFilterWhere(['like', 'doc_category_user_type', $this->doc_category_user_type]);
	
	unset($_SESSION['exportData']);
	$_SESSION['exportData'] = $dataProvider;

        return $dataProvider;
    }

    public static function getExportData() 
    {
	$data = [
			'data'=>$_SESSION['exportData'],
			'fileName'=>'Document-Category-List', 
			'title'=>'Document Category Report',
			'exportFile'=>'/document-category/DocumentCategoryExportPdfExcel',
		];

	return $data;
    }
}
