<?php
namespace wcf\page;
use wcf\page\AbstractPage;
use wcf\data\jCoins\premiumGroup\PremiumGroupList; 
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
	 * @see	wcf\page\AbstractPage::$templateName
	 */
	public $templateName = 'jCoinsPremiumGroupsOverview';
	
	/**
	 * @see	wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
	    parent::assignVariables();
	    
	    $list = new PremiumGroupList();
	    $list->readObjects();
	    
	    WCF::getTPL()->assign(array(
		    'pGroups' => $list->getObjects()
	    ));
	}
}