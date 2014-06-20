<?php
namespace wcf\system\jcoins\shop; 

class ShopHandler extends \wcf\system\SingletonFactory {
	
	private $items = array(); 
	
	private $identiferToItems = array(); 
	
	protected function init() {
		// first load shop items
		
		$items = \wcf\system\cache\builder\JCoinsShopItemCacheBuilder::getInstance()->getData();
		
		foreach ($items as $i) {
			if (\wcf\util\ClassUtil::isInstanceOf($i->className, 'wcf\system\jcoins\shop\item\type\IShopItem')) {
				$this->items[$i->getObjectID()] = new $i->className;
				$this->identiferToItems[$i->identifer] = $i->getObjectID(); 
			} else {
				throw new \wcf\system\exception\SystemException('"'.$i->class.'" is not an instance of \wcf\system\jcoins\shop\item\type\IShopItem'); 
			}
		}
	}
	
	/**
	 * get a shop item
	 * @param String $identifer
	 * @return \wcf\system\jcoins\shop\item\ShopItem
	 */
	public function getItemType($identifer) {
		if (isset($this->identiferToItems[$identifer]) && $this->getItemTypeByID($this->identiferToItems[$identifer]) !== null) return $this->getItemTypeByID($this->identiferToItems[$identifer]); 
		
		return null; 
	}
	
	public function getItemTypeByID($id) {
		if (isset($this->items[$id])) return $this->items[$id]; 
		
		return null; 
	}
	
	public function prepareBuy($identifer) {
		$item = self::getItemType($identifer); 
		
		$item->validate(); 
		$item->validateBuy(); 
		
		return $item->prepare(); 
	}
	
	public function buy($identifer, array $paramters = array()) {
		$item = self::getItemType($identifer);
		
		$item->validate();
		
		return $item->boughtAction($paramters); 
	}
}