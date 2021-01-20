<?php

$this->title = 'Некорректных сообщений';
use yii\helpers\Html;
use yii\helpers\Url;
echo Html :: csrfMetaTags();
?>
<div class="site-index">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Сообщения</th>
                        <th>Написал</th>
                        <th>Показать/скрыть в чате</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($messages as $key => $message): ?>
                <tr>
                    <td><?=++$key?></td>
                    <td><?=$message->text?></td>
                    <td><?=$message->user?></td>
                    <td>
                        <? if ($message->spam==1):?>
                            <a href="<?=Url::to(['site/spam-message/', 'id'=>$message->id, 'status'=> 0])?>">Показать</a>
                        <? else: ?>
                            <a href="<?=Url::to(['site/spam-message/', 'id'=>$message->id, 'status'=> 1])?>">Скрыть</a>
                        <? endif ?>
                    </td>
                </tr>
                <?php endforeach?>
                </tbody>
            </table>
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
                console.log(res);
            },
            error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            }
        });
        console.log(data);
    }
JS;

$this->registerJS($js, \yii\web\View::POS_END);