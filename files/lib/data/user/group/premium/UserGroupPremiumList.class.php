<?php
namespace wcf\data\user\group\premium;

use wcf\data\DatabaseObjectList;

/**
 * Represents a list of premium-groups.
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class UserGroupPremiumList extends DatabaseObjectList {

	/**
	 * @see	wcf\data\DatabaseObjectList::$sqlOrderBy
	 */
	public $sqlOrderBy = "user_group_premium.premiumGroupID ASC";

}
