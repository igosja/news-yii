<?php
declare(strict_types=1);

namespace frontend\models\forms;

use common\models\db\User;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;

/**
 * Class VerifyEmailForm
 * @package frontend\models\forms
 */
class VerifyEmailForm extends Model
{
    /**
     * @var string $token
     */
    public string $token = '';

    /**
     * @var \common\models\db\User|null
     */
    private ?User $_user = null;

    /**
     * @param $token
     * @param array $config
     */
    public function __construct($token, array $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Verify email token cannot be blank.');
        }

        $this->_user = User::findByVerificationToken($token);
        if (!$this->_user) {
            throw new InvalidArgumentException('Wrong verify email token.');
        }

        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'token' => Yii::t('app', 'Token'),
        ];
    }

    /**
     * @return \common\models\db\User|null
     */
    public function getUser(): ?User
    {
        return $this->_user;
    }
}
