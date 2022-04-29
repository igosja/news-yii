<?php
declare(strict_types=1);

/**
 * @var yii\bootstrap5\ActiveForm $form
 * @var common\models\forms\LoginForm $model
 * @var yii\web\View $this
 */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
            <div class="my-1 mx-0" style="color:#999;">
                <?= Yii::t('app', 'If you forgot your password you can {link}.', [
                    'link' => Html::a(Yii::t('app', 'reset it'), ['site/request-password-reset'])
                ]) ?>
                <br>
                <?= Yii::t('app', 'Need new verification email? {link}', [
                    'link' => Html::a(Yii::t('app', 'Resend'), ['site/resend-verification-email'])
                ]) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Log In'), ['class' => ['btn', 'btn-primary']]) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
