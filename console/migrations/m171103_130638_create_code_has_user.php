<?php

use yii\db\Migration;

/**
 * Class m171103_130638_create_code_has_user
 */
class m171103_130638_create_code_has_user extends Migration
{
    private $_table = 'code_has_user';

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->_table, [
            'id' => $this->primaryKey()->notNull(),
            'code_id' => $this->integer()->notNull(),
            'user_token' => $this->string()->notNull()
        ], $tableOptions);

        $this->addForeignKey('code_has_user_to_code', $this->_table, 'code_id', 'codes', 'id', 'CASCADE', 'CASCADE');
    }


    public function safeDown()
    {
        $this->dropForeignKey('code_has_user_to_code', $this->_table);

        $this->dropTable($this->_table);
    }
}
