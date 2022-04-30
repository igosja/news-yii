<?php
declare(strict_types=1);

use common\models\db\Category;
use common\models\db\Language;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * @var \common\models\db\Post $model
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php foreach ($model->getErrorSummary(true) as $error): ?>
            <?= $error ?>
        <?php endforeach ?>
        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, 'url')->textInput() ?>
        <?= $form->field($model, 'category_id')->dropDownList(
            ArrayHelper::map(Category::find()->all(), 'id', 'name'),
            ['prompt' => $model->getAttributeLabel('category_id')]
        ) ?>
        <?php if ($model->image && $model->image->path) : ?>
            <div class="form-group">
                <label class="col-lg-3 control-label"><?= $model->getAttributeLabel('upload_image') ?></label>
                <div class="col-md-6">
                    <?= Html::a('×', ['delete-image', 'id' => $model->primaryKey], ['title' => Yii::t('app', 'Delete')]) ?>
                    <?= Html::img($model->image->path, ['class' => 'img-fluid']) ?>
                </div>
            </div>
        <?php else : ?>
            <?= $form->field($model, 'upload_image')->fileInput() ?>
        <?php endif ?>
        <?php foreach (Language::codes() as $code): ?>
            <?= $form
                ->field($model, 'translation_title[' . $code . ']')
                ->textInput()
                ->label($model->getAttributeLabel('translation_title') . ' (' . $code . ')') ?>
        <?php endforeach ?>
        <?php foreach (Language::codes() as $code): ?>
            <?= $form
                ->field($model, 'translation_text[' . $code . ']')
                ->textarea(['rows' => 10])
                ->label($model->getAttributeLabel('translation_text') . ' (' . $code . ')') ?>
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
