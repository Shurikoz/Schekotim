<?php

use yii\db\Migration;

/**
 * Class m200502_085312_create_photo
 */
class m200502_085312_create_photo extends Migration
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
        echo "m200502_085312_create_photo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200502_085312_create_photo cannot be reverted.\n";

        return false;
    }
    */
}
