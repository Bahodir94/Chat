<?php
 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
 
$this->title = 'Сменить пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
 
<div class="site-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Пожалуйста, выберите ваш новый пароль:</p>
    <div class="row">
        <div class="col-lg-5">
 
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
            <?= $form->field($model, 'currentPassword')->passwordInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'newPassword')->passwordInput() ?>
            <?= $form->field($model, 'repeatnewPassword')->passwordInput() ?>
            <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
 
        </div>
    </div>
</div>