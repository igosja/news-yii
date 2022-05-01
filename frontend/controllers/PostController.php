<?php
declare(strict_types=1);

namespace frontend\controllers;

use common\models\db\Post;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

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
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($url): string
    {
        $model = Post::find()
            ->andWhere(['is_active' => true])
            ->andWhere(['url' => $url])
            ->one();
        if (!$model) {
            throw new NotFoundHttpException();
        }

        Post::updateAllCounters(['views' => 1], ['id' => $model->id]);

        $this->view->title = Yii::t('app', $model->translation_title[Yii::$app->language]);
        $this->view->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['/post/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
