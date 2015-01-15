<?php
namespace wcf\data\user\jcoins\statement;

use wcf\data\DatabaseObject;
use wcf\data\user\User; 
use wcf\data\user\UserProfile;

/**
 * Represents a statement in the database.
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class UserJcoinsStatement extends DatabaseObject {

	/**
	 * @see	wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'user_jcoins_statement';

	/**
	 * @see	wcf\data\DatabaseObject::$databaseIndexName
	 */
	protected static $databaseTableIndexName = 'entryID';

	/**
	 * Cotains the user-object which executed the statement.
	 * @var	wcf\data\user\UserProfile
	 */
	protected $executedUser = null;

	/**
	 * Contains the user-object which received the statement.
	 * @var	wcf\data\user\UserProfile
	 */
	protected $user = null;

	/**
	 * Returns the user-object which executed this statement.
	 * @return	wcf\data\user\UserProfile
	 */
	public function getExecutedUser() {
		if ($this->executedUser === null) {
			if ($this->executedUserID) {
				$this->executedUser = UserProfile::getUserProfile($this->executedUserID);
			} else {
				$this->executedUser = new UserProfile(new User(null, array()));
			}
		}

		return $this->executedUser;
	}

	/**
	 * Returns the user-object which received this statement.
	 * @return	wcf\data\user\UserProfile
	 */
	public function getUser() {
		if ($this->user === null) {
			if ($this->userID) {
				$this->user = UserProfile::getUserProfile($this->userID);
			} else {
				$this->user = new UserProfile(new User(null, array()));
			}
		}

		return $this->user;
	}
	
	/**
	 * get the addtional-data array
	 * @return array<mixed>
	 */
	public function getAdditionalData() {
		$data = @unserialize($this->additionalData); 
		
		if (!is_array($data)) {
			return array(); // return empty array
		}
		
		return $data; 
	}
	
	/**
	 * get the reason with the additional data
	 * @return string
	 */
	public function getReason() {
		return \wcf\system\WCF::getLanguage()->getDynamicVariable($this->reason, $this->getAdditionalData());
	}
}
