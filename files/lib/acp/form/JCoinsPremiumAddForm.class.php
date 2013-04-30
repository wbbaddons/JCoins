<?php
namespace wcf\acp\form;
use wcf\data\jCoins\premiumGroup\PremiumGroupEditor;
use wcf\system\exception\UserInputException;
use wcf\form\AbstractForm;
use wcf\system\WCF;
use wcf\data\user\group\UserGroup;
use wcf\system\language\I18nHandler; 
use wcf\data\package\PackageCache;
use wcf\system\exception\PermissionDeniedException; 
use wcf\data\jCoins\premiumGroup\PremiumGroup;

class JCoinsPremiumAddForm extends AbstractForm {
	/**
	 * @see	wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.jcoins.premium.add';

	/**
	 * @see	wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.jCoins.premiumgroups.canEditPremiumGroups');

	/**
	 * @see	wcf\page\AbstractPage::$templateName
	 */
	public $templateName = 'JCoinsPremiumGroupAction';

	public $action = 'add'; 
	
	public $description = ""; 
	public $groupID	    = 0; 
	public $jCoins	    = 0; 
	public $period	    = 0; 
	public $groups	    = null; 
	
	public function readParameters() {
	    parent::readParameters();
	    
	    if (count(UserGroup::getAccessibleGroups(array(UserGroup::OTHER))) == 0) {
		throw new PermissionDeniedException(); 
	    }
	    
	    I18nHandler::getInstance()->register('description');
	}
	
	/**
	 * @see	wcf\form\IForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		I18nHandler::getInstance()->readValues();
		
		if (isset($_POST['groupID'])) $this->groupID = intval($_POST['groupID']);
		if (isset($_POST['jCoins'])) $this->jCoins = intval ($_POST['jCoins']);
		if (isset($_POST['period'])) $this->period = intval($_POST['period']);
		if (I18nHandler::getInstance()->isPlainValue('description')) $this->description = I18nHandler::getInstance()->getValue('description');
		
		
	}

	/**
	 * @see	wcf\form\IForm::validate()
	 */
	public function validate() {
		parent::validate();
		
		if ($this->jCoins < 0) {
		    throw new UserInputException('jCoins', 'underZero');
		}
		
		if ($this->period < 1) {
		    throw new UserInputException('period', 'time');
		}
		
		if (!UserGroup::isAccessibleGroup(array($this->groupID))) {
		    throw new PermissionDeniedException(); 
		}
	}

	/**
	 * @see	wcf\form\IForm::save()
	 */
	public function save() {
		parent::save();
		
		$this->objectAction = PremiumGroupEditor::create(array(
			'groupID'	=> $this->groupID, 
			'jCoins'	=> $this->jCoins, 
			'period'	=> $this->period, 
			'isDisabled'	=> 0, 
			'description'	=> $this->description
		));
		
		if (!I18nHandler::getInstance()->isPlainValue('description')) {
			$returnValues = $this->objectAction;
			$ID = $returnValues->premiumGroupID;
			I18nHandler::getInstance()->save('description', 'wcf.jCoins.premiumGroups.description'.$ID, 'wcf.jCoins', PackageCache::getInstance()->getPackageID('de.joshsboard.jCoins'));

			// update name
			$group = new PremiumGroupEditor(new PremiumGroup($ID));
			$group->update(array(
				'description' => 'wcf.jCoins.premiumGroups.description'.$ID
			));
		}
		
		$this->groupID = 0; 
		$this->jCoins = 0; 
		$this->period = 0; 
		$this->description = ""; 
		
		// show success
		WCF::getTPL()->assign(array(
			'success' => true
		));
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
			'groupID'	=> $this->groupID,
			'jCoins'	=> $this->jCoins, 
			'period'	=> $this->period, 
			'description'	=> $this->description, 
			'groups'	=> $this->groups
		));
	}
}