<?php

namespace api\modules\v1\controllers;

use common\models\ApacheLog;
use yii\rest\Controller;
use yii\filters\ContentNegotiator;
use yii\web\HttpException;
use yii\web\Response;
use yii\filters\auth\HttpBearerAuth;

class ApacheLogsController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }

    public function actionGet($count = 100, $host = null, $timeFrom = null, $timeTo = null)
    {
        $logs = ApacheLog::findWithParams($count, $host, (int)$timeFrom, (int)$timeTo);

        return ['responseData' => $logs ?? []];
    }
}
