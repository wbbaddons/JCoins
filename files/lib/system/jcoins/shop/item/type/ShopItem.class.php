<?php
namespace wcf\system\jcoins\shop\item\type; 

use wcf\system\event\EventHandler; 
use wcf\system\WCF; 
use wcf\system\exception\PermissionDeniedException; 
use wcf\system\exception\SystemException; 

/**
 * 
 */
abstract class ShopItem implements \wcf\system\jcoins\shop\item\type\IShopItem {
	
	public $itemType = null; 
	
	public function __construct($itemType = null) {
		
		if (!($itemType instanceof \wcf\data\jcoins\shop\item\type\JCoinsShopItemType)) {
			$this->itemType = \wcf\data\jcoins\shop\item\type\JCoinsShopItemType::getByIdentifer($this->getIdentifer()); 
		} else {
			$this->itemType = $itemType; 
		}
		
		EventHandler::getInstance()->fireAction($this, 'inited');
	}
	
	/**
	 * @see \wcf\system\jcoins\shop\item\IShopItem::buy()
	 */
	public function buy(array $paramters) {
		EventHandler::getInstance()->fireAction($this, 'bought');
	}
	
	/**
	 * @see \wcf\system\jcoins\shop\item\IShopItem::boughtAction()
	 */
	public function boughtAction(array $paramters) {
		EventHandler::getInstance()->fireAction($this, 'boughtAction');
		
		// aviable types
		/*
		 * 'location' => http://tedmosbyisajerk.com/ -> redirect to this location  ; if 'location' is http://www.weddingbridemovie.com/ he redirect to http://www.weddingbridemovie.com/ ;)
		 * 'showSuccess' =>  true?!false -> show the js success
		 */
		
		return array(
		    'showSuccess' => true
		); 
	}
	
	/**
	 * @see \wcf\system\jcoins\shop\item\IShopItem::prepare()
	 */
	public function prepare(array $parameters) {
		EventHandler::getInstance()->fireAction($this, 'prepare');
		
		foreach ($this->getParameters() as $param) {
			if (!isset($parameters[$param['parameterID']])) {
				throw new SystemException('parameter "'.$param['name'].'" is missing');
			}
			
			$parameters[$param['name']] = $parameters[$param['parameterID']];
		}
		
		return $parameters; 
	}
	
	public function isMultiple() {
		return $this->itemType->isMulitple; 
	}
	
	public function validateBuy() {
		if (WCF::getUser()->userID == 0) {
			throw new PermissionDeniedException(); 
		}
		
		if (!MODULE_JCOINS || !MODULE_JCOINS_SHOP) {
			throw new PermissionDeniedException(); 
		}
		
		EventHandler::getInstance()->fireAction($this, 'validate');
	}
	
	public function getParameters() {
		return $this->itemType->getParameters(); 
	}
}