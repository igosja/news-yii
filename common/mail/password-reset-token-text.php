<?php
declare(strict_types=1);

/**
 * @var yii\web\View $this
 * @var common\models\db\User $user
 */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<?= Yii::t('app', 'Hello {name},', ['name' => $user->username]) ?>
<?= Yii::t('app', 'Follow the link below to reset your password:') ?>
<?= $resetLink ?>
