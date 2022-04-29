<?php
declare(strict_types=1);

/**
 * @var string $content
 * @var \yii\mail\MessageInterface $message
 * @var \yii\web\View $this
 */

?>
<?php $this->beginPage() ?>
<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>
<?php $this->endPage() ?>
