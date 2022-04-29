<?php
declare(strict_types=1);

namespace backend\controllers;

use backend\models\search\CategorySearch;
use common\models\db\Category;
use Yii;
use yii\web\Response;

/**
 * Class CategoryController
 * @package backend\controllers
 */
class CategoryController extends AbstractController
{
    /**
     * @var string $dbClass
     */
    protected string $dbClass = Category::class;

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = Yii::t('app', 'Categories');
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate(): Response|string
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->successFlash();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $this->view->title = Yii::t('app', 'Create category');
        $this->view->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['category/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return \yii\web\Response|string
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate(int $id): Response|string
    {
        $model = $this->getModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->successFlash();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $this->view->title = Yii::t('app', 'Update category');
        $this->view->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['category/index']];
        $this->view->params['breadcrumbs'][] = [
            'label' => $model->name,
            'url' => ['category/view', 'id' => $model->id]
        ];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $model = $this->getModel($id);

        $this->view->title = $model->name;
        $this->view->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['category/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete(int $id): Response
    {
        $model = $this->getModel($id);

        if ($model->delete()) {
            $this->successFlash();
        }

        return $this->redirect(['index']);
    }
}
