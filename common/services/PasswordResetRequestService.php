<?php
declare(strict_types=1);

namespace common\services;

use common\interfaces\ExecuteInterface;
use common\models\db\User;
use frontend\models\forms\PasswordResetRequestForm;
use Yii;

/**
 * Class PasswordResetRequestService
 * @package common\services
 */
class PasswordResetRequestService implements ExecuteInterface
{
    /**
     * @var \frontend\models\forms\PasswordResetRequestForm $_form
     */
    private PasswordResetRequestForm $_form;

    /**
     * @param \frontend\models\forms\PasswordResetRequestForm $form
     */
    public function __construct(PasswordResetRequestForm $form)
    {
        $this->_form = $form;
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function execute(): bool
    {
        if (!$this->_form->validate()) {
            return false;
        }

        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->_form->email,
        ]);

        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token ?? '')) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'password-reset-token-html', 'text' => 'password-reset-token-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::t('app', '{name} robot', ['name' => Yii::$app->name])])
            ->setTo($this->_form->email)
            ->setSubject(Yii::t('app', 'Password reset for {name}', ['name' => Yii::$app->name]))
            ->send();
    }
}
