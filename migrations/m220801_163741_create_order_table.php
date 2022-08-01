<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m220801_163741_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer(),
            'user_id' => $this->integer(),
            'amount' => $this->integer()
        ]);

        $this->addForeignKey('id_event', '{{%order}}', 'event_id', '{{%event}}', 'id');
        $this->addForeignKey('id_user', '{{%order}}', 'user_id', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('id_event', '{{%order}}');
        $this->dropForeignKey('id_user', '{{%order}}');
        $this->dropTable('{{%order}}');
    }
}
