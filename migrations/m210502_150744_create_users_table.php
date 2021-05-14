<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m210502_150744_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'login' => $this->string(100)->notNull(),
            'email' => $this->string(200)->notNull(),
            'password' => $this->string(256)->notNull(),
            'creation_date' => $this->date(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
