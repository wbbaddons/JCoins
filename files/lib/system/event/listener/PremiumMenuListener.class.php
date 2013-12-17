<?php
namespace wcf\system\event\listener;

use wcf\system\event\IEventListener;
use wcf\data\user\group\premium\PremiumList;
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
		
		$premiumList = new PremiumList(); 
		$premiumList->getConditionBuilder()->add("user_group_premium.isDisabled = ?", array(0));
		
		WCF::getTPL()->assign(array(
		    'premiumGroupsAvailable' => ($premiumList->countObjects() > 0) ? true : false
		));
	}

}
