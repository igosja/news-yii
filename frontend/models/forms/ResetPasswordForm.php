<?php
declare(strict_types=1);

namespace frontend\models\forms;

use common\models\db\User;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;

/**
 * Class ResetPasswordForm
 * @package frontend\models\forms
 *
 * @property-read null|\common\models\db\User $user
 */
class ResetPasswordForm extends Model
{
    /**
     * @var string $password
     */
    public string $password = '';

    /**
     * @var \common\models\db\User|null $_user
     */
    private ?User $_user = null;

    /**
     * @param string $token
     * @param array $config
     */
    public function __construct(string $token, array $config = [])
    {
        if (empty($token)) {
            throw new InvalidArgumentException(Yii::t('app', 'Password reset token cannot be blank.'));
        }

        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidArgumentException(Yii::t('app', 'Wrong password reset token.'));
        }

        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['password'], 'required'],
            [['password'], 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'password' => Yii::t('app', 'Password'),
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
