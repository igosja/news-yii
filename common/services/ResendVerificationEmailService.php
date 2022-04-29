<?php
declare(strict_types=1);

namespace common\services;

use common\interfaces\ExecuteInterface;
use common\models\db\User;
use frontend\models\forms\ResendVerificationEmailForm;
use Yii;

/**
 * Class ResendVerificationEmailForm
 * @package common\services
 */
class ResendVerificationEmailService implements ExecuteInterface
{
    /**
     * @var \frontend\models\forms\ResendVerificationEmailForm $_form
     */
    private ResendVerificationEmailForm $_form;

    /**
     * @param \frontend\models\forms\ResendVerificationEmailForm $_form
     */
    public function __construct(ResendVerificationEmailForm $_form)
    {
        $this->_form = $_form;
    }

    /**
     * @return bool
     */
    public function execute(): bool
    {
        if (!$this->_form->validate()) {
            return false;
        }

        $user = User::findOne([
            'email' => $this->_form->email,
            'status' => User::STATUS_INACTIVE
        ]);

        if (!$user) {
            return false;
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::t('app', '{name} robot', ['name' => Yii::$app->name])])
            ->setTo($this->_form->email)
            ->setSubject(Yii::t('app', 'Account registration at {name}', ['name' => Yii::$app->name]))
            ->send();
    }
}
