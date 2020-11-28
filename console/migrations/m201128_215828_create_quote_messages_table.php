<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quote_messages}}`.
 */
class m201128_215828_create_quote_messages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%quote_messages}}', [
            'id' => $this->primaryKey(),
            'id_quote' => $this->integer()->notNull(),
            'id_user' => $this->integer()->notNull(),
            'message' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-quote_messages-id_quote',
            '{{%quote_messages}}',
            'id_quote'
        );

        $this->addForeignKey(
            'fk-quote_messages-id_quote',
            '{{%quote_messages}}',
            'id_quote',
            '{{%quote}}',
            'id',
            'RESTRICT'
        );

        $this->createIndex(
            'idx-quote_messages-id_user',
            '{{%quote_messages}}',
            'id_quote'
        );

        $this->addForeignKey(
            'fk-quote_messages-id_user',
            '{{%quote_messages}}',
            'id_user',
            '{{%user}}',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-quote_messages-id_quote',
            '{{%quote_messages}}'
        );

        $this->dropIndex(
            'idx-quote_messages-id_quote',
            '{{%quote_messages}}'
        );

        $this->dropForeignKey(
            'fk-quote_messages-id_user',
            '{{%quote_messages}}'
        );

        $this->dropIndex(
            'idx-quote_messages-id_user',
            '{{%quote_messages}}'
        );

        $this->dropTable('{{%quote_messages}}');
    }
}
