<?php

use yii\db\Migration;

/**
 * Class m200217_205129_create_visit
 */
class m200217_205129_create_visit extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function Up()
    {
        $this->createTable('visit', [
            'id' => $this->primaryKey(),
            'card_id' => $this->integer(),
            'city' => $this->string(),
            'address_point' => $this->string(),
            'reason' => $this->integer(),
            'manipulation' => $this->string(),
            'recommendation' => $this->string(),
            'next_visit_from' => $this->integer()->notNull(),
            'next_visit_by' => $this->integer()->notNull(),
            'has_come' => $this->string(),
            'description' => $this->string(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200217_205129_create_visit cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200217_205129_create_visit cannot be reverted.\n";

        return false;
    }
    */
}
