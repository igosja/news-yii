<?php
declare(strict_types=1);

namespace common\services;

use common\interfaces\ExecuteInterface;
use common\models\db\User;
use frontend\models\forms\VerifyEmailForm;

class VerifyEmailService implements ExecuteInterface
{
    /**
     * @var \frontend\models\forms\VerifyEmailForm $_form
     */
    private VerifyEmailForm $_form;

    /**
     * @param \frontend\models\forms\VerifyEmailForm $_form
     */
    public function __construct(VerifyEmailForm $_form)
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

        $user = $this->_form->getUser();
        if (!$user) {
            return false;
        }

        $user->status = User::STATUS_ACTIVE;
        return $user->save(false);
    }
}
