<?php

use yii\db\Migration;

class m170411_070128_create_table_profile extends Migration
{
    public function up()
    {
        $this->createTable('profile', [
            'id' => $this->primaryKey(),
            'fullname' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'birthdate' => $this->date()->notNull(),
            'gender' => "ENUM('M', 'F')",
            'photo' => "Longtext",
            'address' => $this->text(),
            'kecamatan_id' => $this->integer(),
            'kabkota_id' => $this->integer(),
            'provinsi_id' => $this->integer(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ], 'ENGINE=InnoDB CHARSET=utf8');

        // Add foreign key for table `profile`
        $this->addForeignKey(
            'fk-profile-user',
            'profile',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-profile-user', 'profile');
        $this->dropTable('profile');
        echo "m170411_070128_create_table_profile cannot be reverted.\n";
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
