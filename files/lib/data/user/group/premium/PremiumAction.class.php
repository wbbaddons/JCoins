<?php
namespace wcf\data\user\group\premium;

use wcf\data\AbstractDatabaseObjectAction;
use wcf\data\IToggleAction;
use wcf\data\user\jcoins\statement\StatementAction;
use wcf\data\user\UserAction;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\user\storage\UserStorageHandler;
use wcf\system\WCF;

/**
 * Provides functions to handle premium-groups.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class PremiumAction extends AbstractDatabaseObjectAction implements IToggleAction {

	/**
	 * @see	\wcf\data\AbstractDatabaseObjectAction::$className
	 */
	protected $className = 'wcf\data\user\group\premium\PremiumEditor';

	/**
	 * @see	\wcf\data\AbstractDatabaseObjectAction::$permissionsDelete
	 */
	protected $permissionsDelete = array('admin.jcoins.premiumgroups.canEditPremiumGroups');

	/**
	 * @see	\wcf\data\AbstractDatabaseObjectAction::$permissionsUpdate
	 */
	protected $permissionsUpdate = array('admin.jcoins.premiumgroups.canEditPremiumGroups');

	/**
	 * @see	\wcf\data\IToggleAction::validateToggle()
	 */
	public function validateToggle() {
		$this->validateUpdate();
	}

	/**
	 * @see	\wcf\data\IToggleAction::toggle()
	 */
	public function toggle() {
		foreach ($this->objects as $premiumGroup) {
			$premiumGroup->update(array(
			    'isDisabled' => ($premiumGroup->isDisabled ? 0 : 1)
			));
		}
	}

	/**
	 * @see	\wcf\data\AbstractDatabaseObjectAction::validateDelete()
	 */
	public function validateDelete() {
		parent::validateDelete();

		foreach ($this->objects as $premiumGroup) {
			if (!$premiumGroup->isDeletable())
				throw new PermissionDeniedException();
		}
	}

	/**
	 * Validates the purchase of premium-groups.
	 */
	public function validateBuyGroup() {
		if (!MODULE_JCOINS || !MODULE_JCOINS_PREMIUMGROUPS)
			throw new IllegalLinkException();

		if (empty($this->objects)) {
			$this->readObjects();
		}

		foreach ($this->objects as $premiumGroup) {
			if ($premiumGroup->isDisabled)
				throw new IllegalLinkException();
			
			// admin groups can not be bought
			if ($premiumGroup->getGroup()->isAdminGroup())
				throw new PermissionDeniedException(); 
			
			if (WCF::getUser()->jCoinsBalance < $premiumGroup->jCoins)
				throw new PermissionDeniedException();
		}
	}

	/**
	 * Does the purchase of premium-groups.
	 */
	public function buyGroup() {
		foreach ($this->objects as $premiumGroupEditor) {
			$this->statementAction = new StatementAction(array(), 'create', array(
			    'data' => array(
				'reason' => 'wcf.jcoins.premiumgroups.statement.buy',
				'sum' => -$premiumGroupEditor->jCoins,
			    ),
			    'changeBalance' => 1
			));
			$this->statementAction->validateAction();
			$this->statementAction->executeAction();

			$premiumGroupEditor->insertPremiumGroup();

			$action = new UserAction(array(WCF::getUser()), 'addToGroups', array(
				'groups' => array($premiumGroupEditor->groupID),
				'addDefaultGroups' => false,
				'deleteOldGroups' => false
			));
			$action->executeAction();

			// reset storage
			UserStorageHandler::getInstance()->reset(array(WCF::getUser()->userID), 'jCoinsPremiumGroupIDs');
		}
	}

	public function validateUpdateGroup() {
		$this->validateBuyGroup();
	}

	public function updateGroup() {
		foreach ($this->objects as $premiumGroupEditor) {
			$this->statementAction = new StatementAction(array(), 'create', array(
			    'data' => array(
				'reason' => 'wcf.jcoins.premiumgroups.statement.update',
				'sum' => -$premiumGroupEditor->jCoins,
			    ),
			    'changeBalance' => 1
			));
			$this->statementAction->validateAction();
			$this->statementAction->executeAction();

			$premiumGroupEditor->updatePremiumGroup();

			// reset storage
			UserStorageHandler::getInstance()->reset(array(WCF::getUser()->userID), 'jCoinsPremiumGroupIDs');
		}
	}

}
