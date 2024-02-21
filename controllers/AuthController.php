<?php

namespace app\controllers;
use Yii;
use app\models\Users;
use app\models\LoginForm;

class AuthController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionRegister()
    {
        $model = new Users();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new Users();
            $user->name = $model->name;
            $user->email = $model->email;
            $user->setPassword($model->password);
            $user->role = $model->role;
           
            if($user->save()){
                Yii::$app->session->setFlash('success', 'Registration successful. You can now log in.');
                return $this->redirect(['auth/login']);
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }
    public function actionLogin()
    {
        // Check if the user is already logged in
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm(); // Assuming you have a LoginForm model

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // User login is successful
            $user = Users::findOne(['email' => $model->email]);

            // Redirect users based on their roles
            if ($user->role === 'admin') {
                return $this->redirect(['admin/dashboard']); // Redirect admin to admin dashboard
            } elseif ($user->role === 'user') {
                return $this->redirect(['user/dashboard']); // Redirect user to user dashboard
            } elseif ($user->role === 'manager') {
                return $this->redirect(['manager/dashboard']); // Redirect manager to manager dashboard
            }
        }

        // Display the login form
        return $this->render('login', [
            'model' => $model,
        ]);
    }

}
