<?php
declare(strict_types=1);

/**
 * @var yii\bootstrap5\ActiveForm $form
 * @var frontend\models\forms\PasswordResetRequestForm $model
 * @var yii\web\View $this
 */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>
<div class="site-request-password-reset">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin() ?>
            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => ['btn', 'btn-primary']]) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
