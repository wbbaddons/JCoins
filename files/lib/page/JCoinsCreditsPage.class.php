<?php
namespace wcf\page;

/**
 * the credit page
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 * @subpackage	wcf.page
 */
class JCoinsCreditsPage extends AbstractPage {
	/**
	 * @see	wcf\page\AbstractPage::$loginRequired
	 */
	public $loginRequired = false;
	
	/**
	 * @see	wcf\page\AbstractPage::$neededModules
	 */
	public $neededModules = array('MODULE_JCOINS');
	
	/**
	 * @see	wcf\page\AbstractPage::$templateName
	 */
	public $templateName = 'jCoinsCredits';
}