<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%statuses}}`
 * - `{{%users}}`
 * - `{{%users}}`
 */
class m210502_151644_create_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tasks}}', [
            'id' => $this->primaryKey(),
            'creation_date' => $this->dateTime()->notNull(),
            'stop_date' => $this->dateTime(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'status_id' => $this->integer(),
            'work_cost_assumption' => $this->dateTime(),
            'author_id' => $this->integer()->notNull(),
            'executor_id' => $this->integer(),
        ]);

        // creates index for column `status_id`
        $this->createIndex(
            '{{%idx-tasks-status_id}}',
            '{{%tasks}}',
            'status_id'
        );

        // add foreign key for table `{{%statuses}}`
        $this->addForeignKey(
            '{{%fk-tasks-status_id}}',
            '{{%tasks}}',
            'status_id',
            '{{%statuses}}',
            'id',
            'CASCADE'
        );

        // creates index for column `author_id`
        $this->createIndex(
            '{{%idx-tasks-author_id}}',
            '{{%tasks}}',
            'author_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-tasks-author_id}}',
            '{{%tasks}}',
            'author_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `executor_id`
        $this->createIndex(
            '{{%idx-tasks-executor_id}}',
            '{{%tasks}}',
            'executor_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-tasks-executor_id}}',
            '{{%tasks}}',
            'executor_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%statuses}}`
        $this->dropForeignKey(
            '{{%fk-tasks-status_id}}',
            '{{%tasks}}'
        );

        // drops index for column `status_id`
        $this->dropIndex(
            '{{%idx-tasks-status_id}}',
            '{{%tasks}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-tasks-author_id}}',
            '{{%tasks}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            '{{%idx-tasks-author_id}}',
            '{{%tasks}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-tasks-executor_id}}',
            '{{%tasks}}'
        );

        // drops index for column `executor_id`
        $this->dropIndex(
            '{{%idx-tasks-executor_id}}',
            '{{%tasks}}'
        );

        $this->dropTable('{{%tasks}}');
    }
}
