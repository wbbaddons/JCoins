<?php
namespace wcf\page;

use wcf\data\user\group\premium\UserGroupPremiumCache;
use wcf\page\AbstractPage;
use wcf\system\user\group\UserPremiumGroupHandler;
use wcf\system\WCF;

/**
 * list all active premium groups on a page
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 * @subpackage	wcf.page
 */
class JCoinsPremiumGroupsOverviewPage extends AbstractPage {

	/**
	 * @see	\wcf\page\AbstractPage::$loginRequired
	 */
	public $loginRequired = true;

	/**
	 * @see	\wcf\page\AbstractPage::$neededModules
	 */
	public $neededModules = array('MODULE_JCOINS', 'MODULE_JCOINS_PREMIUMGROUPS');

	/**
	 * list of premium-groups
	 * @var	\wcf\data\jCoins\premium\PremiumList
	 */
	public $premiumGroupList = null;

	/**
	 * @see	\wcf\page\IPage::readData()
	 */
	public function readData() {
		parent::readData();

		$groups = UserGroupPremiumCache::getInstance()->getActiveGroups(); 
		
		$groupIDs = array();
		foreach ($groups as $premiumGroupID => $premiumGroup) {
			// remove admin groups
			if ($premiumGroup->getGroup()->isAdminGroup()) continue; 
			
			if (!isset($this->premiumGroupList[$premiumGroup->groupID]['groupName'])) {
				$this->premiumGroupList[$premiumGroup->groupID]['groupName'] = $premiumGroup->getGroup()->getName();
			}

			$this->premiumGroupList[$premiumGroup->groupID]['data'][$premiumGroupID] = $premiumGroup;

			if (!in_array($premiumGroup->groupID, $groupIDs)) {
				$groupIDs[] = $premiumGroup->groupID;
			}
		}

		if (!empty($groupIDs)) {
			foreach ($groupIDs as $groupID) {
				$this->premiumGroupList[$groupID]['isMember'] = UserPremiumGroupHandler::getInstance()->isMember($groupID);
				$this->premiumGroupList[$groupID]['until'] = UserPremiumGroupHandler::getInstance()->getUntil($groupID);
			}
		}
	}

	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		WCF::getTPL()->assign('premiumGroups', $this->premiumGroupList);
	}

}
