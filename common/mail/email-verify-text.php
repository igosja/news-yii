<?php
declare(strict_types=1);

/**
 * @var yii\web\View $this
 * @var common\models\db\User $user
 */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
<?= Yii::t('app', 'Hello {name},', ['name' => $user->username]) ?>
<?= Yii::t('app', 'Follow the link below to reset your password:') ?>
<?= $verifyLink ?>
