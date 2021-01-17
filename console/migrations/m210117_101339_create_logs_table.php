<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%logs}}`.
 */
class m210117_101339_create_logs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%apache_logs}}', [
            'id' => $this->primaryKey(),
            'host' => $this->string(40),
            'logname' => $this->string(40),
            'user' => $this->string(40),
            'request' => $this->text(),
            'status' => $this->smallInteger(),
            'responseBytes' => $this->integer(),
            'headerReferer' => $this->string(255),
            'headerUseragent' => $this->string(600),
            'timestamp' => $this->integer(),
            'time' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%apache_logs}}');
    }
}
