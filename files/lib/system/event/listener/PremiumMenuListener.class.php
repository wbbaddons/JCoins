<?php
namespace wcf\system\event\listener;

use wcf\system\event\IEventListener;
use wcf\data\user\group\premium\UserGroupPremiumCache; 
use wcf\system\WCF;

/**
 * adds the variable "premiumGroupsAvailable"
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class PremiumMenuListener implements IEventListener {

	/**
	 * @see	wcf\system\event\IEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if (!MODULE_JCOINS || !MODULE_JCOINS_PREMIUMGROUPS) return; 
		
		WCF::getTPL()->assign(array(
		    'premiumGroupsAvailable' => (count(UserGroupPremiumCache::getInstance()->getActiveGroups()) > 0) ? true : false
		));
	}

}
