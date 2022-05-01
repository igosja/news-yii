<?php

namespace console\migrations;

use yii\db\Migration;

/**
 * Class M220501132943Comment
 * @package console\migrations
 */
class M220501132943Comment extends Migration
{
    private const TABLE = '{{%comment}}';

    /**
     * @return bool
     */
    public function safeUp(): bool
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull(),
            'post_id' => $this->integer()->notNull(),
            'text' => $this->text()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('comment_post', self::TABLE, 'post_id', '{{%post}}', 'id');
        $this->addForeignKey('comment_created_by', self::TABLE, 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('comment_language_id', self::TABLE, 'language_id', '{{%language}}', 'id');
        $this->addForeignKey('comment_updated_by', self::TABLE, 'updated_by', '{{%user}}', 'id');

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
