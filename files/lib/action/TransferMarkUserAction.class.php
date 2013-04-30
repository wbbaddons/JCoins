<?php
namespace wcf\action;
use wcf\system\clipboard\ClipboardHandler;
use wcf\system\exception\AJAXException;
use wcf\system\exception\ValidateActionException;
use wcf\util\ClassUtil;
use wcf\util\JSON;
use wcf\util\StringUtil;

class TransferMarkUserAction extends AbstractSecureAction {
	/**
	 * IDatabaseObjectAction object
	 * @var	wcf\data\IDatabaseObjectAction
	 */
	protected $objectAction = null;
	
	/**
	 * list of parameters
	 * @var	array
	 */
hermann	}
	
	/**
	 * @see	wcf\action\IAction::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_POST['parameters']) && is_array($_POST['parameters'])) $this->parameters = $_POST['parameters'];
		if (isset($_POST['typeName'])) $this->typeName = StringUtil::trim($_POST['typeName']);
	}
	
	/**
	 * Validates parameters.
	 */
	protected function validate() {
		if (!isset($this->parameters['actionName']) || empty($this->parameters['actionName'])) {
			throw new AJAXException("missing action name");
		}
		
		if (!isset($this->parameters['userID']) || empty($this->parameters['userID'])) {
			throw new AJAXException("missing userID name");
		} else {
			$this->parameters['userID'] = array($this->parameters['userID']);
		}
	}

	/**
	 * @see	wcf\action\IAction::execute()
	 */
	public function execute() {
		parent::execute();
		
	    	$returnValues = array();
		switch ($this->parameters['actionName']) {
			case 'mark':
				$userIDs = WCF::getSession()->getVar('__markedUserTransferJCoins');
			    
				if ($userIDs === null) $userIDs = array(); 
			    
				// erkenne doppelte 
				foreach ($userIDs AS $userID) {
				    foreach ($this->parameters['userID'] AS $id => $toMarkUserID) {
					if ($userID == $toMarkUserID) {
					    $this->objectTypes[$id] = null; 
					}
				    }
				}
				
				WCF::getSession()->register('__markedUserTransferJCoins', array(
					'userIDs' => array_merge($userIDs, $this->parameters['userID'])
				));
			break;
		}
		
		$this->executed();
		
		// force session update
		WCF::getSession()->update();
		WCF::getSession()->disableUpdate();
		
		if ($returnValues !== null) {
			// send JSON-encoded response
			header('Content-type: application/json');
			echo JSON::encode($returnValues);
		}
		
		exit;
	}
}