<?php

use yii\db\Migration;

/**
 * Class m200502_085049_create_auth_item
 */
class m200502_085049_create_auth_item extends Migration
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
        echo "m200502_085049_create_auth_item cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200502_085049_create_auth_item cannot be reverted.\n";

        return false;
    }
    */
}
