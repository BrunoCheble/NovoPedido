<?php
/**
 * Gerencia layout comum 
 */
class Layout {
	
	/**
	 * Busca o menu do topo do layout
	 * 
	 * @return array 
	 */
	public static function getMenu() {
		return array( 
			array('label'=>'Index', 'url'=>array(''), 'linkOptions' => array('class' => '')),
		);
	}
}
