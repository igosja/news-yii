<?php
declare(strict_types=1);

namespace backend\controllers;

use backend\models\search\LanguageSearch;
use common\models\db\Language;
use Yii;
use yii\web\Response;

/**
 * Class LanguageController
 * @package backend\controllers
 */
class LanguageController extends AbstractController
{
    /**
     * @var string $dbClass
     */
    protected string $dbClass = Language::class;

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new LanguageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = Yii::t('app', 'Languages');
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
        $model = new Language();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->successFlash();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $this->view->title = Yii::t('app', 'Create language');
        $this->view->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Languages'), 'url' => ['language/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate(int $id): Response|string
    {
        $model = $this->getModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->successFlash();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $this->view->title = Yii::t('app', 'Update language');
        $this->view->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Languages'), 'url' => ['language/index']];
        $this->view->params['breadcrumbs'][] = [
            'label' => $model->name,
            'url' => ['language/view', 'id' => $model->id]
        ];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $model = $this->getModel($id);

        $this->view->title = $model->name;
        $this->view->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Languages'), 'url' => ['language/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return \yii\web\Response
     * @throws \Throwable
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
