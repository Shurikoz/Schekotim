<?php

use yii\db\Migration;

/**
 * Class m200502_085129_create_city
 */
class m200502_085129_create_city extends Migration
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
        echo "m200502_085129_create_city cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200502_085129_create_city cannot be reverted.\n";

        return false;
    }
    */
}
