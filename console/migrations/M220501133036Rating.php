<?php

namespace console\migrations;

use yii\db\Migration;

/**
 * Class M220501133036Rating
 * @package console\migrations
 */
class M220501133036Rating extends Migration
{
    private const TABLE = '{{%rating}}';

    /**
     * @return bool
     */
    public function safeUp(): bool
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'post_id' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'value' => $this->integer(1)->notNull(),
        ]);

        $this->addForeignKey('rating_post', self::TABLE, 'post_id', '{{%post}}', 'id');
        $this->addForeignKey('rating_created_by', self::TABLE, 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('rating_updated_by', self::TABLE, 'updated_by', '{{%user}}', 'id');

        $this->createIndex('rating_post_user', self::TABLE, ['post_id', 'created_by'], true);

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
