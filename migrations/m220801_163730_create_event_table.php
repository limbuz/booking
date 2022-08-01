<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%event}}`.
 */
class m220801_163730_create_event_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%event}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'description' => $this->string(500),
            'tickets' => $this->integer(),
            'image' => $this->binary(),
            'price' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%event}}');
    }
}
