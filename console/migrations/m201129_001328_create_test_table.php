<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%test}}`.
 */
class m201129_001328_create_test_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%test}}', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull(),
            'id_center' => $this->integer()->notNull(),
            'result' => $this->tinyInteger()->unsigned()->defaultValue(0)->notNull(),
            'comments' => $this->text()->defaultValue(null),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-test-id_user',
            '{{%test}}',
            'id_user'
        );

        $this->addForeignKey(
            'fk-test-id_user',
            '{{%test}}',
            'id_user',
            '{{%user}}',
            'id',
            'RESTRICT'
        );

        $this->createIndex(
            'idx-test-id_center',
            '{{%test}}',
            'id_center'
        );

        $this->addForeignKey(
            'fk-test-id_center',
            '{{%test}}',
            'id_center',
            '{{%center}}',
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
            'fk-test-id_user',
            '{{%test}}'
        );

        $this->dropIndex(
            'idx-test-id_user',
            '{{%test}}'
        );

        $this->dropForeignKey(
            'fk-test-id_center',
            '{{%test}}'
        );

        $this->dropIndex(
            'idx-test-id_center',
            '{{%test}}'
        );

        $this->dropTable('{{%test}}');
    }
}
