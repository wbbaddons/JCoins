<?php
namespace wcf\data\jCoins\statement; 
use wcf\data\DatabaseObject;
use wcf\data\user\User; 

/**
 * a statement for jcoins
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
	 * returns the executed user
	 * 
	 * @return \wcf\data\user\User
	 */
	public function getExecutedUser() {
		return new User($this->executedUserID); 
	}
	
	/**
	 * returns the user
	 * 
	 * @return \wcf\data\user\User
	 */
	public function getUser() {
		return new User($this->userID); 
	}
}