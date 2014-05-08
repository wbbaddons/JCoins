<?php
namespace wcf\system\event\listener;

use wcf\system\event\IEventListener;
use wcf\system\user\storage\UserStorageHandler;

/**
 * clear the premium cache
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class JCoinsClearPremiumGroupCacheListener implements IEventListener {

	/**
	 * @see	wcf\system\event\IEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if (count($eventObj->user) == 0) return; 
		
		// reset storage
		UserStorageHandler::getInstance()->reset(array_keys($eventObj->userToGroups), 'jCoinsPremiumGroupIDs');
	}

}
