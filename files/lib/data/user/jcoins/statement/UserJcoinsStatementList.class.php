<?php
namespace wcf\data\user\jcoins\statement;

use wcf\data\DatabaseObjectList;
use wcf\data\user\UserProfile; 
use wcf\system\event\EventHandler; 

/**
 * Represents a statement list.
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class UserJcoinsStatementList extends DatabaseObjectList {

	/**
	 * @see	wcf\data\DatabaseObjectList::$className
	 */
	public $className = 'wcf\data\user\jcoins\statement\UserJcoinsStatement';

	/**
	 * @see	wcf\data\DatabaseObjectList::$sqlOrderBy
	 */
	public $sqlOrderBy = "user_jcoins_statement.time DESC";
	
	/**
	 * @see \wcf\data\DatabaseObjectList::readObjects()
	 */
	public function readObjects() {
		parent::readObjects();
		
		EventHandler::getInstance()->fireAction($this, 'afterReadObjects'); 
		
		// cache userids
		$userIDs = array(); 
		
		foreach ($this->objects as $object) {
			$userIDs[] = $object->userID;
			$userIDs[] = $object->executedUserID; 
		}
		
		array_unique($userIDs); 
		
		UserProfile::getUserProfiles($userIDs);
	}
}