<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%faq}}`.
 */
class m201128_200549_create_faq_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%faq_categories}}', [
            'id' => $this->primaryKey(),
            'category' => $this->string()->notNull(),
        ]);

        $this->createTable('{{%faq}}', [
            'id' => $this->primaryKey(),
            'id_category' => $this->integer()->notNull(),
            'question' => $this->string()->notNull(),
            'answer' => $this->string()->notNull(),
        ]);

        $this->createIndex(
            'idx-faq-id_category',
            '{{%faq}}',
            'id_category'
        );

        $this->addForeignKey(
            'fk-faq-id_category',
            '{{%faq}}',
            'id_category',
            '{{%faq_categories}}',
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
            'fk-faq-id_category',
            '{{%faq}}'
        );

        $this->dropIndex(
            'idx-faq-id_category',
            '{{%faq}}'
        );

        $this->dropTable('{{%faq}}');

        $this->dropTable('{{%faq_categories}}');
    }
}
