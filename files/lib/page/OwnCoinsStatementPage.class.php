<?php
namespace wcf\page;
use wcf\page\AbstractPage;
use wcf\system\WCF;
use wcf\data\jCoins\statement\StatementList;

/**
 * all own statements page
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 * @subpackage	wcf.page
 */
class OwnCoinsStatementPage extends AbstractPage {
    
	/**
	 * @see	wcf\page\AbstractPage::$loginRequired
	 */
	public $loginRequired = true;
	
	/**
	 * @see	wcf\page\AbstractPage::$neededModules
	 */
	public $neededModules = array('MODULE_JCOINS');
	
	/**
	 * @see	wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		$list = new StatementList(); 
		$list->getConditionBuilder()->add("statement_entrys.userID = ?", array(WCF::getSession()->getUser()->userID));
		$list->readObjects(); 
		WCF::getTPL()->assign(array(
			'entrys' => $list->getObjects()
		));
	}
}