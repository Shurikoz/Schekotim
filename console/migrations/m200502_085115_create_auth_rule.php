<?php

use yii\db\Migration;

/**
 * Class m200502_085115_create_auth_rule
 */
class m200502_085115_create_auth_rule extends Migration
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
        echo "m200502_085115_create_auth_rule cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200502_085115_create_auth_rule cannot be reverted.\n";

        return false;
    }
    */
}
