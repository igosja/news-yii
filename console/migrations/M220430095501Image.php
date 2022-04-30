<?php

namespace console\migrations;

use yii\db\Migration;

/**
 * Class M220430095501Image
 * @package console\migrations
 */
class M220430095501Image extends Migration
{
    private const TABLE = '{{%image}}';

    /**
     * @return bool
     */
    public function safeUp(): bool
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'path' => $this->string()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        return true;
    }

    /**
     * @return bool
     */
    public function safeDown(): bool
    {
        $this->dropTable(self::TABLE);

        return true;
    }
}
