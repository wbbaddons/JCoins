<?php
namespace wcf\data\user\group\premium;

use wcf\data\DatabaseObjectEditor;
use wcf\system\cache\builder\UserGroupPremiumCacheBuilder; 
use wcf\system\WCF;

/**
 * Provides functions to edit premium groups.
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class UserGroupPremiumEditor extends DatabaseObjectEditor implements \wcf\data\IEditableCachedObject {

	/**
	 * @see	\wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'wcf\data\user\group\premium\UserGroupPremium';

	public function insertPremiumGroup() {
		$sql = "INSERT INTO wcf" . WCF_N . "_user_to_group_temp
                            (userID, groupID, until)
		VALUES      (?, ?, ?)";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array(
		    WCF::getUser()->userID,
		    $this->groupID,
		    TIME_NOW + ($this->period * 86400)
		));
	}

	public function updatePremiumGroup() {
		$sql = "UPDATE  wcf" . WCF_N . "_user_to_group_temp
                SET     until = (until + ?)
                WHERE   groupID = ?
                    AND userID = ?";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array(
		    $this->period * 86400,
		    $this->groupID,
		    WCF::getUser()->userID
		));
	}

	/**
	 * clears the premium-group cache
	 */
	public static function resetCache() {
		UserGroupPremiumCacheBuilder::getInstance()->reset(); 
	}
	
}
