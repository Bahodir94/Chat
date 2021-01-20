<?php
 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
 
$this->title = 'Запрос на сброс пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
 
<div class="site-request-password-reset">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Пожалуйста, заполните вашу электронную почту. Ссылка для сброса пароля будет отправлена туда.</p>
    <div class="row">
        <div class="col-lg-5">
 
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
 
        </div>
    </div>
</div>