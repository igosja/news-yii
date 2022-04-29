<?php
declare(strict_types=1);

namespace frontend\controllers;

use common\models\forms\LoginForm;
use common\services\ContactService;
use common\services\LoginService;
use common\services\PasswordResetRequestService;
use common\services\ResendVerificationEmailService;
use common\services\ResetPasswordService;
use common\services\SignupService;
use common\services\VerifyEmailService;
use frontend\models\forms\ContactForm;
use frontend\models\forms\PasswordResetRequestForm;
use frontend\models\forms\ResendVerificationEmailForm;
use frontend\models\forms\ResetPasswordForm;
use frontend\models\forms\SignupForm;
use frontend\models\forms\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\ErrorAction;
use yii\web\Response;

/**
 * Class SiteController
 * @package frontend\controllers
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
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
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
     * @return array
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
            'captcha' => [
                'class' => CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionLogin(): Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            $service = new LoginService($model);
            if ($service->execute()) {
                return $this->goBack();
            }
        }

        $model->password = '';

        $this->view->title = Yii::t('app', 'Log In');
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionContact(): Response|string
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {
            $service = (new ContactService($model));
            if ($service->execute()) {
                $this->successFlash(Yii::t('app', 'Thank you for contacting us. We will respond to you as soon as possible.'));
            } else {
                $this->errorFlash(Yii::t('app', 'There was an error sending your message.'));
            }

            return $this->refresh();
        }

        $this->view->title = Yii::t('app', 'Contact');
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionSignup(): Response|string
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            $service = new SignupService($model);
            if ($service->execute()) {
                $this->successFlash(Yii::t('app', 'Thank you for registration. Please check your inbox for verification email.'));

                return $this->goHome();
            }
        }

        $this->view->title = Yii::t('app', 'Sign Up');
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * @return \yii\web\Response|string
     * @throws \yii\base\Exception
     */
    public function actionRequestPasswordReset(): Response|string
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post())) {
            $service = new PasswordResetRequestService($model);
            if ($service->execute()) {
                $this->successFlash(Yii::t('app', 'Check your email for further instructions.'));

                return $this->goHome();
            }

            $this->errorFlash(Yii::t('app', 'Sorry, we are unable to reset password for the provided email address.'));
        }

        $this->view->title = Yii::t('app', 'Request password reset');
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('request-password-reset', [
            'model' => $model,
        ]);
    }

    /**
     * @param string $token
     * @return \yii\web\Response|string
     * @throws \yii\base\Exception
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionResetPassword(string $token): Response|string
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post())) {
            $service = new ResetPasswordService($model);
            if ($service->execute()) {
                $this->successFlash(Yii::t('app', 'New password saved.'));

                return $this->goHome();
            }
        }

        $this->view->title = Yii::t('app', 'Reset password');
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('reset-password', [
            'model' => $model,
        ]);
    }

    /**
     * @param string $token
     * @return \yii\web\Response
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionVerifyEmail(string $token): Response
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        $service = new VerifyEmailService($model);
        if ($service->execute() && Yii::$app->user->login($model->getUser())) {
            $this->successFlash(Yii::t('app', 'Your email has been confirmed!'));
            return $this->goHome();
        }

        $this->errorFlash(Yii::t('app', 'Sorry, we are unable to verify your account with provided token.'));
        return $this->goHome();
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionResendVerificationEmail(): Response|string
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post())) {
            $service = new ResendVerificationEmailService($model);
            if ($service->execute()) {
                $this->successFlash(Yii::t('app', 'Check your email for further instructions.'));

                return $this->goHome();
            }

            $this->errorFlash(Yii::t('app', 'Sorry, we are unable to resend verification email for the provided email address.'));
        }

        $this->view->title = Yii::t('app', 'Resend verification email');
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('resend-verification-email', [
            'model' => $model
        ]);
    }
}
