<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%center}}`.
 */
class m201129_001323_create_center_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%center}}', [
            'id' => $this->primaryKey(),
            'id_provincia' => $this->integer()->notNull(),
            'poblacion' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%center}}');
    }
}
