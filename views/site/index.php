<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
use yii\helpers\Html;
use yii\helpers\Url;
echo Html :: csrfMetaTags();
?>
<div class="site-index">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div  class="messages">
                <? foreach($messages as $message):?>
                    <? if ($message->spam == 1 && \Yii::$app->user->identity->role == 'admin'):?>
                        <div class="<?=$message->user == \Yii::$app->user->identity->username ? 'own' : 'not-own';?>">
                            <small class="user"><?=$message->user?></small>
                            <small class="text-left label label-danger">спам</small>
                            <span class='action label label-info'>
                                <a href="<?=Url::to(['site/spam-message','id'=>$message->id, 'status'=>0])?>">Показать</a>
                            </span>
                            <p class='msg'><?=$message->text?></p>
                            <small><?=date('d.m.Y',$message->created_at)?></small>
                            <small><?=date('H:i',$message->created_at)?></small>
                        </div>

                    <? elseif ($message->spam == 0): ?>
                        
                        <div class='<?=$message->user == \Yii::$app->user->identity->username? 'own' : 'not-own'?>'>
                            <small class="user <?=$message->getRole() == 'admin'?'label label-primary':''?>"><?=$message->user?></small>
                            <? if (\Yii::$app->user->identity->role == 'admin'):?>
                                <span class='action label label-warning'>
                                    <a href="<?=Url::to(['site/spam-message','id'=>$message->id, 'status'=>1])?>">Скрыть</a>
                                </span>
                            <? endif?>
                            <p class='msg'><?=$message->text?></p>
                            <small><?=date('d.m.Y',$message->created_at)?></small>
                            <small><?=date('H:i',$message->created_at)?></small>
                    </div>
                    <? endif ?>
                <? endforeach?>
            </div>
            <div class="message-form">
                <? if (\Yii::$app->user->isGuest): ?>
                    <p class="center-block">Чтобы написать в чате, <a href="<?=Url::to(['auth/login'])?>">войдите</a> или <a href="<?=Url::to(['auth/signup'])?>">зарегистрируйтесь</a>.</p>
                <? else: ?>
                <textarea id="msg" class="form-control" required></textarea>
                <button id="send" class="btn btn-success float-right " disabled>Отправить</button>
                <? endif?>
            </div>
        </div>
    </div>
</div>

<?php
$csrfName=Yii::$app->request->csrfParam; 
$csrf = Yii::$app->request->getCsrfToken();

$js = <<<JS

    $('#send').click(function(){
        send();
    });
    $('#msg').keyup(function(){
        var text = $('#msg').val();

        if (text != "") $('#send').prop('disabled', false);
        else $('#send').prop('disabled', true);
    });
    function send(){
        var text = $('#msg').val();

        var csrfParam = $('meta[name="csrf-param"]').attr("content");
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var data = {
            msg: text,
            csrfParam: csrfToken,
        }
        $.ajax({
            url: "/post",
            type: "post",
            data: data ,
            success: function (res) {
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            }
        });
    }
JS;

$this->registerJS($js, \yii\web\View::POS_END);