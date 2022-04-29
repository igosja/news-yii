<?php
declare(strict_types=1);

namespace backend\controllers;

use backend\models\search\SourceMessageSearch;
use common\models\db\Language;
use common\models\db\Message;
use common\models\db\SourceMessage;
use Yii;
use yii\web\Response;

/**
 * Class TranslationController
 * @package backend\controllers
 */
class TranslationController extends AbstractController
{
    /**
     * @var string $dbClass
     */
    protected string $dbClass = SourceMessage::class;

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new SourceMessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $languageArray = Language::find()
            ->orderBy(['id' => SORT_DESC])
            ->all();

        $this->view->title = Yii::t('app', 'Translations');
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'languageArray' => $languageArray,
            'searchModel' => $searchModel,
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
        /**
         * @var SourceMessage $model
         */
        $model = $this->getModel($id);

        $languageArray = Language::find()
            ->orderBy(['id' => SORT_DESC])
            ->indexBy('code')
            ->all();
        $models = [];
        foreach ($languageArray as $language) {
            $models[$language->code] = $model->getMessage($language->code)->one();
        }

        if (Message::loadMultiple($models, Yii::$app->request->post()) && Message::validateMultiple($models)) {
            foreach ($models as $modelItem) {
                $modelItem->save();
            }

            $this->successFlash();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $this->view->title = Yii::t('app', 'Update translation');
        $this->view->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Translations'), 'url' => ['translation/index']];
        $this->view->params['breadcrumbs'][] = [
            'label' => $model->id,
            'url' => ['translation/view', 'id' => $model->id]
        ];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('update', [
            'languageArray' => $languageArray,
            'model' => $model,
            'models' => $models,
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
        /**
         * @var SourceMessage $model
         */
        $model = $this->getModel($id);

        $languageArray = Language::find()
            ->orderBy(['id' => SORT_DESC])
            ->all();

        $this->view->title = $model->id;
        $this->view->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Translations'), 'url' => ['translation/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('view', [
            'languageArray' => $languageArray,
            'model' => $model,
        ]);
    }
}
