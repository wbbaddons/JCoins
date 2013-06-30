<?php
namespace wcf\page;
use wcf\page\AbstractPage;
use wcf\system\WCF;
use wcf\data\jCoins\statement\StatementList;

/**
 * the global statement list
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcons
 * @subpackage	wcf.page
 */
class JCoinsGlobalActivityPage extends AbstractPage {
	
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