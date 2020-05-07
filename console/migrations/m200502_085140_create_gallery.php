<?php

use yii\db\Migration;

/**
 * Class m200502_085140_create_gallery
 */
class m200502_085140_create_gallery extends Migration
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
        echo "m200502_085140_create_gallery cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200502_085140_create_gallery cannot be reverted.\n";

        return false;
    }
    */
}
