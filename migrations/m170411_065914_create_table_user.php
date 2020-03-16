<?php

use yii\db\Migration;

class m170411_065914_create_table_user extends Migration
{
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(100)->notNull()->unique(),
            'email' => $this->string(150)->notNull()->unique(),
            'password_hash' => $this->string(255),
            'auth_key' => $this->string(255),
            'password_reset_token' => $this->string(255),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'status' => $this->integer(2)->defaultValue(10)
        ], 'ENGINE=InnoDB CHARSET=utf8');

        $this->insert('user', [
            'username' => 'admin',
            'email' => 'admin@localhost.dev',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('admin212'),
            'created_at' => date('U'),
            'updated_at' => date('U')
        ]);
    }

    public function down()
    {
        $this->dropTable('user');
        echo "m170411_065914_create_table_user cannot be reverted.\n";
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
