<?php
namespace wcf\data\user\group\premium;

/**
 * Manages the premium cache
 * 
 * @author         Joshua Rüsweg
 * @package        de.joshsboard.jcoins
 */
class JCoinsShopItemCache extends \wcf\system\SingletonFactory {
	
	public $items = array(); 
	
	/**
	 * @see        wcf\system\SingletonFactory::init()
	 */
	protected function init() {
		$this->items = \wcf\system\cache\builder\JCoinsShopItemCacheBuilder::getInstance()->getData(); 
	}
	
	public function getItems() {
		return $this->items; 
	}
	
	public function getItem($itemID) {
		if (isset($this->items[$itemID]))
                        return $this->items[$itemID];
                
                return null;
	} 
}