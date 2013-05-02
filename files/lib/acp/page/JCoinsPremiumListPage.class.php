<?php
namespace wcf\acp\page;
use wcf\page\SortablePage;
use wcf\system\WCF;
use wcf\data\user\group\UserGroup; 

/**
 * a list of all premium groups
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
	public $neededPermissions = array('admin.jCoins.premiumgroups.canEditPremiumGroups');

	/**
	 * @see	wcf\page\AbstractPage::$templateName
	 */
	public $templateName = 'JCoinsPremiumList';

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
	    
		WCF::getTPL()->assign(array(
			'canAddNewGroup'	=> (count(UserGroup::getAccessibleGroups(array(UserGroup::OTHER))) > 0) ? true : false
		));
	}
}