<?php
 
use yii\helpers\Html;
 
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/reset-password', 'token' => $user->password_reset_token]);
?>
Здравствуйте <?= $user->username ?>,
Перейдите по ссылке ниже, чтобы сбросить пароль::
<?= $resetLink ?>