<?php
namespace wcf\acp\form;
use wcf\system\exception\UserInputException;
use wcf\form\AbstractForm;
use wcf\system\WCF;
use wcf\data\jCoins\premiumGroup\PremiumGroup; 
use wcf\system\exception\IllegalLinkException;
use wcf\data\jCoins\premiumGroup\PremiumGroupAction;  
use wcf\system\language\I18nHandler; 
use wcf\data\package\PackageCache;
use wcf\system\exception\PermissionDeniedException;

/**
 * jcoins Premium Group Edit Form
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 * @subpackage	acp.form
 */
class JCoinsPremiumEditForm extends AbstractForm {
	/**
	 * @see	wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.jcoins.premium.edit';

	/**
	 * @see	wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.jCoins.premiumgroups.canEditPremiumGroups');

	/**
	 * @see	wcf\page\AbstractPage::$templateName
	 */
	public $templateName = 'JCoinsPremiumGroupAction';

	public $action = 'edit'; 
	
	public $description = "";
	public $jCoins	    = 0; 
	public $pGroupID    = 0; 
	public $pGroupObj   = null; 
	
	/**
	 * @see	wcf\page\AbstractPage::readParameters
	 */
	public function readParameters() {
		parent::readParameters();

		I18nHandler::getInstance()->register('description');
		
		$this->pGroupID = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : 0; 
		$this->pGroupObj = new PremiumGroup($this->pGroupID);
		
		if (!$this->pGroupObj->premiumGroupID) throw new IllegalLinkException();
		if (!UserGroup::isAccessibleGroup(array($this->pGroupObj->groupID))) throw new PermissionDeniedException(); 
	}
	
	public function readData() {
		parent::readData();

		if (empty($_POST)) {
			I18nHandler::getInstance()->setOptions('description', PackageCache::getInstance()->getPackageID('de.joshsboard.jCoins'),  $this->pGroupObj->description, 'wcf.jCoins.premiumGroups.description\d+');
		}
	}
	
	/**
	 * @see	wcf\form\IForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		    
		I18nHandler::getInstance()->readValues();
		if (isset($_POST['jCoins'])) $this->jCoins = intval ($_POST['jCoins']);
	}

	/**
	 * @see	wcf\form\IForm::validate()
	 */
	public function validate() {
		parent::validate();
		
		if ($this->jCoins < 0) {
			throw new UserInputException('jCoins', 'underZero');
		}
	}

	/**
	 * @see	wcf\form\IForm::save()
	 */
	public function save() {
		parent::save();
		
		if (I18nHandler::getInstance()->isPlainValue('description')) {
			I18nHandler::getInstance()->remove($this->description, PackageCache::getInstance()->getPackageID('com.woltlab.wcf.user'));
			$this->description = I18nHandler::getInstance()->getValue('description');
		}
		else {
			I18nHandler::getInstance()->save('description', $this->description, 'wcf.jCoins', PackageCache::getInstance()->getPackageID('de.joshsboard.jCoins'));
		}
		
		// update bbcode
		$this->objectAction = new PremiumGroupAction(array($this->pGroupID), 'update', array('data' => array(
			'jCoins'	=> $this->jCoins,
			'description'	=> 'wcf.jCoins.premiumGroups.description'.$this->pGroupID
		)));
		$this->objectAction->executeAction();
		
		// show success
		WCF::getTPL()->assign(array(
			'success' => true
		));
		
		$this->pGroupObj = new PremiumGroup($this->pGroupID);
	}

	/**
	 * @see	wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		I18nHandler::getInstance()->assignVariables();

		
		// read groups
		$this->groups = UserGroup::getGroupsByType(array(4));
		
		WCF::getTPL()->assign(array(
			'groupID'		=> $this->pGroupObj->groupID,
			'jCoins'		=> $this->pGroupObj->jCoins, 
			'period'		=> $this->pGroupObj->period, 
			'description'		=> $this->pGroupObj->description, 
			'groups'		=> $this->groups,
			'premiumGroupID'	=> $this->pGroupObj->premiumGroupID
		));
	}
}