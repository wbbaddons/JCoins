<?php
namespace wcf\system\dashboard\box;
use wcf\data\dashboard\box\DashboardBox;
use wcf\page\IPage;
use wcf\system\dashboard\box\AbstractSidebarDashboardBox;
use wcf\system\WCF;
use wcf\data\user\UserProfileList; 

/**
 * A Dashboardbox for the richest User
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 * @subpackage	system.cronjob
 * @category	Community Framework
 */
class RichestUserSidebarDashboardBox extends AbstractSidebarDashboardBox {
	/**
	 * latest news entries list
	 * @var	\wcf\data\user\UserList
	 */
	public $member = null;

	/**
	 * @see	\wcf\system\dashboard\box\IDashboardBox::init()
	 */
	public function init(DashboardBox $box, IPage $page) {
		parent::init($box, $page);
		
		$this->member = new UserProfileList();
		$this->member->sqlOrderBy = 'user_table.jCoinsBalance DESC'; 
		$this->member->sqlLimit = JCOINS_DASHBOARD_SIDEBAR_RICHEST_NUM;
		$this->member->readObjects(); 
		
		$this->fetched();
	}

	/**
	 * @see	\wcf\system\dashboard\box\AbstractContentDashboardBox::render()
	 */
	protected function render() {
		if (!count($this->member)) return '';

		WCF::getTPL()->assign(array(
			'member' => $this->member
		));

		return WCF::getTPL()->fetch('richestUserBox');
	}
}
