<?php
namespace wcf\acp\form;

use wcf\data\user\group\premium\UserGroupPremiumAction;
use wcf\data\user\group\premium\UserGroupPremiumEditor;
use wcf\data\user\group\UserGroup;
use wcf\form\AbstractForm;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\exception\UserInputException;
use wcf\system\language\I18nHandler;
use wcf\system\WCF;

/**
 * Shows the premium-group add-form.
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 * @subpackage	acp.form
 */
class JCoinsPremiumAddForm extends AbstractForm {

	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.jcoins.premium.add';

	/**
	 * @see \wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.jcoins.premiumgroups.canAddPremiumGroups');

	/**
	 * @see	\wcf\page\AbstractPage::$neededModules
	 */
	public $neededModules = array('MODULE_JCOINS', 'MODULE_JCOINS_PREMIUMGROUPS');

	/**
	 * @see	\wcf\page\AbstractPage::$action
	 */
	public $action = 'add';

	/**
	 * the groupid for the premium group
	 * @var	integer
	 */
	public $groupID = 0;

	/**
	 * the coasts of the group
	 * @var	integer 
	 */
	public $jCoins = 0;

	/**
	 * the time of beeing in the group
	 * @var	integer
	 */
	public $period = 0;

	/**
	 * all available groups 
	 * @var	array<mixed>
	 */
	public $groups = array();

	/**
	 * @see	\wcf\page\IPage::readData()
	 */
	public function readData() {

		I18nHandler::getInstance()->register('description');

		parent::readData();

		// read groups
		$this->groups = UserGroup::getAccessibleGroups(array(UserGroup::OTHER));

		// remove admin groups
		foreach ($this->groups as $key => $group) {
			if ($group->isAdminGroup()) {
				unset($this->groups[$key]);
			}
		}
		
		if (empty($this->groups)) {
			throw new NamedUserException(WCF::getLanguage()->get('wcf.jcoins.nogroupsavailable'));
		}
	}

	/**
	 * @see	\wcf\form\IForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();

		I18nHandler::getInstance()->readValues();

		if (isset($_POST['groupID'])) $this->groupID = intval($_POST['groupID']);
		if (isset($_POST['jCoins'])) $this->jCoins = intval($_POST['jCoins']);
		if (isset($_POST['period'])) $this->period = intval($_POST['period']);
	}

	/**
	 * @see	\wcf\form\IForm::validate()
	 */
	public function validate() {
		parent::validate();

		if ($this->jCoins <= 0) { // not null
			throw new UserInputException('jCoins', 'underZero');
		}

		if (!$this->period) {
			throw new UserInputException('period', 'time');
		}

		$this->validateGroup();
	}

	/**
	 * validating the group
	 */
	public function validateGroup() {
		if (!UserGroup::isAccessibleGroup(array($this->groupID))) {
			throw new PermissionDeniedException();
		}
	}

	/**
	 * @see	\wcf\form\IForm::save()
	 */
	public function save() {
		parent::save();

		$this->objectAction = new UserGroupPremiumAction(array(), 'create', array(
		    'data' => array(
			'groupID' => $this->groupID,
			'jCoins' => $this->jCoins,
			'period' => $this->period,
			'description' => I18nHandler::getInstance()->isPlainValue('description') ? I18nHandler::getInstance()->getValue('description') : ''
		    )
		));
		$returnValues = $this->objectAction->executeAction();

		// save I18n description
		if (!I18nHandler::getInstance()->isPlainValue('description')) {
			$premiumGroupID = $returnValues['returnValues']->premiumGroupID;

			$updateData = array();
			$updateData['description'] = 'wcf.jcoins.premiumGroups.description' . $premiumGroupID;
			I18nHandler::getInstance()->save('description', $updateData['description'], 'wcf.jcoins');
			
			// update name
			$editor = new UserGroupPremiumEditor($returnValues['returnValues']);
			$editor->update($updateData);
		}

		$this->saved();

		I18nHandler::getInstance()->reset();

		// reset values
		$this->groupID = $this->jCoins = $this->period = 0;

		// show success
		WCF::getTPL()->assign('success', true);
	}

	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		I18nHandler::getInstance()->assignVariables();

		WCF::getTPL()->assign(array(
		    'groupID' => $this->groupID,
		    'jCoins' => $this->jCoins,
		    'period' => $this->period,
		    'groups' => $this->groups
		));
	}

}
