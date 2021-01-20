<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use app\models\User;
use app\models\Messages;
use yii\db\Expression;

class SiteController extends Controller
{

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (!\Yii::$app->user->can($action->id)) {
                throw new ForbiddenHttpException('Access denied');
            }
            return true;
        } else {
            return false;
        }
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'users', 'incorrect-messages', 'post', 'change-role', 'spam-message'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            
        ];
    }
  
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $messages = Messages::find()->all();
        return $this->render('index', compact('messages'));
    }

    public function actionPost(){
        if (Yii::$app->request->post()){
            $msg = Yii::$app->request->post('msg');
            $message = new Messages();
            $message->text = $msg;
            $message->user = \Yii::$app->user->identity->username;
            $message->created_at = time();
            $message->save();
            return true;
        }
    }

    public function actionUsers(){
        $users = User::find()->all();
        return $this->render('users', compact('users'));
    }

    public function actionChangeRole($id, $role){
        $user = User::findOne($id);
        $role == 1 ? $user->role = 'admin' : $user->role = 'user';
        $user->save();
        \Yii::$app->session->setFlash('success', 'Роль пользователя успешно обновлена!');
        return $this->redirect(['site/users']);
    }

    public function actionSpamMessage($id, $status){
        $message = Messages::findOne($id);
        $status == 1 ? $message->spam = 1 : $message->spam = 0;
        $message->save(); 
        \Yii::$app->session->setFlash('success', 'Статус сообщения успешно обновлена!');
        return $this->redirect(['site/incorrect-messages']);
    }

    public function actionIncorrectMessages(){
        $messages = Messages::find()->where(['spam'=>1])->all();
        return $this->render('incorrect-messages', compact('messages'));
    }

}
