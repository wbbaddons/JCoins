<?php
namespace wcf\system\cache\builder;


/**
 * Caches the shop items
 * 
 * @author         Joshua Rüsweg
 * @package        de.joshsboard.jcoins
 * @subpackage     system.cache.builder
 */
class JCoinsShopItemCacheBuilder extends \wcf\system\cache\builder\AbstractCacheBuilder {
        /**
         * @see wcf\system\cache\AbstractCacheBuilder::rebuild()
         */
        public function rebuild(array $parameters) {
                $list = new \wcf\data\jcoins\shop\item\JCoinsShopItemList(); 
		
		if (isset($parameters['onlyActive']) && $parameters['onlyActive'])
			$list->getConditionBuilder()->add("user_group_premium.isDisabled = ?", array(0));
		
		$list->readObjects();
                return $list->getObjects();
        }
}