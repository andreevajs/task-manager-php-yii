<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task_observers}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%tasks}}`
 */
class m210502_152449_create_task_observers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task_observers}}', [
            'user_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('task_observers_pk', '{{%task_observers}}', ['user_id', 'task_id']);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-task_observers-user_id}}',
            '{{%task_observers}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-task_observers-user_id}}',
            '{{%task_observers}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-task_observers-task_id}}',
            '{{%task_observers}}',
            'task_id'
        );

        // add foreign key for table `{{%tasks}}`
        $this->addForeignKey(
            '{{%fk-task_observers-task_id}}',
            '{{%task_observers}}',
            'task_id',
            '{{%tasks}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-task_observers-user_id}}',
            '{{%task_observers}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-task_observers-user_id}}',
            '{{%task_observers}}'
        );

        // drops foreign key for table `{{%tasks}}`
        $this->dropForeignKey(
            '{{%fk-task_observers-task_id}}',
            '{{%task_observers}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-task_observers-task_id}}',
            '{{%task_observers}}'
        );

        $this->dropTable('{{%task_observers}}');
    }
}
