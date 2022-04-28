<?php
declare(strict_types=1);

namespace console\migrations;

use yii\db\Migration;

/**
 * Class M220428162707User
 * @package console\migrations
 */
class M220428162707User extends Migration
{
    private const TABLE = '{{%user}}';

    /**
     * @return bool
     */
    public function safeUp(): bool
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'auth_key' => $this->string(32)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'status' => $this->integer(1)->notNull()->defaultValue(1),
            'updated_at' => $this->integer()->notNull(),
            'username' => $this->string()->notNull()->unique(),
            'user_role' => $this->integer()->defaultValue(1),
            'verification_token' => $this->string()->defaultValue(null),
        ]);

        $this->insert(self::TABLE, [
            'id' => 1,
            'auth_key' => 'pXJTl3Xq5cYo717-sVz8k4M0YXukl-Wz',
            'created_at' => time(),
            'email' => 'igosja@ukr.net',
            'password_hash' => '$2y$13$p9f2Cm5jne5nyJyYskrC..OoGFpmacK3J0zrzgeD0vJrd57H4Xy8S',
            'status' => 1,
            'updated_at' => time(),
            'username' => 'igosja',
            'user_role' => 9,
            'verification_token' => 'rvnCrJaW5TCb8fQ3P36El4YLHAFYeS5Z_1642608157',
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
