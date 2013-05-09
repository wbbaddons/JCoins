<?php
namespace wcf\page;
use wcf\page\AbstractPage;
use wcf\data\jCoins\premiumGroup\PremiumGroupList; 
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
	 * @see	wcf\page\AbstractPage::$loginRequired
	 */
	public $loginRequired = true;
	
	/**
	 * @see	wcf\page\AbstractPage::$neededModules
	 */
	public $neededModules = array('MODULE_JCOINS');
	
	/**
	 * list of premium-groups
	 * @var wcf\data\jCoins\premiumGroup\PremiumGroupList
	 */
	public $premiumGroupList = null;
	
	/**
	 * @see	wcf\page\IPage::readData()
	 */
	public function readData() {
		parent::readData();
		
		$this->premiumGroupList = new PremiumGroupList();
		$this->premiumGroupList->readObjects();
	}
	
	/**
	 * @see	wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
	    parent::assignVariables();
	    
	    WCF::getTPL()->assign('premiumGroups', $this->premiumGroupList);
	}
}