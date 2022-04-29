<?php

namespace console\migrations;

use yii\db\Migration;

/**
 * Class M220429175646Category
 * @package console\migrations
 */
class M220429175646Category extends Migration
{
    private const TABLE = '{{%category}}';

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function safeUp(): bool
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'is_active' => $this->boolean()->defaultValue(false),
            'name' => $this->string()->notNull(),
            'translation' => $this->json(),
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
