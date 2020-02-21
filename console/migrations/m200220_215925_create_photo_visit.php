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

            'photo_url' => $this->string(),
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
