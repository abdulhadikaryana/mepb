<?php

namespace app\component;

use yii\rbac\Rule;

class OnlyAuthor extends Rule
{
    public $name = 'isAuthor';

    public function execute($user, $item, $params)
    {
        if(isset($params['model'])) {
            $model = $params['model'];
        } else {
            $id = \Yii::$app->request->get('id');
            if($id == null) {
                $id = 1;
            }
            $model = \Yii::$app->controller->findUserModel($id);
        }
        
        return $model->created_by == $user;
        

        // var_dump($params['model']);die();
        // var_dump($params);die();

        // return isset($params['model']) ? $params['model']->created_by == $user : false;
    }
}
