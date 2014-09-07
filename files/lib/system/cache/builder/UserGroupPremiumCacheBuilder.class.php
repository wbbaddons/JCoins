<?php
namespace wcf\system\cache\builder;

use wcf\data\user\group\premium\UserGroupPremiumList;

/**
 * Caches the Premium groups
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 * @subpackage	system.cache.builder
 */
class UserGroupPremiumCacheBuilder extends \wcf\system\cache\builder\AbstractCacheBuilder {
        /**
         * @see wcf\system\cache\AbstractCacheBuilder::rebuild()
         */
        public function rebuild(array $parameters) {
                $premiumList = new UserGroupPremiumList(); 
		
		if (isset($parameters['onlyActive']) && $parameters['onlyActive'])
			$premiumList->getConditionBuilder()->add("user_group_premium.isDisabled = ?", array(0));
		
		$premiumList->readObjects();
		
                return $premiumList->getObjects();
        }
}