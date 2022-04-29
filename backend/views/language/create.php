<?php
declare(strict_types=1);

use yii\helpers\Html;

/**
 * @var \common\models\db\Language $model
 * @var \yii\web\View $this
 */

?>
<ul class="list-inline text-center">
    <li class="list-inline-item">
        <?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => ['btn', 'btn-default']]) ?>
    </li>
</ul>
<?= $this->render('_form', ['model' => $model]) ?>
