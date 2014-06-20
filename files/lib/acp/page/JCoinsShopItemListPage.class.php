<?php
namespace wcf\acp\page;

use wcf\page\SortablePage;

/**
 * Represents a list of all shop-items.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 * @subpackage	acp.page
 */
class JCoinsShopItemListPage extends SortablePage {

	/**
	 * @see	wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.jcoins.shop.item.list';

	/**
	 * @see	wcf\page\AbstractPage::$neededModules
	 */
	public $neededModules = array('MODULE_JCOINS', 'MODULE_JCOINS_SHOP');

	/**
	 * @see	wcf\page\MultipleLinkPage::$defaultSortField
	 */
	public $defaultSortField = 'showOrder';

	/**
	 * @see	wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.jcoins.shop.canManage');

	/**
	 * @see	wcf\page\MultipleLinkPage::$objectListClassName
	 */
	public $objectListClassName = 'wcf\data\jcoins\shop\item\JCoinsShopItemList';

	/**
	 * @see	wcf\page\MultipleLinkPage::$validSortFields
	 */
	public $validSortFields = array('showOrder');
}
