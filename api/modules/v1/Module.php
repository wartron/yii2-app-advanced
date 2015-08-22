<?php

namespace api\modules\v1;

use yii\base\Module as BaseModule;
use yii\base\InvalidParamException;


/**
 * Class Module
 */
class Module extends BaseModule
{
    const VERSION = '0.0.1-dev';

    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }
}
