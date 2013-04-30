<?php
namespace wcf\page;
use wcf\page\AbstractPage;
use wcf\system\WCF;
use wcf\data\jCoins\statement\StatementList;

class JCoinsGlobalActivityPage extends AbstractPage {
	
	/**
	 * @see	wcf\page\AbstractPage::$neededModules
	 */
	public $neededModules = array('MODULE_JCOINS');
	
	/**
	 * @see	wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('mod.jCoins.canSeeTransferList');
	
	public $templateName = 'JCoinsGlobalActivity';
	
	/**
	 * @see	wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		$list = new StatementList(); 
		$list->readObjects(); 
		WCF::getTPL()->assign(array(
			'entrys' => $list->getObjects()
		));
	}
}