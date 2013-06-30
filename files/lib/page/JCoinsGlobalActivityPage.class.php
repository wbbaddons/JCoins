<?php
namespace wcf\page;
use wcf\page\SortablePage;

/**
 * the global statement list
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcons
 * @subpackage	wcf.page
 */
class JCoinsGlobalActivityPage extends SortablePage {
	
	/**
	 * @see	wcf\page\AbstractPage::$neededModules
	 */
	public $neededModules = array('MODULE_JCOINS');
	
	/**
	 * @see	wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('mod.jcoins.canSeeTransferList');
	
	/**
	 * @see	wcf\page\AbstractPage::$templateName
	 */
	public $templateName = 'jCoinsGlobalActivity';
	
	/**
	 * @see	wcf\page\MultipleLinkPage::$itemsPerPage
	 */
	public $itemsPerPage = 25;

	/**
	 * @see	wcf\page\SortablePage::$defaultSortField
	 */
	public $defaultSortField = 'time';

	/**
	 * @see	wcf\page\SortablePage::$defaultSortOrder
	 */
	public $defaultSortOrder = 'DESC';

	/**
	 * @see	wcf\page\SortablePage::$validSortFields
	 */
	public $validSortFields = array('entryID', 'executedUserID', 'reason', 'sum', 'time', 'userID');

	/**
	 * @see	wcf\page\MultipleLinkPage::$objectListClassName
	 */
	public $objectListClassName = 'wcf\data\jCoins\statement\StatementList';
}