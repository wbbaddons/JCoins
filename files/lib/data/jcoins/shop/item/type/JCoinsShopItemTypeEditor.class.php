<?php
namespace wcf\data\jcoins\shop\item\type; 

use wcf\data\DatabaseObjectEditor;

/**
 * Provides functions to edit premium groups.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class JCoinsShopItemTypeEditor extends DatabaseObjectEditor implements \wcf\data\IEditableCachedObject {

	/**
	 * @see	\wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'wcf\data\jcoins\shop\item\type\JCoinsShopItemType';

	/**
	 * clears the shopitemtype cache
	 */
	public static function resetCache() {
		\wcf\system\cache\builder\JCoinsShopItemCacheBuilder::getInstance()->reset(); 
	}
	
}
