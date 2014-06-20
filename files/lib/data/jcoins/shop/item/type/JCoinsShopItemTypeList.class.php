<?php
namespace wcf\data\jcoins\shop\item\type;

use wcf\data\DatabaseObjectList;

/**
 * Represents a shopitemtype list.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class JCoinsShopItemTypeList extends DatabaseObjectList {

	/**
	 * @see	wcf\data\DatabaseObjectList::$className
	 */
	public $className = 'wcf\data\jcoins\shop\item\type\JCoinsShopItemType';

	/**
	 * @see	wcf\data\DatabaseObjectList::$sqlOrderBy
	 */
	public $sqlOrderBy = "jcoins_shop_item_type.itemTypeID DESC";

}