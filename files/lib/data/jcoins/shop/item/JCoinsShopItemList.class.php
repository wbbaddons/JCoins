<?php
namespace wcf\data\jcoins\shop\item;

use wcf\data\DatabaseObjectList;

/**
 * Represents a shopitem list.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class JCoinsShopItemList extends DatabaseObjectList {

	/**
	 * @see	wcf\data\DatabaseObjectList::$className
	 */
	public $className = 'wcf\data\jcoins\shop\item\JCoinsShopItem';

	/**
	 * @see	wcf\data\DatabaseObjectList::$sqlOrderBy
	 */
	public $sqlOrderBy = "jcoins_shop_item.position ASC";

}