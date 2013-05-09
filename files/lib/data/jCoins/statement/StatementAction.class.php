<?php
namespace wcf\data\jCoins\statement;
use wcf\data\user\UserEditor;
use wcf\data\AbstractDatabaseObjectAction;
use wcf\system\WCF;

/**
 * Provides functions to handle statements.
 * 
 * @author  Joshua Rüsweg
 * @package de.joshsboard.jcoins
 */
class StatementAction extends AbstractDatabaseObjectAction {
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$className
	 */
	protected $className = 'wcf\data\jCoins\statement\StatementEditor';
	
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::validateCreate()
	 */
	public function validateCreate() {
		parent::validateCreate();
		
		$this->readBoolean('changeBalance', true);
		$this->readInteger('executedUserID', true, 'data');
		$this->readInteger('sum', false, 'data');
		$this->readInteger('time', true, 'data');
		$this->readInteger('userID', true, 'data');
		$this->readString('reason', false, 'data');
		
		if (!$this->parameters['data']['time']) {
			$this->parameters['data']['time'] = TIME_NOW;
		}
		if (!$this->parameters['data']['userID']) {
			$this->parameters['data']['userID'] = WCF::getUser()->userID;
		}
	}
	
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::create()
	 */
	public function create() {
		$statement = parent::create();
		
		if ($this->parameters['changeBalance']) {
			$user = $statement->getUser();
			$userEditor = new UserEditor($user);
			$userEditor->updateCounters(array('jCoinsBalance' => $statement->sum));
		}
		
		return $statement;
	}
	
	/**
	 * Validates the trashing of statements.
	 */
	public function validateTrashAll() {
		if (empty($this->objectIDs)) {
			throw new UserInputException('objectIDs');
		}
		
		if (empty($this->objects)) {
			$this->readObjects();
		}
		foreach ($this->objects as $statement) {
			if ($statement->userID != WCF::getUser()->userID) {
				throw new PremissionDeniedException(); 
			}
		}
	}
	
	/**
	 * Marks the given statements as trashed.
	 */
	public function trashAll() {
		$this->parameters['data']['isTrashed'] = 1;
		parent::update();
	}
}
