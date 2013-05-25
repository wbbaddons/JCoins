<?php
namespace wcf\acp\form;
use wcf\data\user\group\premiumGroup\PremiumGroupAction;
use wcf\data\user\group\premiumGroup\PremiumGroupEditor;
use wcf\data\package\PackageCache;
use wcf\data\user\group\UserGroup;
use wcf\form\AbstractForm;
use wcf\system\exception\UserInputException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\language\I18nHandler; 
use wcf\system\WCF;

/**
 * Shows the premium-group add-form.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 * @subpackage	acp.form
 */
class JCoinsPremiumAddForm extends AbstractForm {
	/**
	 * @see	wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.jcoins.premium.add';

	/**
	 * @see	wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.jcoins.premiumgroups.canEditPremiumGroups');

	/**
	 * @see wcf\page\AbstractPage::$action
	 */
	public $action = 'add'; 
	
	/**
	 * descriptopn of the premium group
	 * @var string
	 */
	public $description = ''; 
	
	/**
	 * the groupid for the premium group 
	 * @var integer
	 */
	public $groupID = 0; 
	
	/**
	 * the coasts of the group
	 * @var integer 
	 */
	public $jCoins = 0; 
	
	/**
	 * the time of beeing in the group
	 * @var integer
	 */
	public $period = 0;
	
	/**
	 * all aviable groups 
	 * @var array<mixed>
	 */
	public $groups = array(); 
	
	/**
	 * @see	wcf\page\IPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		I18nHandler::getInstance()->register('description');
	}
	
	/**
	 * @see wcf\page\IPage::readData()
	 */
	public function readData() {
		parent::readData();
		
		// read groups
		$this->groups = UserGroup::getAccessibleGroups(array(UserGroup::OTHER));
		
		if (empty($this->groups)) {
			throw new PermissionDeniedException(); 
		}
	}
	
	/**
	 * @see	wcf\form\IForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		I18nHandler::getInstance()->readValues();
		
		if (isset($_POST['groupID'])) $this->groupID = intval($_POST['groupID']);
		if (isset($_POST['jCoins'])) $this->jCoins = intval($_POST['jCoins']);
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
		
		if (!$this->period) {
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
		
		$this->objectAction = new PremiumGroupAction(array(), 'create', array(
			'data' => array(
				'groupID' => $this->groupID,
				'jCoins' => $this->jCoins,
				'period' => $this->period,
				'description' => $this->description
			)
		));
		$returnValues = $this->objectAction->executeAction();
		
		// save I18n description
		if (!I18nHandler::getInstance()->isPlainValue('description')) {
			$premiumGroupID = $returnValues['returnValues']->premiumGroupID;
			I18nHandler::getInstance()->save('description', 'wcf.jcoins.premiumGroups.description'.$premiumGroupID, 'wcf.jcoins', PackageCache::getInstance()->getPackageID('de.joshsboard.jcoins'));

			// update name
			$editor = new PremiumGroupEditor($returnValues['returnValues']);
			$editor->update(array(
				'description' => 'wcf.jcoins.premiumGroups.description'.$premiumGroupID
			));
		}
		
		$this->saved();
		
		// reset values
		$this->groupID = $this->jCoins = $this->period = 0; 
		$this->description = ""; 
		
		// show success
		WCF::getTPL()->assign('success', true);
	}

	/**
	 * @see	wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		I18nHandler::getInstance()->assignVariables();
		
		WCF::getTPL()->assign(array(
			'groupID' => $this->groupID,
			'jCoins' => $this->jCoins, 
			'period' => $this->period, 
			'description' => $this->description, 
			'groups' => $this->groups
		));
	}
}
