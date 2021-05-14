<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%statuses}}`.
 */
class m210502_150928_create_statuses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%statuses}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%statuses}}');
    }
}
