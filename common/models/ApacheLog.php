<?php
namespace common\models;

use Kassner\LogParser\LogEntryInterface;
use yii\db\ActiveRecord;

/**
 * ApacheLog model
 *
 * @property integer $id
 * @property string $host
 * @property string $logname
 * @property string $user
 * @property string $request
 * @property integer $status
 * @property integer $responseBytes
 * @property string $headerReferer
 * @property string $headerUseragent
 * @property integer $timestamp
 * @property \DateTime $time
 */
class ApacheLog extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%apache_logs}}';
    }

    public static function createFromParserArray(LogEntryInterface $logEntry)
    {
        $apacheLog = new self();

        $apacheLog->host = $logEntry->host ?? null;
        $apacheLog->logname = $logEntry->logname ?? null;
        $apacheLog->user = $logEntry->user ?? null;
        $apacheLog->request = $logEntry->request ?? null;
        $apacheLog->status = $logEntry->status ?? null;
        $apacheLog->responseBytes = $logEntry->responseBytes ?? null;
        $apacheLog->headerReferer = $logEntry->HeaderReferer ?? null;
        $apacheLog->headerUseragent = $logEntry->HeaderUseragent ?? null;
        $apacheLog->timestamp = $logEntry->stamp ?? null;
        $apacheLog->time = $logEntry->time ?? null;

        return $apacheLog;
    }

    public static function findWithParams($count, $host, $timeFrom, $timeTo)
    {
        $query = ApacheLog::find();

        if(isset($count))
            $query->limit($count);

        if(isset($host))
            $query->andWhere(['host' => $host]);

        if(isset($timeFrom))
            $query->andWhere(['>', 'timestamp', $timeFrom]);

        if(isset($timeTo))
            $query->andWhere(['<', 'timestamp', $timeTo]);

        return $query->all();
    }
}
