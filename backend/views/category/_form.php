<?php
declare(strict_types=1);

use common\models\db\Language;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/**
 * @var \common\models\db\Category $model
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($model, 'name')->textInput() ?>
        <?php foreach (Language::codes() as $code): ?>
            <?= $form
                ->field($model, 'translation[' . $code . ']')
                ->textInput()
                ->label($model->getAttributeLabel('translation') . ' (' . $code . ')') ?>
        <?php endforeach ?>
        <?= $form->field($model, 'is_active')->checkbox() ?>
        <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-default']) ?>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>