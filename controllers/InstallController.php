<?php


namespace app\controllers;


use app\models\install\AppConfigModel;

class InstallController extends \yii\web\Controller
{
    public function actionWelcome(): string
    {
        $model = new AppConfigModel();
        if($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->save();
        }
        return $this->render('formAppConfig', ['model' => $model]);
    }

}