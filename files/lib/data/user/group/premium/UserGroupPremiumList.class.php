<?php
namespace wcf\data\user\group\premium;

use wcf\data\DatabaseObjectList;

/**
 * Represents a list of premium-groups.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class UserGroupPremiumList extends DatabaseObjectList {

	/**
	 * @see	wcf\data\DatabaseObjectList::$sqlOrderBy
	 */
	public $sqlOrderBy = "user_group_premium.premiumGroupID ASC";

}
