<?php
namespace wcf\page;
use wcf\page\AbstractPage;
use wcf\data\jCoins\premiumGroup\PremiumGroupList; 
use wcf\system\WCF;

class JCoinsPremiumGroupsOverviewPage extends AbstractPage {
    
	/**
	 * @see	wcf\page\AbstractPage::$loginRequired
	 */
	public $loginRequired = true;
	
	/**
	 * @see	wcf\page\AbstractPage::$neededModules
	 */
	public $neededModules = array('MODULE_JCOINS');
	
	public $templateName = 'jCoinsPremiumGroupsOverview';
	
	public function assignVariables() {
	    parent::assignVariables();
	    
	    $list = new PremiumGroupList();
	    $list->readObjects();
	    
	    WCF::getTPL()->assign(array(
		    'pGroups' => $list->getObjects()
	    ));
	}
}