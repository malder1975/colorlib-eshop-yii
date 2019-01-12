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

class SignupService
{
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

        return $user;
    }

}