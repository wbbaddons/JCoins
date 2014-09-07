<?php
namespace wcf\data\jcoins\shop\item;

/**
 * Manages the item cache
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class JCoinsShopItemCache extends \wcf\system\SingletonFactory {
	
	public $items = array(); 
	
	public $activeItems = array(); 
	
	/**
	 * @see        wcf\system\SingletonFactory::init()
	 */
	protected function init() {
		$this->items = \wcf\system\cache\builder\JCoinsShopItemCacheBuilder::getInstance()->getData();
		$this->activeItems = \wcf\system\cache\builder\JCoinsShopItemCacheBuilder::getInstance()->getData(array('onlyActive' => true));
	}
	
	public function getItems() {
		return $this->items; 
	}
	
	public function getItem($itemID) {
		if (isset($this->items[$itemID]))
                        return $this->items[$itemID];
                
                return null;
	} 
	
	public function getActiveItems() {
		return $this->activeItems; 
	}
}