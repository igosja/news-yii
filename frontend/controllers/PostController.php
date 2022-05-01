<?php
declare(strict_types=1);

namespace frontend\controllers;

use common\models\db\Comment;
use common\models\db\Post;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class SiteController
 * @package frontend\controllers
 */
class PostController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $query = Post::find()
            ->andWhere(['is_active' => true]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        $this->view->title = Yii::t('app', 'Posts');

        return $this->render('index', [
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
            ->andWhere(['post_id' => $post->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        $this->view->title = Yii::t('app', $post->translation_title[Yii::$app->language]);
        $this->view->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['/post/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'post' => $post,
        ]);
    }
}
