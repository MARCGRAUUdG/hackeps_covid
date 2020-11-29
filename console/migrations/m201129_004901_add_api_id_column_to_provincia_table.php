<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%provincia}}`.
 */
class m201129_004901_add_api_id_column_to_provincia_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%provincia}}', 'api_id', $this->string()->notNull()->defaultValue(''));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%provincia}}', 'api_id');
    }
}
