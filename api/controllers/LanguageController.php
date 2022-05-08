<?php
declare(strict_types=1);

namespace api\controllers;

use common\models\db\Language;
use yii\data\ActiveDataProvider;

/**
 * Class LanguageController
 * @package api\controllers
 */
class LanguageController extends AbstractController
{
    /**
     * @return \yii\data\ActiveDataProvider
     */
    public function actionIndex(): ActiveDataProvider
    {
        $query = Language::find()
            ->andWhere(['is_active' => true]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);
    }
}