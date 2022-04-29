<?php
declare(strict_types=1);

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/**
 * @var \common\models\db\Language[] $languageArray
 * @var \common\models\db\SourceMessage $model
 * @var \common\models\db\Message[] $models
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="alert alert-light">
            <?= $model->message ?>
        </div>
        <?php $form = ActiveForm::begin() ?>
        <?php foreach ($models as $key => $model): ?>
            <?= $form->field($model, "[$key]translation")->textInput()->label($languageArray[$key]->name) ?>
        <?php endforeach ?>
        <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => ['btn', 'btn-default']]) ?>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
