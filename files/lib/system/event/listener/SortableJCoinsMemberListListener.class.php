<?php
namespace wcf\system\event\listener;

use wcf\system\event\IEventListener;

/**
 * adds "jCoinsBalance" to validSortFields
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class SortableJCoinsMemberListListener implements IEventListener {

	/**
	 * @see	wcf\system\event\IEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if (!MODULE_JCOINS) return; 
		
		$eventObj->validSortFields[] = 'jCoinsBalance'; 
	}

}
