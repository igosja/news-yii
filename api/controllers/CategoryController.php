<?php
declare(strict_types=1);

namespace api\controllers;

use common\models\db\Category;
use yii\data\ActiveDataProvider;

/**
 * Class CategoryController
 * @package api\controllers
 */
class CategoryController extends AbstractController
{
    /**
     * @return \yii\data\ActiveDataProvider
     */
    public function actionIndex(): ActiveDataProvider
    {
        $query = Category::find()
            ->andWhere(['is_active' => true]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);
    }
}