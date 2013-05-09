<?php
namespace wcf\data\jCoins\premiumGroup; 
use wcf\data\DatabaseObject;
use wcf\data\user\group\UserGroup;
use wcf\system\WCF;

/**
 * premium group database object
 * 
 * @author  Joshua Rüsweg
 * @package de.joshsboard.jcoins
 */
class PremiumGroup extends DatabaseObject {
	/**
	 * @see	wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'user_group_premium';

	/**
	 * @see	wcf\data\DatabaseObject::$databaseIndexName
	 */
	protected static $databaseTableIndexName = 'premiumGroupID';
	
	/**
	 * get the group
	 * @return	wcf\data\user\group\UserGroup
	 */
	public function getGroup() {
		return UserGroup::getGroupByID($this->getGroupID());
	}
	
        /**
         * return true if the group is deletable
         * 
         * @return  bool
         */
	public function isDeletable() {
		$sql = "SELECT COUNT(*) AS members FROM wcf".WCF_N."_user_to_group_premium WHERE premiumGroupID = ?"; 
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($this->premiumGroupID));
		$row = $statement->fetchArray();
		
		return ($row['members'] > 0) ? false : true; 
	}
	
	/**
	 * return true if the member is a member of the group
	 * 
	 * @param   integer	$userID
	 * @return  boolean 
	 */
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
	
	/**
	 * returns true if the usergroup is accessible
	 * 
	 * @return  boolean
	 */
	public function isAccessible() {
		return UserGroup::isAccessibleGroup(array($this->groupID));
	}    
}