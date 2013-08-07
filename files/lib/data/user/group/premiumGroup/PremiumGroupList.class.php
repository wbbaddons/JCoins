<?php
namespace wcf\data\user\group\premiumGroup;
use wcf\data\DatabaseObjectList;

/**
 * Represents a list of premium-groups.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class PremiumGroupList extends DatabaseObjectList {
	/**
	 * @see	wcf\data\DatabaseObjectList::$sqlOrderBy
	 */
	public $sqlOrderBy = "user_group_premium.premiumGroupID ASC";
}
