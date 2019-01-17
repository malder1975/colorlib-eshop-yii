<?php
use yii\helpers\Html;

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm', 'token' => $user->email_confirm_token]);
?>
<div class="password-reset">
    <p>Приветствуем, <?= Html::encode($user->username) ?>, </p>

    <p>Ниже расположена ссылка для подтверждения Вашего Email-адреса:</p>

    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
</div>
