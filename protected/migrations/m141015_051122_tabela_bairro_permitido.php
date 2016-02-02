<?php

class m141015_051122_tabela_bairro_permitido extends CDbMigration
{
	public $table = 'bairro_permitido';
        
	public function safeUp()
	{
            $this->createTable($this->table, array(
                'id'            => 'pk',
                'descricao'         => 'varchar(50) NOT NULL',
            ));
	}

	public function safeDown()
	{
            $this->dropTable($this->table);
	}
}