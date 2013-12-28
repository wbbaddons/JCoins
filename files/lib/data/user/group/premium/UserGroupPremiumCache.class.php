<?php
namespace wcf\data\user\group\premium;

use wcf\system\cache\builder\UserGroupPremiumCacheBuilder;

/**
 * Manages the premium cache
 * 
 * @author         Joshua Rüsweg
 * @package        de.joshsboard.jcoins
 */
class UserGroupPremiumCache extends \wcf\system\SingletonFactory {
	/**
	 * list of cached rooms
	 * @var        array<wcf\data\user\group\premium>
	 */
	protected $groups = array(); 

	/**
	 * list of groups, wheater are not disabled
	 */
	protected $active_groups = array(); 
	
	/**
	 * @see        wcf\system\SingletonFactory::init()
	 */
	protected function init() {
		$this->groups = UserGroupPremiumCacheBuilder::getInstance()->getData();
		$this->active_groups = UserGroupPremiumCacheBuilder::getInstance()->getData(array('onlyActive' => true));
	}
	
	/**
         * Returns a specific group
         * 
         * @param        integer                $groupID
         * @return        wcf\data\user\group\premium\UserGroupPremium
         */
	public function getGroup($groupID) {
		if (isset($this->groups[$groupID]))
                        return $this->groups[$groupID];
                
                return null;
	}
	
	/**
         * Returns all groups
         * 
         * @param        integer                $groupID
         * @return        array<wcf\data\user\group\premium\UserGroupPremium>
         */
	public function getGroups() {
		return $this->groups; 
	}
	
	/**
         * Returns all active groups
         * 
         * @param        integer                $groupID
         * @return        array<wcf\data\user\group\premium\UserGroupPremium>
         */
	public function getActiveGroups() {
		return $this->active_groups; 
	}
}