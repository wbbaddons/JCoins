<?php
namespace chat\system\cache\builder;

use wcf\data\user\group\premium\PremiumList;

/**
 * Caches the Premium groups
 * 
 * @author         Joshua Rüsweg
 * @package        de.joshsboard.jcoins
 * @subpackage        system.cache.builder
 */
class PremiumCacheBuilder extends \wcf\system\cache\builder\AbstractCacheBuilder {
        /**
         * @see wcf\system\cache\AbstractCacheBuilder::rebuild()
         */
        public function rebuild(array $parameters) {
                $premiumList = new PremiumList(); 
		
		if (isset($parameters['onlyActive']) && $parameters['onlyActive'])
			$premiumList->getConditionBuilder()->add("user_group_premium.isDisabled = ?", array(0));
		
		$premiumList->readObjects();
		
                return $premiumList->getObjects();
        }
}