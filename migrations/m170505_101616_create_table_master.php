<?php

use yii\db\Migration;

class m170505_101616_create_table_master extends Migration
{
    public function up()
    {
        $this->createTable('tema', [
            'id' => $this->primaryKey(),
            'nama_tema' => $this->string(255)->notNull(),
            'status' => $this->integer(3)->defaultValue(10),
        ], 'ENGINE=InnoDB CHARSET=utf8');

        $this->createTable('topik', [
            'id' => $this->primaryKey(),
            'nama_topik' => $this->string(255)->notNull(),
            'status' => $this->integer(3)->defaultValue(10),
            'tema_id' => $this->integer()
        ], 'ENGINE=InnoDB CHARSET=utf8');

       // add foreign key for table `topic`
        $this->addForeignKey(
            'fk-topik-tema_id',
            'topik',
            'tema_id',
            'tema',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        // drops foreign key for table `topic`
        $this->dropForeignKey(
            'fk-topik-tema_id',
            'topik'
        );

        $this->dropTable('topik');
        $this->dropTable('tema');
        
        echo "m170505_101616_create_table_master cannot be reverted.\n";
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
