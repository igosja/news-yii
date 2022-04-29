<?php
declare(strict_types=1);

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/**
 * @var \common\models\db\Language $model
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, 'code')->textInput() ?>
        <?= $form->field($model, 'is_active')->checkbox() ?>
        <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-default']) ?>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>