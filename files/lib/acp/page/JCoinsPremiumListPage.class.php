<?php
namespace wcf\acp\page;
use wcf\data\user\group\UserGroup;
use wcf\page\SortablePage;
use wcf\system\WCF;

/**
 * Represents a list of all premium-groups.
 * 
 * @author  Joshua Rüsweg
 * @package de.joshsboard.jcoins
 * @subpackage	acp.page
 */
class JCoinsPremiumListPage extends SortablePage {
	/**
	 * @see	wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.jcoins.premium.list';

	/**
	 * @see	wcf\page\MultipleLinkPage::$defaultSortField
	 */
	public $defaultSortField = 'premiumGroupID';

	/**
	 * @see	wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.jcoins.premiumgroups.canEditPremiumGroups');

	/**
	 * @see	wcf\page\MultipleLinkPage::$objectListClassName
	 */
	public $objectListClassName = 'wcf\data\jCoins\premiumGroup\PremiumGroupList';

	/**
	 * @see	wcf\page\MultipleLinkPage::$validSortFields
	 */
	public $validSortFields = array('premiumGroupID', 'jCoins', 'period', 'members');
	
	/**
	 * @see	wcf\page\MultipleLinkPage::initObjectList()
	 */
	protected function initObjectList() {
		parent::initObjectList();

		$this->objectList->sqlSelects .= "(SELECT COUNT(*) FROM wcf".WCF_N."_user_to_group_premium WHERE premiumGroupID = user_group_premium.premiumGroupID) AS members";
	}
	
	/**
	 * @see	wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign('canAddNewGroup', count(UserGroup::getAccessibleGroups(array(UserGroup::OTHER))));
	}
}
