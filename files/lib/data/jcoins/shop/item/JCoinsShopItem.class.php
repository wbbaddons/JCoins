<?php
namespace wcf\data\jcoins\shop\item;

use wcf\data\DatabaseObject;

/**
 * Represents a shop item type. 
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class JCoinsShopItem extends DatabaseObject implements \wcf\system\request\IRouteController {

	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'jcoins_shop_item';

	/**
	 * @see	\wcf\data\DatabaseObject::$databaseIndexName
	 */
	protected static $databaseTableIndexName = 'itemID';
	
	/**
	 * get the shop-item-type
	 */
	public function getType() {
		return \wcf\system\jcoins\shop\ShopHandler::getInstance()->getItemTypeByID($this->itemType); 
	}
	
	/**
	 * @see \wcf\data\ITitledObject::getTitle()
	 */
	public function getTitle() {
		return $this->name; 
	}
}
