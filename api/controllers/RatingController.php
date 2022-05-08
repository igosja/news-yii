<?php
declare(strict_types=1);

namespace api\controllers;

use common\models\db\Rating;
use Yii;
use yii\base\InvalidArgumentException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

/**
 * Class CommentController
 * @package api\controllers
 */
class RatingController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                HttpBasicAuth::class,
                HttpBearerAuth::class,
                QueryParamAuth::class,
            ],
            'only' => ['create'],
        ];
        return $behaviors;
    }

    /**
     * @return \common\models\db\Rating
     */
    public function actionCreate(): Rating
    {
        $model = Rating::find()
            ->andWhere(['post_id' => Yii::$app->request->getBodyParam('post_id'), 'created_by' => Yii::$app->user->id])
            ->one();
        if (!$model) {
            $model = new Rating();
            $model->post_id = Yii::$app->request->getBodyParam('post_id');
        }
        $model->value = Yii::$app->request->getBodyParam('value');
        if ($model->save()) {
            return $model;
        }
        throw new InvalidArgumentException($model->getFirstError(array_key_first($model->getErrors())));
    }
}