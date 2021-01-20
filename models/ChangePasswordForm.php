<?php
 
namespace app\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;
 
/**
 * Change password form
 */
class ChangePasswordForm extends Model
{
    public $currentPassword;
    public $newPassword;
    public $repeatnewPassword;
    
    public function rules(){
        return [
            [['currentPassword','newPassword','repeatnewPassword'],'required'],
            ['currentPassword','findPasswords'],
            ['repeatnewPassword','compare','compareAttribute'=>'newPassword'],
        ];
    }
    
    public function findPasswords($attribute, $params){
        $user = User::findByUsername(Yii::$app->user->identity->username);
        $check = $user->validatePassword($this->currentPassword);

        if($check == false)
            $this->addError($attribute,'Неверный текущий пароль');
        else return true;
    }
    
    public function attributeLabels(){
        return [
            'currentPassword'=>'Текущий пароль',
            'newPassword'=>'Новый пароль',
            'repeatnewPassword'=>'Повторите новый пароль',
        ];
    }
    public function changePassword()
    {
        $user = User::findByUsername(Yii::$app->user->identity->username);
        $user->setPassword($this->newPassword);
        return $user->save(false);
    }
 
}