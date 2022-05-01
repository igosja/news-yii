<?php

namespace console\migrations;

use yii\db\Migration;

/**
 * Class M220430095504Post
 * @package console\migrations
 */
class M220430095504Post extends Migration
{
    private const TABLE = '{{%post}}';

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function safeUp(): bool
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'image_id' => $this->integer(),
            'is_active' => $this->boolean()->defaultValue(false),
            'name' => $this->string()->notNull(),
            'translation_text' => $this->json(),
            'translation_title' => $this->json(),
            'updated_at' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'url' => $this->string()->notNull()->unique(),
            'views' => $this->integer()->defaultValue(0),
        ]);

        $this->addForeignKey('post_category', self::TABLE, 'category_id', '{{%category}}', 'id');
        $this->addForeignKey('post_created_by', self::TABLE, 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('post_image_id', self::TABLE, 'image_id', '{{%image}}', 'id');
        $this->addForeignKey('post_updated_by', self::TABLE, 'updated_by', '{{%user}}', 'id');

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
