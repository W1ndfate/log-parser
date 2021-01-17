<?php

namespace api\modules\v1\controllers;

use common\models\LoginForm;
use common\models\RegisterForm;
use common\models\User;
use Yii;
use yii\rest\Controller;


class UserController extends Controller
{
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            return ['token' => User::find()->where(['username' => $model->username])->one()->auth_key];
        }

        Yii::$app->response->statusCode = 422;
        return [
            'errors' => $model->errors
        ];
    }

    public function actionRegister()
    {
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->register()) {
            return $model->user->auth_key;
        }

        Yii::$app->response->statusCode = 422;
        return [
            'errors' => $model->errors
        ];
    }
}
