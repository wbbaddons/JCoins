<?php
namespace wcf\data\user\jcoins\statement;

use wcf\data\user\UserEditor;
use wcf\data\user\User;
use wcf\data\AbstractDatabaseObjectAction;
use wcf\system\exception\UserInputException;
use wcf\system\WCF;

/**
 * Provides functions to handle statements.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class UserJcoinsStatementAction extends AbstractDatabaseObjectAction {

	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$className
	 */
	protected $className = 'wcf\data\user\jcoins\statement\UserJcoinsStatementEditor';

	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$allowGuestAccess
	 */
	protected $allowGuestAccess = array('create');

	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::validateCreate()
	 */
	public function validateCreate() {
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
		
		if ($this->parameters['data']['userID'] == 0) {
			throw new UserInputException('userID');
		}
		
		if ($this->parameters['data']['executedUserID'] == 0) {
			$this->parameters['data']['executedUserID'] = null;
		}
		
		if (isset($this->parameters['data']['additionalData'])) {
			if (is_array($this->parameters['data']['additionalData'])) {
				$this->parameters['data']['additionalData'] = serialize($this->parameters['data']['additionalData']); 
			} else {
				$test = @unserialize($this->parameters['data']['additionalData']);
				if ($test === false) {
					throw new UserInputException('additionalData');
				}
			}
		} else {
			// we save an empty array yeah! :)
			$this->parameters['data']['additionalData'] = serialize(array()); 
		}
	}

	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::create()
	 */
	public function create() {
		$statement = parent::create();

		if (isset($this->parameters['changeBalance']) && $this->parameters['changeBalance']) {
			$user = new User($this->parameters['data']['userID']);
			$userEditor = new UserEditor($user);
			$userEditor->updateCounters(array('jCoinsBalance' => $statement->sum));
		}

		return $statement;
	}

	public function validateUpdate() {
		parent::validateUpdate();
		
		if (isset($this->parameters['data']['additionalData'])) {
			if (is_array($this->parameters['data']['additionalData'])) {
				$this->parameters['data']['additionalData'] = serialize($this->parameters['data']['additionalData']); 
			} else {
				$test = @unserialize($this->parameters['data']['additionalData']);
				if ($test === false) {
					throw new UserInputException('additionalData');
				}
			}
		}
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
