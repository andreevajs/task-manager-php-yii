<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%workcosts}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%tasks}}`
 */
class m210502_151948_create_workcosts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%workcosts}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull(),
            'time' => $this->time()->notNull(),
            'comment' => $this->text(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-workcosts-user_id}}',
            '{{%workcosts}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-workcosts-user_id}}',
            '{{%workcosts}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-workcosts-task_id}}',
            '{{%workcosts}}',
            'task_id'
        );

        // add foreign key for table `{{%tasks}}`
        $this->addForeignKey(
            '{{%fk-workcosts-task_id}}',
            '{{%workcosts}}',
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
            '{{%fk-workcosts-user_id}}',
            '{{%workcosts}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-workcosts-user_id}}',
            '{{%workcosts}}'
        );

        // drops foreign key for table `{{%tasks}}`
        $this->dropForeignKey(
            '{{%fk-workcosts-task_id}}',
            '{{%workcosts}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-workcosts-task_id}}',
            '{{%workcosts}}'
        );

        $this->dropTable('{{%workcosts}}');
    }
}
