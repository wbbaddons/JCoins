<?php
namespace wcf\data\jCoins\statement; 
use wcf\data\DatabaseObject;
use wcf\data\user\User; 

class Statement extends DatabaseObject {
	/**
	 * @see	wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'statement_entrys';

	/**
	 * @see	wcf\data\DatabaseObject::$databaseIndexName
	 */
	protected static $databaseTableIndexName = 'entryID';
	
	public function getTime() {
		return $this->time; 
	}
	
	public function getReason() {
		return $this->reason; 
	}
	
	public function getSum() {
		return $this->sum; 
	}
	
	public function getExecutedUserID() {
		return $this->executedUserID; 
	}
	
	public function getExcetuedUser() {
		return new User($this->executedUserID); 
	}
	
	public function getUser() {
		return new User($this->userID); 
	}
}