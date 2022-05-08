<?php
declare(strict_types=1);

namespace api\controllers;

use common\models\db\Post;
use yii\data\ActiveDataProvider;

/**
 * Class PostController
 * @package api\controllers
 */
class PostController extends AbstractController
{
    /**
     * @return \yii\data\ActiveDataProvider
     */
    public function actionIndex(): ActiveDataProvider
    {
        $query = Post::find()
            ->andWhere(['is_active' => true]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);
    }
}