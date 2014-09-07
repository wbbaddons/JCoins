<?php
namespace wcf\system\jcoins\shop\item\type; 

use wcf\system\request\LinkHandler; 

/**
 * Download Shop Item type
 * 
 * @author 	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class DownloadItem extends \wcf\system\jcoins\shop\item\type\ShopItem {
	
	/**
	 * @see wcf\system\jcoins\shop\item\type\IShopItem::getIdentifer()
	 */
	public static function getIdentifer() {
		return 'download';
	}
	
	/**
	 * @see \wcf\system\jcoins\shop\item\type\IShopItem::boughtAction()
	 */
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