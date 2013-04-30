<?php
namespace wcf\data\jCoins\premiumGroup; 
use wcf\data\DatabaseObject;
use wcf\data\user\group\UserGroup;
use wcf\system\WCF;

class PremiumGroup extends DatabaseObject {
	/**
	 * @see	wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'user_group_premium';

	/**
	 * @see	wcf\data\DatabaseObject::$databaseIndexName
	 */
	protected static $databaseTableIndexName = 'premiumGroupID';
	
	public function getGroupID() {
		return $this->groupID; 
	}
	
	public function getPremiumGroupID() {
	    return $this->premiumGroupID; 
	}
	
	public function getJCoins() {
		return $this->jCoins; 
	}
	
	public function getPeriod() {
		return $this->period; 
	}
	
	public function isDisabled() {
		return $this->isDisabled; 
	}
	
	public function getDescription() {
		return $this->description; 
	}
	
	public function getGroup() {
		$group = UserGroup::getGroupByID($this->getGroupID());
		return $group; 
	}
	
	public function isDeletable() {
		$sql = "SELECT COUNT(*) AS members FROM wcf".WCF_N."_user_to_group_premium WHERE premiumGroupID = ?"; 
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($this->premiumGroupID));
		$row = $statement->fetchArray();
		
		return ($row['members'] > 0) ? false : true; 
	}
	
        public function isMember($userID = null) {
		if ($userID === null) {
			$userID = WCF::getSession()->userID; 
		}
		
		$sql = "SELECT COUNT(*) AS members FROM wcf".WCF_N."_user_to_group_premium WHERE premiumGroupID = ? AND userID = ?"; 
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($this->premiumGroupID, $userID));
		$row = $statement->fetchArray();
		
                return ($row['members'] > 0) ? true : false; 
        }
	
	public function isAccessible() {
		return UserGroup::isAccessibleGroup(array($this->groupID));
	}    
}