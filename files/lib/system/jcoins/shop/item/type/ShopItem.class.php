<?php
namespace wcf\system\jcoins\shop\item\type; 

use wcf\system\event\EventHandler; 
use wcf\system\WCF; 
use wcf\system\exception\PermissionDeniedException; 

/**
 * 
 */
abstract class ShopItem implements wcf\system\jcoins\shop\item\type\IShopItem {
	
	/**
	 * can you buy the item more than once?
	 * @var boolean 
	 */
	public $multipleItem = true; 
	
	public $itemType = null; 
	
	public function __construct($itemType = null) {
		
		if (!$itemType instanceof \wcf\data\jcoins\shop\item\type\JCoinsShopItemType) {
			$this->itemType = \wcf\data\jcoins\shop\item\type\JCoinsShopItemType::getByIdentifer($this->getIdentifer()); 
		} else {
			$this->itemType = $itemType; 
		}
		
		EventHandler::getInstance()->fireAction($this, 'inited');
	}
	
	/**
	 * @see \wcf\system\jcoins\shop\item\IShopItem::boughtAction()
	 */
	public function boughtAction(array $paramters) {
		EventHandler::getInstance()->fireAction($this, 'bought');
	}
	
	/**
	 * @see \wcf\system\jcoins\shop\item\IShopItem::prepare()
	 */
	public function prepare() {
		EventHandler::getInstance()->fireAction($this, 'prepare');
		
		return array(); 
	}
	
	/**
	 * @see \wcf\system\jcoins\shop\item\IShopItem::isPurchasable()
	 */
	public function isPurchasable() {
		return false; // TODO
	}
	
	public function isMultiple() {
		return $this->itemType->isMulitple; 
	}
	
	public function validate() {
		EventHandler::getInstance()->fireAction($this, 'validate');
		
		if (WCF::getUser()->userID == 0) {
			throw new PermissionDeniedException(); 
		}
		
		if (!MODULE_JCOINS) {
			throw new PermissionDeniedException(); 
		}
	}
	
	public function validateBuy() {
		EventHandler::getInstance()->fireAction($this, 'validateBuy');
	}
}