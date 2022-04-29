<?php
declare(strict_types=1);

namespace backend\models\search;

use common\models\db\Language;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class LanguageSearch
 * @package backend\models\search
 */
class LanguageSearch extends Language
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['code', 'name'], 'string'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios(): array
    {
        return Model::scenarios();
    }

    /**
     * @return string
     */
    public function formName(): string
    {
        return '';
    }

    /**
     * @param array $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['code' => $this->code])
            ->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}