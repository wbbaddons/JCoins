<?php
namespace wcf\data\user\jcoins\statement;

use wcf\data\DatabaseObject;
use wcf\data\user\User;

/**
 * Represents a statement in the database.
 * 
 * @author	Joshua Rüsweg
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
	 * @var	wcf\data\user\User
	 */
	protected $executedUser = null;

	/**
	 * Contains the user-object which received the statement.
	 * @var	wcf\data\user\User
	 */
	protected $user = null;

	/**
	 * Returns the user-object which executed this statement.
	 * @return	wcf\data\user\User
	 */
	public function getExecutedUser() {
		if ($this->executedUser === null) {
			$this->executedUser = new User($this->executedUserID);
		}

		return $this->executedUser;
	}

	/**
	 * Returns the user-object which received this statement.
	 * @return	wcf\data\user\User
	 */
	public function getUser() {
		if ($this->user === null) {
			$this->user = new User($this->userID);
		}

		return $this->user;
	}
	
	/**
	 * get the addtional-data array
	 * @return array<mixed>
	 */
	public function getAdditionalData() {
		return unserialize($this->additionalData); 
	}
	
	/**
	 * get the reason with the additional data
	 * @return string
	 */
	public function getReason() {
		return \wcf\system\WCF::getLanguage()->getDynamicVariable($this->reason, $this->getAdditionalData());
	}
}
