<?php
/**
 *SocialShareButton.php
 *
 * @author Rohit Suthar <rohit.suthar@gmail.com>
 * @copyright 2014 Rohit Suthar
 * @package SocialShareButton
 * @version 1.0
 */

class SocialShareButton extends CInputWidget
{
	
	/**
	 * @var string box alignment - horizontal, vertical
	 */
	public $style='horizontal';
	
	
	/**
	 * @var string twitter username - rohisuthar
	 */
	public $data_via='';


	/**
	 * @var array available social media share buttons 
	 * like - facebook, googleplus, linkedin, twitter
	 */
	
	public $networks = array('facebook','googleplus','linkedin','twitter');


	/**
	 * The extension initialisation
	 *
	 * @return nothing
	 */

	public function init()
	{
		self::renderSocial();
	}


	/**
	 * Render social extension
	 *
	 * @return nothing
	 */
	private function renderSocial(){
		$rendered = '';
		foreach($this->networks as $params)
			$rendered .= $this->render($params);
		echo $this->render('share', array('rendered'=>$rendered));
	}
}

?>
