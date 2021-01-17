<?php
namespace console\controllers;

use console\services\ParserService;
use yii\console\Controller;

class ParserController extends Controller
{
    public $apacheLogsDir;
    public $logFileMasks;
    public $logFormat;

    public function actionParseApache()
    {
        $parserService = new ParserService();

        $parserService->parseApacheLogs($this->apacheLogsDir, $this->logFileMasks, $this->logFormat);
    }
}
