<?php
namespace wcf\system\event\listener;
use wcf\system\user\storage\UserStorageHandler;

/**
 * clear the premium cache
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class JCoinsClearPremiumGroupCacheListener implements IParameterizedEventListener {

	/**
	 * @see \wcf\system\event\listener\IParameterizedEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName, array &$parameters) {
		if (count($eventObj->user) == 0) return; 
		
		// reset storage
		UserStorageHandler::getInstance()->reset(array_keys($eventObj->userToGroups), 'jCoinsPremiumGroupIDs');
	}

}
