<?php
namespace wcf\system\jcoins\shop\item\type; 

use wcf\system\request\LinkHandler; 

class DownloadItem extends \wcf\system\jcoins\shop\item\type\ShopItem {
	
	public static function getIdentifer() {
		return 'download';
	}
	
	public function boughtAction(array $paramters) {
		parent::boughtAction($paramters);
		
		$paramters = $this->prepare($paramters); 
		
		if ($paramters['redirect'] == 1) {
			return array(
			    'location' => $paramters['source']
			);
		}
		
		// @TODO
		return array(
		    'location' => LinkHandler::getInstance()->getLink('JCoinsShopDownload', array('id' => $paramters['itemID']))
		);
	}
}