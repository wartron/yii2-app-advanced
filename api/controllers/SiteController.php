<?php
namespace api\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * Site controller
 */
class SiteController extends Controller
{

    public function actionIndex()
    {
        $this->redirect('http://yii2team.dev/');
    }

}
