<?php

namespace app\controllers;
use Yii;

class RbacController extends \yii\web\Controller
{
    public function actionRule()
    {
        $auth = Yii::$app->authManager;

        $rule = new \app\component\OnlyAuthor;
        $auth->add($rule);

        $updateOwnPost = $auth->createPermission('penyebarluasanOwnUpdate');
        $updateOwnPost->description = 'Update own penyebarluasan informasi';
        $updateOwnPost->ruleName = $rule->name;
        $auth->add($updateOwnPost);

        $updatePost = $auth->createPermission('/penyebarluasan/update');
        $auth->addChild($updateOwnPost, $updatePost);

        $author = $auth->createPermission('Penggiat');
        $auth->addChild($author, $updateOwnPost);
    }

    public function actionAssignment()
    {
        $auth = Yii::$app->authManager;
        
        $author = $auth->createRole('Penggiat');
        $admin = $auth->createRole('SuperAdmin');

        $auth->assign($author, 2);
        $auth->assign($admin, 1);
    }

    public function actionRole()
    {
        $auth = Yii::$app->authManager;

        // Penggiat -> index/create/view
        // SuperAdmin -> {Penggiat} and update/delete -> index/create/view/update/delete

        $indexPost = $auth->createPermission('/penyebarluasan/index');
        $viewPost = $auth->createPermission('/penyebarluasan/view');
        $createPost = $auth->createPermission('/penyebarluasan/create');
        
        $updatePost = $auth->createPermission('/penyebarluasan/update');
        $deletePost = $auth->createPermission('/penyebarluasan/delete');
       
        $author = $auth->createRole('Penggiat');
        $auth->add($author);
        $auth->addChild($author, $indexPost);
        $auth->addChild($author, $viewPost);
        $auth->addChild($author, $createPost);

        $admin = $auth->createRole('SuperAdmin');
        $auth->add($admin);
        $auth->addChild($admin, $author);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $deletePost);
    }

    public function actionPermission()
    {
        $auth = Yii::$app->authManager;

        $indexPost = $auth->createPermission('/konsolidasi/index');
        $indexPost->description = 'Create laporan konsolidasi informasi';
        $auth->add($indexPost);

        $viewPost = $auth->createPermission('/konsolidasi/view');
        $viewPost->description = 'View laporan konsolidasi informasi';
        $auth->add($viewPost);

        $createPost = $auth->createPermission('/konsolidasi/create');
        $createPost->description = 'Create laporan konsolidasi informasi';
        $auth->add($createPost);

        $updatePost = $auth->createPermission('/konsolidasi/update');
        $updatePost->description = 'Update laporan konsolidasi informasi';
        $auth->add($updatePost);

        $deletePost = $auth->createPermission('/konsolidasi/delete');
        $deletePost->description = 'Delete laporan konsolidasi informasi';
        $auth->add($deletePost);
    }
}
