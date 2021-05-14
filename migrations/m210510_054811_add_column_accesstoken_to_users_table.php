<?php

use yii\db\Migration;

/**
 * Class m210510_054811_add_column_accesstoken_to_users_table
 */
class m210510_054811_add_column_accesstoken_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}',
            'access_token',
            'string');

        $this->addColumn('{{%users}}',
            'auth_key',
            'string');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'access_token');
        $this->dropColumn('{{%users}}', 'auth_key');
    }
}
