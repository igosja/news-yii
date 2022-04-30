<?php
declare(strict_types=1);

namespace backend\controllers;

use backend\models\search\PostSearch;
use common\models\db\Post;
use common\services\UploadImageService;
use Yii;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Class CategoryController
 * @package backend\controllers
 */
class PostController extends AbstractController
{
    /**
     * @var string $dbClass
     */
    protected string $dbClass = Post::class;

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = Yii::t('app', 'Posts');
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
        $model = new Post();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $upload_image = UploadedFile::getInstance($model, 'upload_image');
            if ($upload_image) {
                $service = (new UploadImageService($upload_image));
                $service->execute();

                $model->image_id = $service->getImageId();
            }

            if ($model->save()) {
                $model->url = '';
                $model->save();

                $this->successFlash();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $this->view->title = Yii::t('app', 'Create post');
        $this->view->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['post/index']];
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

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $upload_image = UploadedFile::getInstance($model, 'upload_image');
            if ($upload_image) {
                $service = (new UploadImageService($upload_image));
                $service->execute();

                $model->image_id = $service->getImageId();
            }

            if ($model->save()) {
                $this->successFlash();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $this->view->title = Yii::t('app', 'Update post');
        $this->view->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['post/index']];
        $this->view->params['breadcrumbs'][] = [
            'label' => $model->name,
            'url' => ['post/view', 'id' => $model->id]
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
        $this->view->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['post/index']];
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

    /**
     * @param int $id
     * @return \yii\web\Response
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDeleteImage(int $id): Response
    {
        $model = $this->getModel($id);

        $image = $model->image;

        $model->image_id = null;
        $model->save();

        if ($image) {
            $image->delete();
        }

        return $this->redirect(['update', 'id' => $model->id]);
    }
}
