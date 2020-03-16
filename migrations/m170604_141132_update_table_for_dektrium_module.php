<?php

use yii\db\Migration;

class m170604_141132_update_table_for_dektrium_module extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'confirmed_at', $this->integer()->null());
        $this->addColumn('{{%user}}', 'unconfirmed_email', $this->string(255)->null());
        $this->addColumn('{{%user}}', 'blocked_at', $this->integer()->null());
        $this->addColumn('{{%user}}', 'registration_ip', $this->string(45));
        $this->addColumn('{{%user}}', 'flags', $this->integer()->notNull()->defaultValue(0));
        $this->addColumn('{{%user}}', 'last_login_at', $this->integer());
        

        $this->addColumn('{{%profile}}', 'public_email', $this->string(255)->null());
        $this->addColumn('{{%profile}}', 'gravatar_email', $this->string(255)->null());
        $this->addColumn('{{%profile}}', 'gravatar_id', $this->string(255)->null());
        $this->addColumn('{{%profile}}', 'location', $this->string(255)->null());
        $this->addColumn('{{%profile}}', 'website', $this->string(255)->null());
        $this->addColumn('{{%profile}}', 'bio', $this->text()->null());
        $this->addColumn('{{%profile}}', 'timezone', $this->string(40)->null());

        $this->createTable('{{%social_account}}', [
            'id'         => $this->primaryKey(),
            'user_id'    => $this->integer()->null(),
            'provider'   => $this->string()->notNull(),
            'client_id'  => $this->string()->notNull(),
            'data' => $this->text()->null(),
            'code' => $this->string(32)->null(),
            'created_at' => $this->integer()->null(),
            'email' => $this->string()->null(),
            'username' => $this->string()->null()
        ], 'ENGINE=InnoDB CHARSET=utf8');

        $this->createIndex('{{%account_unique}}', '{{%social_account}}', ['provider', 'client_id'], true);
        $this->addForeignKey('{{%fk_user_account}}', '{{%social_account}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->createIndex('{{%account_unique_code}}', '{{%social_account}}', 'code', true);

        $this->createTable('{{%token}}', [
            'user_id'    => $this->integer()->notNull(),
            'code'       => $this->string(32)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'type'       => $this->smallInteger()->notNull(),
        ], 'ENGINE=InnoDB CHARSET=utf8');

        $this->createIndex('{{%token_unique}}', '{{%token}}', ['user_id', 'code', 'type'], true);
        $this->addForeignKey('{{%fk_user_token}}', '{{%token}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%token}}');
        $this->dropTable('{{%social_account}}');
        $this->dropcolumn('{{%profile}}', 'timezone');
        $this->dropcolumn('{{%profile}}', 'bio');
        $this->dropcolumn('{{%profile}}', 'website');
        $this->dropcolumn('{{%profile}}', 'location');
        $this->dropcolumn('{{%profile}}', 'gravatar_id');
        $this->dropcolumn('{{%profile}}', 'gravatar_email');
        $this->dropcolumn('{{%profile}}', 'public_email');

        $this->dropColumn('{{%user}}', 'last_login_at');
        $this->dropcolumn('{{%user}}', 'flags');
        $this->dropcolumn('{{%user}}', 'registration_ip');
        $this->dropcolumn('{{%user}}', 'blocked_at');
        $this->dropcolumn('{{%user}}', 'unconfirmed_email');
        $this->dropcolumn('{{%user}}', 'confirmed_at');
        echo "m170604_141132_update_table_for_dektrium_module cannot be reverted.\n";
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
