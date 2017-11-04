<?php

use yii\db\Migration;

/**
 * Class m171103_125024_create_codes
 */
class m171103_125024_create_codes extends Migration
{
    private $_table = 'codes';
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->_table, [
            'id' => $this->primaryKey()->notNull(),
            'name' => $this->string()->notNull(),
            'customer_reward' => $this->float()->notNull()->defaultValue(0),
            'status' => $this->smallInteger()->defaultValue(1),
            'tariff_zone' => $this->string(),
            'start_date' => $this->date(),
            'end_date' => $this->date()
        ], $tableOptions);
    }


    public function safeDown()
    {
        $this->dropTable($this->_table);
    }
}
