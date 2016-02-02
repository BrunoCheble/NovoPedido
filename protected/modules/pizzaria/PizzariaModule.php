<?php

class PizzariaModule extends CWebModule {

	private $_assetsUrl;

	/**
	 * @return string the base URL that contains all published asset files of this module.
	 */
	public function getAssetsUrl() {
		if ($this->_assetsUrl === null)
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('pizzaria.assets'), true, -1, true);
		return $this->_assetsUrl;
	}

	/**
	 * @param string the base URL that contains all published asset files of this module.
	 */
	public function setAssetsUrl($value) {
		$this->_assetsUrl = $value;
	}

	public function registerCss($file, $media = 'all') {
		$href = $this->getAssetsUrl() . '/css/' . $file;
		return '<link rel="stylesheet" type="text/css" href="' . $href . '" media="' . $media . '" />';
	}
	
	public function registerScript($file, $media = 'all') {
		$href = $this->getAssetsUrl() . '/js/' . $file;
		//return '<script src="' . $href . '" type="text/javascript"></script>';
		Yii::app()->clientScript->registerScriptFile($href);
	}

	public function registerImage($file) {
		return $this->getAssetsUrl() . '/images/' . $file;
	}
        
        public function registerImageProtected($file){
                return Yii::app()->assetManager->publish(Yii::app()->basePath.'/assets/images/'.$file);
        }
        
        public function getUrlBaseImage(){
                return Yii::app()->assetManager->publish(Yii::app()->basePath.'/assets/images/', true, -1, true);
        }
}
