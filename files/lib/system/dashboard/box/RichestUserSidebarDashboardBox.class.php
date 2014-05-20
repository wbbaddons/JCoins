<?php
namespace wcf\system\dashboard\box;
use wcf\data\dashboard\box\DashboardBox;
use wcf\page\IPage;
use wcf\system\dashboard\box\AbstractSidebarDashboardBox;
use wcf\system\WCF;
use wcf\data\user\UserList; 

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
		
		$this->member = new UserList();
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
