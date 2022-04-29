<?php
declare(strict_types=1);

namespace backend\controllers;

use backend\models\forms\LoginForm;
use common\services\LoginService;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ErrorAction;
use yii\web\Response;

/**
 * Class SiteController
 * @package backend\controllers
 */
class SiteController extends AbstractController
{
    /**
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return \yii\web\Response|string
     */
    public function actionLogin(): Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'main-login';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            $service = new LoginService($model);
            if ($service->execute()) {
                return $this->goBack();
            }
        }

        $model->password = '';

        $this->view->title = Yii::t('app', 'Login');
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
