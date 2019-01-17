<?php

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm', 'token' => $user->email_confirm_token]);
?>
Приветствуем, <?= $user->$username ?>,

Ниже расположена ссылка для подтверждения Вашего Email-адреса:

<?= $confirmLink ?>
