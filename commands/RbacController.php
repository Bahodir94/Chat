<?php
namespace app\commands;
 
use Yii;
use yii\console\Controller;
use \app\rbac\UserGroupRule;
 
class RbacController extends Controller
{
    public function actionInit()
    {
        $authManager = \Yii::$app->authManager;
 
        // Create roles
        $guest  = $authManager->createRole('guest');
        $user  = $authManager->createRole('user');
        $admin  = $authManager->createRole('admin');
 
        // Create simple, based on action{$NAME} permissions

        $login  = $authManager->createPermission('login');
        $logout = $authManager->createPermission('logout');
        $signUp = $authManager->createPermission('signup');
        $change = $authManager->createPermission('change-password');
        $request = $authManager->createPermission('request-password-reset');
        $reset = $authManager->createPermission('reset-password');
        $users = $authManager->createPermission('users');
        $messages = $authManager->createPermission('incorrect-messages');
        $spam   = $authManager->createPermission('spam-message');
        $role   = $authManager->createPermission('change-role');
        $error  = $authManager->createPermission('error');
        $index  = $authManager->createPermission('index');
        $post   = $authManager->createPermission('post');
 
        // Add permissions in Yii::$app->authManager
        $authManager->add($login);
        $authManager->add($logout);
        $authManager->add($signUp);
        $authManager->add($change);
        $authManager->add($request);
        $authManager->add($reset);
        $authManager->add($users);
        $authManager->add($messages);
        $authManager->add($spam);
        $authManager->add($role);
        $authManager->add($error);
        $authManager->add($index);
        $authManager->add($post);
 
        // Add rule, based on UserExt->group === $user->group
        $userGroupRule = new UserGroupRule();
        $authManager->add($userGroupRule);
 
        // Add rule "UserGroupRule" in roles
        $guest->ruleName  = $userGroupRule->name;
        $user->ruleName = $userGroupRule->name;
        $admin->ruleName  = $userGroupRule->name;
 
        // Add roles in Yii::$app->authManager
        $authManager->add($guest);
        $authManager->add($user);
        $authManager->add($admin);
 
        // Add permission-per-role in Yii::$app->authManager
        // Guest
        $authManager->addChild($guest, $login);
        $authManager->addChild($guest, $logout);
        $authManager->addChild($guest, $error);
        $authManager->addChild($guest, $signUp);
        $authManager->addChild($guest, $index);
        $authManager->addChild($guest, $reset);
        $authManager->addChild($guest, $request);
 
        // USER
        $authManager->addChild($user, $post);
        $authManager->addChild($user, $change);
        $authManager->addChild($user, $guest);
 
        // Admin
        $authManager->addChild($admin, $users);
        $authManager->addChild($admin, $spam);
        $authManager->addChild($admin, $role);
        $authManager->addChild($admin, $user);
        $authManager->addChild($admin, $messages);
        $authManager->addChild($admin, $guest);
    }
}