<?php
namespace wcf\system\event\listener;

use wcf\system\event\IEventListener;
use wcf\system\WCF; 

/**
 * adds "jCoinsBalance" to validSortFields
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class SortableJCoinsMemberListListener implements IEventListener {

	/**
	 * @see	wcf\system\event\IEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if (!MODULE_JCOINS || !WCF::getSession()->getPermission('user.jcoins.canSee')) return; 
		
		$eventObj->validSortFields[] = 'jCoinsBalance'; 
	}

}
