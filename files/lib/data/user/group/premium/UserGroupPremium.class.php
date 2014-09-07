<?php
namespace wcf\data\user\group\premium;

use wcf\data\DatabaseObject;
use wcf\data\user\group\UserGroup;
use wcf\system\database\util\PreparedStatementConditionBuilder;
use wcf\system\request\IRouteController;
use wcf\system\user\group\UserPremiumGroupHandler;
use wcf\system\WCF;

/**
 * Represents a premium-group in the database.
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class UserGroupPremium extends DatabaseObject implements IRouteController {

	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'user_group_premium';

	/**
	 * @see	\wcf\data\DatabaseObject::$databaseIndexName
	 */
	protected static $databaseTableIndexName = 'premiumGroupID';

	/**
	 * Returns a object of the user-group.
	 * 
	 * @return	\wcf\data\user\group\UserGroup
	 */
	public function getGroup() {
		return UserGroup::getGroupByID($this->groupID);
	}

	/**
	 * Returns true if the group is deleteable.
	 * 
	 * @return	boolean
	 */
	public function isDeletable() {
		$sql = "SELECT	COUNT(*) as count
			FROM	wcf" . WCF_N . "_user_to_group_temp
			WHERE	groupID = ?";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($this->groupID));
		$row = $statement->fetchArray();
		return $row['count'] ? false : true;
	}

	/**
	 * Returns true if the given user is a member of this group.
	 * 
	 * @param	integer	$userID
	 * @return	boolean 
	 */
	public function isMember($userID = null) {
		if ($userID === null) {
			$userID = WCF::getUser()->userID;
		}

		if (WCF::getUser()->userID === $userID) {
			return UserPremiumGroupHandler::getInstance()->isMember($this->groupID);
		} else {
			$condition = new PreparedStatementConditionBuilder();
			$condition->add('groupID = ?', array($this->groupID));
			$condition->add('userID = ?', array($userID));

			$sql = "SELECT 	COUNT(*)
				FROM 	wcf" . WCF_N . "_user_to_group_temp "
				. $condition;
			$statement = WCF::getDB()->prepareStatement($sql);
			$statement->execute($condition->getParameters());

			return (bool) $statement->fetchColumn();
		}
	}

	/**
	 * Returns true if this group is accessible by current user.
	 * 
	 * @return	boolean
	 */
	public function isAccessible() {
		return UserGroup::isAccessibleGroup(array($this->groupID));
	}

	/**
	 * @see	\wcf\data\ITitledObject::getTitle()
	 */
	public function getTitle() {
		return $this->getGroup()->getName();
	}

	/**
	 * @see	\wcf\data\IRouteController::getTitle()
	 */
	public function getObjectID() {
		return $this->premiumGroupID;
	}

}
