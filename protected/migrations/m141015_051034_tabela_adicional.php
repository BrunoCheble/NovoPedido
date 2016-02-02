<?php

class m141015_051034_tabela_adicional extends CDbMigration
{
	public $table = 'adicional';
        
	public function safeUp()
	{
            $this->createTable($this->table, array(
                'id'            => 'pk',
                'descricao'         => 'varchar(50) NOT NULL',
                'foto'         => 'varchar(100)',
                'ativa'           => 'tinyint(1)',
                'excluida'      => 'tinyint(1)',
            ));
	}

	public function safeDown()
	{
            $this->dropTable($this->table);
	}
        
        
}