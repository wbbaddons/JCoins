<?php
namespace wcf\system\event\listener;
use wcf\system\event\IEventListener;
use wcf\data\jCoins\statement\StatementAction;

/**
 * add jcoins on registration
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class JCoinsUserAddListener implements IEventListener {
	/**
	 * @see	\wcf\system\event\IEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if (JCOINS_RECEIVECOINS_USERADD == 0) return;
		if ($eventObj->getActionName() != 'create') return; 
		
		$return = $eventObj->getReturnValues(); 
		
		$this->statementAction = new StatementAction(array(), 'create', array(
			'data' => array(
				'userID' => $return['returnValues']->userID,
				'reason' => 'wcf.jCoins.statement.useradd.recive',
				'sum' => JCOINS_RECEIVECOINS_USERADD
			)
		));
		$this->statementAction->executeAction();
	}
}