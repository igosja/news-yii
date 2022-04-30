<?php

namespace console\migrations;

use yii\db\Migration;

/**
 * Class M220430095502Resize
 * @package console\migrations
 */
class M220430095502Resize extends Migration
{
    private const TABLE = '{{%resize}}';

    /**
     * @return bool
     */
    public function safeUp(): bool
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'height' => $this->integer()->notNull(),
            'image_id' => $this->integer()->notNull(),
            'path' => $this->string()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'width' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('resize_image', self::TABLE, 'image_id', '{{%image}}', 'id');

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
