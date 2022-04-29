<?php
declare(strict_types=1);

namespace console\migrations;

use yii\db\Migration;

/**
 * Class M220429110333Language
 * @package console\migrations
 */
class M220429110333Language extends Migration
{
    private const TABLE = '{{%language}}';

    /**
     * @return bool
     */
    public function safeUp(): bool
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'code' => $this->char(2)->unique(),
            'created_at' => $this->integer()->notNull(),
            'is_active' => $this->boolean()->defaultValue(false),
            'name' => $this->string()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->batchInsert(
            self::TABLE,
            ['code', 'created_at', 'is_active', 'name', 'updated_at'],
            [
                ['uk', time(), true, 'Українська', time()],
                ['ru', time(), true, 'Русский', time()],
                ['en', time(), false, 'English', time()],
            ]
        );

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
