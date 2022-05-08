<?php
declare(strict_types=1);

namespace api\controllers;

use common\models\db\Comment;
use Yii;
use yii\base\InvalidArgumentException;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

/**
 * Class CommentController
 * @package api\controllers
 */
class CommentController extends AbstractController
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
     * @return \yii\data\ActiveDataProvider
     */
    public function actionIndex(): ActiveDataProvider
    {
        $query = Comment::find()
            ->andFilterWhere(['language_id' => Yii::$app->request->getBodyParam('language_id')])
            ->andFilterWhere(['post_id' => Yii::$app->request->getBodyParam('post_id')]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);
    }

    /**
     * @return \common\models\db\Comment
     */
    public function actionCreate()
    {
        $model = new Comment();
        $model->post_id = Yii::$app->request->getBodyParam('post_id');
        $model->language_id = Yii::$app->request->getBodyParam('language_id');
        $model->text = Yii::$app->request->getBodyParam('text');
        if ($model->save()) {
            return $model;
        }
        throw new InvalidArgumentException($model->getFirstError(array_key_first($model->getErrors())));
    }
}