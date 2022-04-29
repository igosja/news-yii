<?php
declare(strict_types=1);

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\db\User $user
 */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p><?= Yii::t('app', 'Hello {name},', ['name' => Html::encode($user->username)]) ?></p>
    <p><?= Yii::t('app', 'Follow the link below to reset your password:') ?></p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
