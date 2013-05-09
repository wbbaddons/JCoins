<?php
namespace wcf\data\jCoins\statement;
use wcf\data\AbstractDatabaseObjectAction;
use wcf\system\WCF;

/**
 * premium group action 
 * 
 * @author  Joshua Rüsweg
 * @package de.joshsboard.jcoins
 */
class StatementAction extends AbstractDatabaseObjectAction {
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$className
	 */
	protected $className = 'wcf\data\jCoins\statement\StatementEditor';
	
	public function validateTrashAll() {
		// read objects
		if (empty($this->objects)) {
			$this->readObjects();

			if (empty($this->objects)) {
				throw new UserInputException('objectIDs');
			}
		}

		foreach ($this->objects as $statement) {
			if ($statement->userID != WCF::getUser()->userID) throw new PremissionDeniedException(); 
		}
	}
	
	public function trashAll() {
		$sql = "UPDATE SET isTrashed = 1 WHERE entryID IN ?";
		$objects = "";
		foreach ($this->objects as $statement) {
			if (empty($objects)) {
				$objects = "(".$statement->entryID; 
			} else {
				$objects .= ", ".$statement->entryID;
			}
		}
		$objects .= ")";
		
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array(
			$objects
		));
	}
}