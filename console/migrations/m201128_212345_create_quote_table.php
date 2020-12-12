<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quote}}`.
 */
class m201128_212345_create_quote_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%quote}}', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull(),
            'id_expert' => $this->integer()->defaultValue(null),
            'status' => $this->tinyInteger()->unsigned()->defaultValue(0)->notNull(),
            'message' => $this->text(),
            'created_at' => $this->integer(11)->unsigned()->notNull(),
            'updated_at' => $this->integer(11)->unsigned()->defaultValue(null),
        ]);

        $this->createIndex(
            'idx-quote-id_user',
            '{{%quote}}',
            'id_user'
        );

        $this->addForeignKey(
            'fk-quote-id_user',
            '{{%quote}}',
            'id_user',
            '{{%user}}',
            'id',
            'RESTRICT'
        );

        $this->createIndex(
            'idx-quote-id_expert',
            '{{%quote}}',
            'id_expert'
        );

        $this->addForeignKey(
            'fk-quote-id_expert',
            '{{%quote}}',
            'id_expert',
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
            'fk-quote-id_user',
            '{{%quote}}'
        );

        $this->dropIndex(
            'idx-quote-id_user',
            '{{%quote}}'
        );

        $this->dropForeignKey(
            'fk-quote-id_expert',
            '{{%quote}}'
        );

        $this->dropIndex(
            'idx-quote-id_expert',
            '{{%quote}}'
        );

        $this->dropTable('{{%quotes}}');
    }
}
