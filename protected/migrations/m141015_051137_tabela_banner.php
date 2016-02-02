<?php

class m141015_051137_tabela_banner extends CDbMigration
{
	public $table = 'banner';
        
	public function safeUp()
	{
            $this->createTable($this->table, array(
                'id'            => 'pk',
                'imagem'         => 'varchar(255) NOT NULL',
                'ativo'      => 'tinyint(1)',
            ));
	}

	public function safeDown()
	{
            $this->dropTable($this->table);
	}
}