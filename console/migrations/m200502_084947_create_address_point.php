<?php

use yii\db\Migration;

/**
 * Class m200502_084947_create_address_point
 */
class m200502_084947_create_address_point extends Migration
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
        echo "m200502_084947_create_address_point cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200502_084947_create_address_point cannot be reverted.\n";

        return false;
    }
    */
}
