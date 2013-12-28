<?php
namespace wcf\system\event\listener;

use wcf\system\event\IEventListener;
use wcf\data\user\jcoins\statement\UserJcoinsStatementAction;

/**
 * Adds jCoins on create a conversation message
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class JCoinsConversationMessageAddListener implements IEventListener {

	/**
	 * @see	wcf\system\event\IEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if (!MODULE_CONVERSATION || !MODULE_JCOINS || JCOINS_RECEIVECOINS_ADDCONVERSATIONREPLY == 0) return;
		if ($eventObj->getActionName() != 'create' && $eventObj->getActionName() != 'quickReply') return;

		$parameters = $eventObj->getParameters();
		if (isset($parameters['isFirstPost'])) return;

		$this->statementAction = new UserJcoinsStatementAction(array(), 'create', array(
		    'data' => array(
			'reason' => 'wcf.jcoins.statement.conversationreplyadd.recive',
			'sum' => JCOINS_RECEIVECOINS_ADDCONVERSATIONREPLY
		    ),
		    'changeBalance' => 1
		));
		$this->statementAction->validateAction();
		$this->statementAction->executeAction();
	}

}
