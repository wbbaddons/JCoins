<?php
namespace wcf\data\jcoins\shop\item\type;

use wcf\data\DatabaseObjectList;

/**
 * Represents a shopitemtype list.
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
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