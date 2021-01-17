<?php
namespace console\controllers;

use console\services\ParserService;
use Yii;
use yii\console\Controller;

class ParserController extends Controller
{
    public function actionParseApache()
    {
        $parserService = new ParserService();

        $parserService->parseApacheLogs(
            Yii::$app->params['apacheParser']['workdir'],
            Yii::$app->params['apacheParser']['logFileMasks'],
            Yii::$app->params['apacheParser']['logFormat']);
    }
}
