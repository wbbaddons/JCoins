<?php
namespace wcf\data\jCoins\premiumGroup;
use wcf\data\DatabaseObjectList;

/**
 * the StatementList
 * 
 * @author Joshua Rüsweg
 */
class PremiumGroupList extends DatabaseObjectList {
	/**
	 * @see	wcf\data\DatabaseObjectList::$className
	 */
	public $className = 'wcf\data\jCoins\premiumGroup\PremiumGroup';
	
	/**
	 * @see	wcf\data\DatabaseObjectList::$sqlOrderBy
	 */
	public $sqlOrderBy = "user_group_premium.premiumGroupID ASC";
}