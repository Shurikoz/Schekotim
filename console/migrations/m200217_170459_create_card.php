<?php

use yii\db\Migration;

/**
 * Class m200217_170459_create_card
 */
class m200217_170459_create_card extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function Up()
    {
        $this->createTable('card', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'number' => $this->integer()->notNull()->unique(),
            'city' => $this->string(),
            'address_point' => $this->string(),
            'doctor' => $this->string(),
            'name' => $this->string(),
            'surname' => $this->string(),
            'middle_name' => $this->string(),
            'birthday' => $this->string(),
            'description' => $this->string(),
            'created_at' => $this->string(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200217_170459_create_card cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200217_170459_create_card cannot be reverted.\n";

        return false;
    }
    */
}
