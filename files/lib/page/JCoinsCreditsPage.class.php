<?php
namespace wcf\page;
use wcf\page\AbstractPage;

class JCoinsCreditsPage extends AbstractPage {
    
	/**
	 * @see	wcf\page\AbstractPage::$loginRequired
	 */
	public $loginRequired = false;
	
	/**
	 * @see	wcf\page\AbstractPage::$neededModules
	 */
	public $neededModules = array('MODULE_JCOINS');
	
	public $templateName = 'jCoinsCredits';
}