<?php


namespace app\controllers;


use yii\web\ErrorAction;
use yii\captcha\CaptchaAction;

class SiteController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    public function actionHome() : string{
        //TODO: render start Page
        return "site/home";
    }


}