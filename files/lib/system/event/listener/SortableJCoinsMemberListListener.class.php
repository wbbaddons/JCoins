<?php
namespace wcf\system\event\listener;
use wcf\system\WCF; 

/**
 * adds "jCoinsBalance" to validSortFields
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class SortableJCoinsMemberListListener implements IParameterizedEventListener {

	/**
	 * @see \wcf\system\event\listener\IParameterizedEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName, array &$parameters) {
		if (!MODULE_JCOINS || !WCF::getSession()->getPermission('user.jcoins.canSee')) return; 
		
		$eventObj->validSortFields[] = 'jCoinsBalance'; 
	}

}
