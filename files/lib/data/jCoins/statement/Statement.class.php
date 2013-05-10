<?php
namespace wcf\data\jCoins\statement; 
use wcf\data\DatabaseObject;
use wcf\data\user\User; 

/**
 * Represents a statement in the database.
 * 
 * @author  Joshua Rüsweg
 * @package de.joshsboard.jcoins
 */
class Statement extends DatabaseObject {
	/**
	 * @see	wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'statement_entrys';

	/**
	 * @see	wcf\data\DatabaseObject::$databaseIndexName
	 */
	protected static $databaseTableIndexName = 'entryID';
	
	/**
	 * Cotains the user-object which executed the statement.
	 * @var wcf\data\user\User
	 */
	protected $executedUser = null;
	
	/**
	 * Contains the user-object which received the statement.
	 * @var wcf\data\user\User
	 */
	protected $user = null;
	
	/**
	 * Returns the user-object which executed this statement.
	 * @return wcf\data\user\User
	 */
	public function getExecutedUser() {
		if ($this->executedUser === null) {
			$this->executedUser = new User($this->executedUserID);
		}
		
		return $this->executedUser; 
	}
	
	/**
	 * Returns the user-object which received this statement.
	 * @return wcf\data\user\User
	 */
	public function getUser() {
		if ($this->user === null) {
			$this->user = new User($this->userID);
		}
		
		return $this->user; 
	}
}
