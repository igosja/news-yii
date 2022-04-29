<?php
declare(strict_types=1);

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\db\User $user
 */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
<div class="verify-email">
    <p><?= Yii::t('app', 'Hello {name},', ['name' => Html::encode($user->username)]) ?></p>
    <p><?= Yii::t('app', 'Follow the link below to verify your email:') ?></p>
    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
