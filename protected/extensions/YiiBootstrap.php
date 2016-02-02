<?php
Yii::import('bootstrap.components.Bootstrap');

class YiiBootstrap extends Bootstrap {
	
	public function registerFixCss() {
		$filename = 'fix_bootstrap.css';
		Yii::app()->clientScript->registerCssFile($this->getAssetsUrl().'/css/'.$filename,'print, screen');
	}

	/**
	 * Registers all Bootstrap CSS.
	 * @since 2.0.0
	 */
	public function registerAllCss()
	{
		parent::registerAllCss();
		
		$this->registerFixCss();
	}
	
	/**
	 * Registers the Yii-specific CSS missing from Bootstrap.
	 * @since 0.9.11
	 */
	public function registerYiiCss()
	{
		Yii::app()->clientScript->registerCssFile($this->getAssetsUrl().'/css/yii.css','print, screen');
	}
	
	/**
	 * Registers the Bootstrap responsive CSS.
	 * @since 0.9.8
	 */
	public function registerResponsiveCss()
	{
		/** @var CClientScript $cs */
		$cs = Yii::app()->getClientScript();
		$cs->registerMetaTag('width=device-width, initial-scale=1.0', 'viewport');
		$filename = YII_DEBUG ? 'bootstrap-responsive.css' : 'bootstrap-responsive.min.css';
		$cs->registerCssFile($this->getAssetsUrl().'/css/'.$filename,'print, screen');
	}
}