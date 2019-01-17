<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.01.2019
 * Time: 21:23
 */

namespace frontend\services\auth;


use common\entities\User;
use frontend\forms\SignupForm;
use http\Exception\RuntimeException;
use yii\mail\MailerInterface;

class SignupService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function signup(SignupForm $form): User
    {
        $user = User::signup(
            $form->username,
            $form->email,
            $form->password
        );

        if (!$user->save()) {
            throw new \RuntimeException('Ошибка сохранения!');
        }

        $sent = $this->mailer
            ->compose(
                ['html' => 'emailComfirmToken-html', 'text' => 'emailConfirmToken-text'],
                ['user' => $user]
            )
            ->setTo($form->email)
            ->setSubject('Подтверждение регистрации для ' . \Yii::$app->name)
            ->send();
        if (!$sent) {
            throw new \RuntimeException('Ошибка отправки письма.');
        }
        //return $user;
    }

    public function confirm($token): void
    {
        if (empty($token)) {
            throw new \DomainException('Пустой ключ активации.');
        }

        $user = User::findOne(['email_confirm_token' => $token]);

        if (!$user) {
            throw new \DomainException('Пользователь не найден!');
        }

        $user->confirmSignup();

        if (!$user->save()) {
            throw new RuntimeException('Ошибка сохранения пользователя.');
        }
    }

}