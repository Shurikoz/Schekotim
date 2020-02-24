<?php

use yii\db\Migration;

/**
 * Class m200220_215925_create_photo_visit
 */
class m200220_215925_create_photo_visit extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function Up()
    {
        $this->createTable('photo_visit', [
            'id' => $this->primaryKey(),
            'visit_id' => $this->integer(),
            'photo_url' => $this->text(),
            'photo_thumbnail' => $this->text(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200220_215925_create_photo_visit cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200220_215925_create_photo_visit cannot be reverted.\n";

        return false;
    }
    */
}
