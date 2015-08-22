<?php

namespace api\modules\v1\controllers;

use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\web\ForbiddenHttpException;


class BaseController extends ActiveController
{
    public $rbacPermission = null;

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
        ];
        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $modelClass = $this->modelClass;
        $query =  $modelClass::find()
                ->where(['created_by' => \Yii::$app->user->id]);
        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        //we filter by created_by in prepareDataProvider for the index view
        if($action == "index")
            return true;
        if($action == "create")
            return true;

        if(!$this->rbacPermission)
            return true;

        if ( \Yii::$app->user->can($this->rbacPermission, ['model' => $model]) )
            return $model;
        else
            throw new ForbiddenHttpException();
    }

}