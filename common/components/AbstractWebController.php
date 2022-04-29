<?php
declare(strict_types=1);

namespace common\components;

use common\models\db\Language;
use common\models\db\User;
use Yii;
use yii\db\ActiveRecord;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class AbstractWebController
 * @package common\components
 */
abstract class AbstractWebController extends Controller
{
    /**
     * @var \common\models\db\User|null $user
     */
    public ?User $user = null;
    /**
     * @var string $dbClass
     */
    protected string $dbClass = ActiveRecord::class;

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (!Yii::$app->user->isGuest) {
            $this->loadCurrentUser();
        }

        $this->loadLanguage();

        return true;
    }

    private function loadCurrentUser(): void
    {
        $this->user = Yii::$app->user->identity;
    }

    /**
     * @return void
     */
    private function loadLanguage(): void
    {
        if (Yii::$app->request->post('language')) {
            Yii::$app->session->set('language', Yii::$app->request->post('language'));
            $this->refresh();
        }

        if (Yii::$app->session->get('language')) {
            Yii::$app->language = Yii::$app->session->get('language');
        }

        $language = null;

        $languages = Language::find()
            ->andWhere(['is_active' => true])
            ->orderBy(['id' => SORT_DESC])
            ->all();
        foreach ($languages as $language) {
            if ($language->code === Yii::$app->language) {
                return;
            }
        }

        Yii::$app->language = $language ? $language->code : 'uk';
    }

    /**
     * @param string|null $text
     * @return void
     */
    protected function errorFlash(string $text = null): void
    {
        if (null === $text) {
            $text = Yii::t('app', 'Error');
        }
        Yii::$app->session->setFlash('error', $text);
    }

    /**
     * @param string|null $text
     * @return void
     */
    protected function successFlash(string $text = null): void
    {
        if (null === $text) {
            $text = Yii::t('app', 'Success');
        }
        Yii::$app->session->setFlash('success', $text);
    }

    /**
     * @param int $id
     * @param array $params
     * @return \yii\db\ActiveRecord
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     */
    protected function getModel(int $id, array $params = []): ActiveRecord
    {
        $model = Yii::createObject($this->dbClass)::find()
            ->andWhere(['id' => $id])
            ->andFilterWhere($params)
            ->limit(1)
            ->one();
        $this->notFound($model);

        return $model;
    }

    /**
     * @param ActiveRecord|null $model
     * @throws \yii\web\NotFoundHttpException
     */
    protected function notFound(ActiveRecord $model = null): void
    {
        if (!$model) {
            throw new NotFoundHttpException(Yii::t('app', 'Page not found'));
        }
    }
}
