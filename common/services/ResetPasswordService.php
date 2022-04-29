<?php
declare(strict_types=1);

namespace common\services;

use common\interfaces\ExecuteInterface;
use frontend\models\forms\ResetPasswordForm;

/**
 * Class ResetPasswordService
 * @package common\services
 */
class ResetPasswordService implements ExecuteInterface
{
    /**
     * @var \frontend\models\forms\ResetPasswordForm $_form
     */
    private ResetPasswordForm $_form;

    /**
     * @param \frontend\models\forms\ResetPasswordForm $_form
     */
    public function __construct(ResetPasswordForm $_form)
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

        $user = $this->_form->getUser();
        if (!$user) {
            return false;
        }

        $user->setPassword($this->_form->password);
        $user->removePasswordResetToken();
        $user->generateAuthKey();

        return $user->save(false);
    }
}
