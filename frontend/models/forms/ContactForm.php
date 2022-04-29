<?php
declare(strict_types=1);

namespace frontend\models\forms;

use Yii;
use yii\base\Model;

/**
 * Class ContactForm
 * @package frontend\models\forms
 */
class ContactForm extends Model
{
    /**
     * @var string $name
     */
    public string $name = '';

    /**
     * @var string $email
     */
    public string $email = '';

    /**
     * @var string $subject
     */
    public string $subject = '';

    /**
     * @var string $body
     */
    public string $body = '';

    /**
     * @var string $verifyCode
     */
    public string $verifyCode = '';

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['name', 'email', 'subject', 'body'], 'required'],
            [['email'], 'email'],
            [['verifyCode'], 'captcha'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'body' => Yii::t('app', 'Message'),
            'email' => Yii::t('app', 'Email'),
            'name' => Yii::t('app', 'Name'),
            'subject' => Yii::t('app', 'Subject'),
            'verifyCode' => Yii::t('app', 'Verify code'),
        ];
    }
}
