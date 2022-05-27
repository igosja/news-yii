<?php
declare(strict_types=1);

namespace frontend\controllers;

use common\models\db\Category;
use common\models\db\Comment;
use common\models\db\Post;
use common\models\db\Rating;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class SiteController
 * @package frontend\controllers
 */
class PostController extends AbstractController
{
    /**
     * @param int|null $category_id
     * @return string
     */
    public function actionIndex(int $category_id = null): string
    {
        $categories = Category::find()
            ->andWhere(['is_active' => true])
            ->all();

        $query = Post::find()
            ->andWhere(['is_active' => true])
            ->andFilterWhere(['category_id' => $category_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        $this->view->title = Yii::t('app', 'Posts');

        return $this->render('index', [
            'categories' => $categories,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $url
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($url): Response|string
    {
        $post = Post::find()
            ->andWhere(['is_active' => true])
            ->andWhere(['url' => $url])
            ->one();
        if (!$post) {
            throw new NotFoundHttpException();
        }

        Post::updateAllCounters(['views' => 1], ['id' => $post->id]);

        $model = new Comment();
        $model->post_id = $post->id;
        $model->language_id = $this->language->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->refresh();
        }

        $query = Comment::find()
            ->andWhere([
                'language_id' => $this->language->id,
                'post_id' => $post->id,
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        $this->view->title = Yii::t('app', $post->translation_title[Yii::$app->language]);
        $this->view->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['/post/index']];
        $this->view->params['breadcrumbs'][] = ['label' => $post->category->translation[Yii::$app->language], 'url' => ['/post/index', 'category_id' => $post->category_id]];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'post' => $post,
        ]);
    }

    /**
     * @param string $url
     * @param int $value
     * @return \yii\web\Response
     */
    public function actionRating(string $url, int $value): Response
    {
        $post = Post::find()
            ->andWhere(['is_active' => true])
            ->andWhere(['url' => $url])
            ->one();
        if (!$post || !ArrayHelper::isIn($value, [1, -1])) {
            return $this->redirect(['post/view', 'url' => $url]);
        }

        $model = Rating::find()
            ->andWhere(['post_id' => $post->id, 'created_by' => $this->user->id])
            ->one();
        if (!$model) {
            $model = new Rating();
            $model->post_id = $post->id;
        }
        $model->value = $value;
        $model->save();

        return $this->redirect(['post/view', 'url' => $url]);
    }
}
