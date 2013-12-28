<?php
namespace wcf\system\event\listener;

use wcf\system\event\IEventListener;
use wcf\data\user\jcoins\statement\UserJcoinsStatementAction;

/**
 * Adds jCoins on registration
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class JCoinsUserAddListener implements IEventListener {

	/**
	 * @see	wcf\system\event\IEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if (JCOINS_RECEIVECOINS_USERADD == 0) return;
		if ($eventObj->getActionName() != 'create') return;

		$return = $eventObj->getReturnValues();

		$this->statementAction = new UserJcoinsStatementAction(array(), 'create', array(
		    'data' => array(
			'userID' => $return['returnValues']->userID,
			'reason' => 'wcf.jcoins.statement.useradd.recive',
			'sum' => JCOINS_RECEIVECOINS_USERADD
		    ),
		    'changeBalance' => 1
		));
		$this->statementAction->validateAction();
		$this->statementAction->executeAction();
	}

}