<?php
declare(strict_types=1);

namespace common\services;

use common\interfaces\ExecuteInterface;
use frontend\models\forms\ContactForm;
use Yii;

/**
 * Class ContactService
 * @package common\services
 */
class ContactService implements ExecuteInterface
{
    /**
     * @var \frontend\models\forms\ContactForm $_form
     */
    private ContactForm $_form;

    /**
     * @param \frontend\models\forms\ContactForm $form
     */
    public function __construct(ContactForm $form)
    {
        $this->_form = $form;
    }

    /**
     * @return bool
     */
    public function execute(): bool
    {
        if (!$this->_form->validate()) {
            return false;
        }

        return Yii::$app->mailer->compose()
            ->setTo(Yii::$app->params['adminEmail'])
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setReplyTo([$this->_form->email => $this->_form->name])
            ->setSubject($this->_form->subject)
            ->setTextBody($this->_form->body)
            ->send();
    }
}