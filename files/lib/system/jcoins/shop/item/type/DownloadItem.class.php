<?php
namespace wcf\system\jcoins\shop\item\type; 

class DownloadItem extends \wcf\system\jcoins\shop\item\type\ShopItem {
	
	public static function getIdentifer() {
		return 'download';
	}
	
	public function boughtAction(array $paramters) {
		parent::boughtAction($paramters);
		
		if ($paramters['redirect'] == 1) {
			return array(
			    'location' => $parameters['source']
			);
		}
		
		// @TODO
		return array(
		    'showSuccess' => true
		);
	}
	
	public function prepare(array $parameters) {
		$parameters = parent::prepare($parameters); 
		
		if (!isset($parameters['source']) || !isset($parameters['redirect'])) {
			throw new \wcf\system\exception\SystemException('invalid parameters'); 
		}
	}
}