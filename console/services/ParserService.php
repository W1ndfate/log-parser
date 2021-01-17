<?php
namespace console\services;

use common\models\ApacheLog;
use Kassner\LogParser\FormatException;
use Kassner\LogParser\LogParser;
use yii\helpers\Console;
use yii\helpers\FileHelper;

class ParserService
{
    /**
     * Parse all logs files within the $apacheLogsDir, writes them to db and delete each file after
     * @param string $apacheLogsDir working dir
     * @param array $logFileMasks mask for the log files
     * @param string $logFormat format of the Apache log files
     * @throws FormatException
     */
    public function parseApacheLogs(string $apacheLogsDir, array $logFileMasks, string $logFormat)
    {
        $files = FileHelper::findFiles($apacheLogsDir, ['only' => $logFileMasks]);

        $parser = new LogParser();

        $parser->setFormat($logFormat);

        foreach ($files as $file) {
            Console::output(Console::renderColoredString('%yParsing file ' . $file));

            $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $totalCount = count($lines);
            foreach ($lines as $key => $line) {
                $entry = $parser->parse($line);
                $apacheLog = ApacheLog::createFromParserArray($entry);
                $apacheLog->save();
                Console::output($key . '/' . $totalCount);
            }
            FileHelper::unlink($file);
        }
        Console::output(Console::renderColoredString('%gParsing complete!'));
    }
}
