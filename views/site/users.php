<?php

$this->title = 'Пользователы';
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
                        <th>Логин</th>
                        <th>e-mail</th>
                        <th>Роль</th>
                        <th>Действие</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($users as $key => $user): ?>
                <tr>
                    <td><?=++$key?></td>
                    <td><?=$user->username?></td>
                    <td><?=$user->email?></td>
                    <td><?=$user->role?></td>
                    <td>
                        <? if ($user->role=='admin'):?>
                            <a href="<?=Url::to(['site/change-role/', 'id'=>$user->id, 'role'=>0])?>">Сделать пользователь</a>
                        <? else: ?>
                            <a href="<?=Url::to(['site/change-role/', 'id'=>$user->id, 'role'=>1])?>">Сделать админ</a>
                        <? endif ?>
                    </td>
                </tr>
                <?php endforeach?>
                </tbody>
            </table>
        </div>
    </div>
</div>