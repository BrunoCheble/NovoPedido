<?php

class m141015_051146_tabela_feedback extends CDbMigration
{
	public $table = 'feedback';
        
	public function safeUp()
	{
            $this->createTable($this->table, array(
                'id'            => 'pk',
                'nome'         => 'varchar(45)',
                'tipo'         => 'varchar(45) NOT NULL',
                'mensagem'           => 'varchar(255) NOT NULL',
                'data_hora' => 'timestamp default now()',
            ));
	}

	public function safeDown()
	{
            $this->dropTable($this->table);
	}
}