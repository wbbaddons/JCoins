<?php
namespace wcf\data\jCoins\premiumGroup;
use wcf\data\user\UserEditor;
use wcf\data\AbstractDatabaseObjectAction;
use wcf\data\IToggleAction;
use wcf\data\user\User;
use wcf\system\WCF;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\data\jCoins\statement\StatementEditor;

/**
 * premium group action 
 * 
 * @author  Joshua Rüsweg
 * @package de.joshsboard.jcoins
 */
class PremiumGroupAction extends AbstractDatabaseObjectAction implements IToggleAction {
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$className
	 */
	protected $className = 'wcf\data\jCoins\premiumGroup\PremiumGroupEditor';

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
		foreach ($this->objects as $pGroup) {
			$pGroup->update(array(
				'isDisabled' => $pGroup->isDisabled ? 0 : 1
			));
		}
	}
	
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::validateDelete()
	 */
	public function validateDelete() {
		parent::validateDelete(); 
		
		foreach ($this->objects as $pGroup) {
			if (!$pGroup->isDeletable()) throw new PermissionDeniedException();
		}
	}
	
	/**
	 * validate a buy group action
	 */
	public function validateBuyGroup() {
		if (!MODULE_JCOINS) throw new IllegalLinkException(); 
	    
		// read objects
		if (empty($this->objects)) {
			$this->readObjects();
			
			if (empty($this->objects)) {
				throw new UserInputException('objectIDs');
			}
		}
		
		foreach ($this->objects as $pGroup) {
			if ($pGroup-isDisabled) throw new IllegalLinkException(); 
			if (WCF::getUser()->jCoinsBalance < $pGroup->getJCoins()) throw new PermissionDeniedException(); 
		}
	}
	
	/**
	 * buy a premium group
	 */
	public function buyGroup() {
		foreach ($this->objects as $pGroup) {
                        StatementEditor::create(array(
				'userID'		=> WCF::getUser()->userID, 
				'executedUserID'	=> 0, 
				'time'			=> TIME_NOW,
				'reason'		=> 'wcf.jCoins.premiumgroups.statement.buy', 
				'sum'			=> $pGroup->jCoins * -1
			)); 
			
			$sql = "SELECT	COUNT(*) AS count
				FROM	wcf".WCF_N."_user_to_group_premium
				WHERE	userID = ?
					AND premiumGroupID = ?";
			$statement = WCF::getDB()->prepareStatement($sql);
			$statement->execute(array(
				WCF::getUser()->userID,
				$pGroup->premiumGroupID
			));
			$row = $statement->fetchArray();

			if (!$row['count']) {
				$sql = "INSERT INTO	wcf".WCF_N."_user_to_group_premium
							(userID, premiumGroupID, until)
					VALUES		(?, ?, ?)";
				$statement = WCF::getDB()->prepareStatement($sql);
				$statement->execute(array(
					WCF::getUser()->userID,
					$pGroup->premiumGroupID, 
					TIME_NOW + $pGroup->period
				));
			} else {
				// update until
				$sql = "UPDATE	wcf".WCF_N."_user_to_group_premium
					SET	
						until = (until + ". $pGroup->getPeriod() .")
					WHERE 
						userID = ? AND premiumGroupID = ? "; 
				$statement = WCF::getDB()->prepareStatement($sql);
				$statement->execute(array(
					WCF::getUser()->userID,
					$pGroup->premiumGroupID
				));
			}
			
                        $sql = "SELECT until
                            FROM	wcf".WCF_N."_user_to_group_temp
                            WHERE userID = ? AND groupID = ?";
                        
                        $statement = WCF::getDB()->prepareStatement($sql);
                        $statement->execute(array(
                                WCF::getUser()->userID, 
                                $pGroup->groupID
                        ));
                        $row = $statement->fetchArray();
                        
                        if (isset($row['until'])) {
                                $sql = "UPDATE wcf".WCF_N."_user_to_group_temp SET until = ? WHERE userID = ? AND groupID = ?";
                                $statement = WCF::getDB()->prepareStatement($sql);
                                $statement->execute(array(
                                        $row['until'] + $pGroup->period,
                                        WCF::getUser()->userID, 
                                        $pGroup->groupID
                                ));
                        } else {
                                $sql = "INSERT INTO wcf".WCF_N."_user_to_group_temp
                                        (until, userID, groupID)
                                    VALUES
                                        (?, ?, ?)";
                                $statement = WCF::getDB()->prepareStatement($sql);
                                $statement->execute(array(
                                        $pGroup->getPeriod(),
                                        WCF::getUser()->userID, 
                                        $pGroup->groupID
                                ));
                        }
                        
			$editor = new UserEditor(new User(WCF::getUser()->userID)); 
			$editor->addToGroup($pGroup->groupID);
			$editor->resetCache(); 
		}
	}
}
