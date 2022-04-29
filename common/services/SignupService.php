<?php
declare(strict_types=1);

namespace common\services;

use common\interfaces\ExecuteInterface;
use common\models\db\User;
use frontend\models\forms\SignupForm;
use Yii;

/**
 * Class SignupService
 * @package common\services
 */
class SignupService implements ExecuteInterface
{
    /**
     * @var \frontend\models\forms\SignupForm $_form
     */
    private SignupForm $_form;

    /**
     * @param \frontend\models\forms\SignupForm $_form
     */
    public function __construct(SignupForm $_form)
    {
        $this->_form = $_form;
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

        $user = new User();
        $user->username = $this->_form->username;
        $user->email = $this->_form->email;
        $user->setPassword($this->_form->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        return $user->save() && $this->sendEmail($user);
    }

    /**
     * @param \common\models\db\User $user
     * @return bool
     */
    private function sendEmail(User $user): bool
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'email-verify-html', 'text' => 'email-verify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::t('app', '{name} robot', ['name' => Yii::$app->name])])
            ->setTo($this->_form->email)
            ->setSubject(Yii::t('app', 'Account registration at {name}', ['name' => Yii::$app->name]))
            ->send();
    }
}
