<?php
namespace wcf\data\user\group\premiumGroup; 

use wcf\data\jCoins\statement\StatementAction;
use wcf\data\user\UserEditor;
use wcf\data\AbstractDatabaseObjectAction;
use wcf\data\IToggleAction;
use wcf\system\database\util\PreparedStatementConditionBuilder;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\user\storage\UserStorageHandler;
use wcf\system\WCF;

/**
 * Provides functions to handle premium-groups.
 * 
 * @author  Joshua Rüsweg
 * @package de.joshsboard.jcoins
 */
class PremiumGroupAction extends AbstractDatabaseObjectAction implements IToggleAction {
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$className
	 */
	protected $className = 'wcf\data\user\group\premiumGroup\PremiumGroupEditor';

	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$permissionsDelete
	 */
	protected $permissionsDelete = array('admin.jCoins.premiumgroups.canEditPremiumGroups');

	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$permissionsUpdate
	 */
	protected $permissionsUpdate = array('admin.jCoins.premiumgroups.canEditPremiumGroups');

	/**
	 * @see	wcf\data\IToggleAction::validateToggle()
	 */
	public function validateToggle() {
		parent::validateUpdate();
	}

	/**
	 * @see	wcf\data\IToggleAction::toggle()
	 */
	public function toggle() {
		foreach ($this->objects as $premiumGroup) {
			$premiumGroup->update(array(
				'isDisabled' => $premiumGroup->isDisabled ? 0 : 1
			));
		}
	}
	
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::validateDelete()
	 */
	public function validateDelete() {
		parent::validateDelete(); 
		
		foreach ($this->objects as $premiumGroup) {
			if (!$premiumGroup->isDeletable()) throw new PermissionDeniedException();
		}
	}
	
	/**
	 * Validates the purchase of premium-groups.
	 */
	public function validateBuyGroup() {
		if (!MODULE_JCOINS) throw new IllegalLinkException(); 
		
		if (empty($this->objects)) {
			$this->readObjects();
		}
		
		foreach ($this->objects as $premiumGroup) {
			if ($premiumGroup->isDisabled) throw new IllegalLinkException(); 
			if (WCF::getUser()->jCoinsBalance < $premiumGroup->jCoins) throw new PermissionDeniedException(); 
		}
	}
	
	/**
	 * Does the purchase of premium-groups.
	 */
	public function buyGroup() {
		foreach ($this->objects as $premiumGroup) {
			$this->statementAction = new StatementAction(array(), 'create', array(
				'data' => array(
					'reason' => 'wcf.jCoins.premiumgroups.statement.buy',
					'sum' => $premiumGroup->jCoins * -1, 
				), 
				'changeBalance' => 1
			));
			$this->statementAction->validateAction();
			$this->statementAction->executeAction();
                       
                        $condition = new PreparedStatementConditionBuilder();
                        $condition->add('userID = ?', array(WCF::getUser()->userID));
                        $condition->add('premiumGroupID = ?', array($premiumGroup->premiumGroupID));
                        
			$sql = "SELECT	COUNT(*)
				FROM	wcf".WCF_N."_user_to_group_premium ".
				$condition;
			$statement = WCF::getDB()->prepareStatement($sql);
			$statement->execute($condition->getParameters());

			if (!$statement->fetchColumn()) {
				$sql = "INSERT INTO	wcf".WCF_N."_user_to_group_premium
							(userID, premiumGroupID, until)
					VALUES		(?, ?, ?)";
				$statement = WCF::getDB()->prepareStatement($sql);
				$statement->execute(array(
					WCF::getUser()->userID,
					$premiumGroup->premiumGroupID, 
					TIME_NOW + $premiumGroup->period
				));
			} 
			else {
				// update until
				$condition = new PreparedStatementConditionBuilder();
				$condition->add('userID = ?', array(WCF::getUser()->userID));
				$condition->add('premiumGroupID = ?', array($premiumGroup->premiumGroupID));
				
				$sql = "UPDATE	wcf".WCF_N."_user_to_group_premium
					SET	
						until = (until + ".$premiumGroup->period.") "
					.$condition; 
				$statement = WCF::getDB()->prepareStatement($sql);
				$statement->execute($condition->getParameters());
			}
			
			$condition = new PreparedStatementConditionBuilder();
			$condition->add('userID = ?', array(WCF::getUser()->userID));
			$condition->add('groupID = ?', array($premiumGroup->premiumGroupID));
			
                        $sql = "SELECT	until
                            	FROM	wcf".WCF_N."_user_to_group_temp ".
                            	$condition;
                        $statement = WCF::getDB()->prepareStatement($sql);
                        $statement->execute($condition->getParameters());
                        
                        if ($statement->fetchColumn()) {
                                $sql = "UPDATE 	wcf".WCF_N."_user_to_group_temp
                                	SET 	until = ? "
                                	.$condition;
                                $statement = WCF::getDB()->prepareStatement($sql);
                                $statement->execute(array_unshift($condition->getParameters(), $statement->fetchColumn() + $premiumGroup->period));
                        } 
                        else {
                                $sql = "INSERT INTO wcf".WCF_N."_user_to_group_temp
                                        	(until, userID, groupID)
                                    VALUES	(?, ?, ?)";
                                $statement = WCF::getDB()->prepareStatement($sql);
                                $statement->execute(array(
                                        $premiumGroup->period,
                                        WCF::getUser()->userID, 
                                        $premiumGroup->groupID
                                ));
                        }
                        
			$editor = new UserEditor(WCF::getUser()); 
			$editor->addToGroup($premiumGroup->groupID);
			$editor->resetCache(); 
			
			// reset storage
			UserStorageHandler::getInstance()->reset(array(WCF::getUser()->userID), 'premiumGroupIDs');
		}
	}
}
