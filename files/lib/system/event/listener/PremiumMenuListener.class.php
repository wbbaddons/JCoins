<?php
namespace wcf\system\event\listener;

use wcf\system\event\IEventListener;
use wcf\data\user\group\premium\PremiumCache; 
use wcf\system\WCF;

/**
 * adds the variable "premiumGroupsAvailable"
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class PremiumMenuListener implements IEventListener {

	/**
	 * @see	wcf\system\event\IEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if (!MODULE_JCOINS || !MODULE_JCOINS_PREMIUMGROUPS) return; 
		
		WCF::getTPL()->assign(array(
		    'premiumGroupsAvailable' => (count(PremiumCache::getInstance()->getActiveGroups()) > 0) ? true : false
		));
	}

}
