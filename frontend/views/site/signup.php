<?php
declare(strict_types=1);

/**
 * @var yii\bootstrap5\ActiveForm $form
 * @var frontend\models\forms\SignupForm $model
 * @var yii\web\View $this
 */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Sign Up'), ['class' => ['btn', 'btn-primary']]) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
