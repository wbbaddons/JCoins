<?php
namespace wcf\data\jCoins\statement;
use wcf\data\DatabaseObjectList;

/**
 * the StatementList
 * 
 * @author Joshua Rüsweg
 */
class StatementList extends DatabaseObjectList {
	/**
	 * @see	wcf\data\DatabaseObjectList::$className
	 */
	public $className = 'wcf\data\jCoins\statement\Statement';
	
	/**
	 * @see	wcf\data\DatabaseObjectList::$sqlOrderBy
	 */
	public $sqlOrderBy = "statement_entrys.time DESC";
}