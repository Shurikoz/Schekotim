<?php

use yii\db\Migration;

/**
 * Class m200502_085102_create_auth_item_child
 */
class m200502_085102_create_auth_item_child extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200502_085102_create_auth_item_child cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200502_085102_create_auth_item_child cannot be reverted.\n";

        return false;
    }
    */
}
