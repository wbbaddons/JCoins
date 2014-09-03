<?php
namespace wcf\system\menu\page; 

/**
 * PageMenuItemProvider for JCoins-Shop.
 * 
 * @author 	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 * @subpackage	system.menu.page
 */
class JCoinsShopPageMenuItemProvider extends \wcf\system\menu\page\DefaultPageMenuItemProvider {
	
	/**
	 * Hides the button when there are no active items
	 * 
	 * @see	\wcf\system\menu\page\PageMenuItemProvider::isVisible()
	 */
	public function isVisible() {
		$items = \wcf\data\jcoins\shop\item\JCoinsShopItemCache::getInstance()->getActiveItems();
		
		if (!count($items)) {
			return false; 
		}
		
		return true;
	}
}