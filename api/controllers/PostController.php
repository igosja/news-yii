<?php
declare(strict_types=1);

namespace api\controllers;

use common\models\db\Post;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * Class PostController
 * @package api\controllers
 */
class PostController extends AbstractController
{
    /**
     * @return \yii\data\ActiveDataProvider
     */
    public function actionIndex(int $category_id = null): ActiveDataProvider
    {
        $query = Post::find()
            ->andWhere(['is_active' => true])
            ->andFilterWhere(['category_id' => $category_id]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);
    }

    /**
     * @param string $url
     * @return \common\models\db\Post
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView(string $url): Post
    {
        $model = Post::find()
            ->andWhere(['is_active' => true, 'url' => $url])
            ->one();
        if (!$model) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}