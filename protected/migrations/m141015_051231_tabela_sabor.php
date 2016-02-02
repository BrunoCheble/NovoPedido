<?php

class m141015_051231_tabela_sabor extends CDbMigration
{
	public $table = 'sabor';
        
	public function safeUp()
	{
            $this->createTable($this->table, array(
                'id'            => 'pk',
                'descricao'         => 'varchar(40) NOT NULL',
                'tipo_sabor'         => 'int(1) NOT NULL',
                'ingredientes'           => 'text NOT NULL',
                'foto'           => 'varchar(100)',
                'excluido'    => 'tinyint(1)',
                'ativa'      => 'tinyint(1)',
            ));
	}
        
	public function safeDown()
	{
            $this->dropTable($this->table);
	}
}