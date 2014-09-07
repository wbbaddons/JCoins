<?php
namespace wcf\system\cache\builder;


/**
 * Caches the shop items
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 * @subpackage	system.cache.builder
 */
class JCoinsShopItemCacheBuilder extends \wcf\system\cache\builder\AbstractCacheBuilder {
        /**
         * @see wcf\system\cache\AbstractCacheBuilder::rebuild()
         */
        public function rebuild(array $parameters) {
                $list = new \wcf\data\jcoins\shop\item\JCoinsShopItemList(); 
		
		if (isset($parameters['onlyActive']) && $parameters['onlyActive'])
			$list->getConditionBuilder()->add("jcoins_shop_item.isDisabled = ?", array(0));
		
		$list->readObjects();
                return $list->getObjects();
        }
}