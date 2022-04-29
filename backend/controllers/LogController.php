<?php
declare(strict_types=1);

namespace backend\controllers;

use backend\models\search\LogSearch;
use common\models\db\Log;
use Yii;
use yii\web\Response;

/**
 * Class LogController
 * @package backend\controllers
 */
class LogController extends AbstractController
{
    /**
     * @var string $dbClass
     */
    protected string $dbClass = Log::class;

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new LogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = Yii::t('app', 'Logs');
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
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
        } else {
            $this->errorFlash();
        }

        return $this->redirect(['index']);
    }

    /**
     * @return \yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionClear(): Response
    {
        Yii::$app->db->createCommand()->truncateTable(Log::tableName())->execute();
        $this->successFlash();

        return $this->redirect(['index']);
    }
}
