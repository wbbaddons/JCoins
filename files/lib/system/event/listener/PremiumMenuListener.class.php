<?php
namespace wcf\system\event\listener;
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
class PremiumMenuListener implements IParameterizedEventListener {

	/**
	 * @see \wcf\system\event\listener\IParameterizedEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName, array &$parameters) {
		if (!MODULE_JCOINS || !MODULE_JCOINS_PREMIUMGROUPS) return; 
		
		WCF::getTPL()->assign(array(
		    'premiumGroupsAvailable' => (count(UserGroupPremiumCache::getInstance()->getActiveGroups()) > 0) ? true : false
		));
	}

}
