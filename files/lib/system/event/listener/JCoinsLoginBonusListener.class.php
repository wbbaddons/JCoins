<?php
namespace wcf\system\event\listener;
use wcf\data\user\jcoins\statement\UserJcoinsStatementAction;

/**
 * Adds JCoins after a user logged in 
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2015 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class JCoinsLoginBonusListener implements IParameterizedEventListener {

	/**
	 * @see \wcf\system\event\listener\IParameterizedEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName, array &$parameters) {
		if (!JCOINS_RECEIVECOINS_LOGIN || !$eventObj->getUser()->userID) return; 
		
		if (date('Ymd', $eventObj->getUser()->lastActivityTime) < date('Ymd')) {
			$this->statementAction = new UserJcoinsStatementAction(array(), 'create', array(
				'data' => array(
					'userID' => $eventObj->getUser()->userID,
					'reason' => 'wcf.jcoins.statement.login.receive',
					'sum' => JCOINS_RECEIVECOINS_LOGIN
				),
				'changeBalance' => 1
			));
			$this->statementAction->validateAction();
			$this->statementAction->executeAction();
		}
	}
}
