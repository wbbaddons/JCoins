<?php
namespace wcf\system\event\listener;

use wcf\system\event\IEventListener;
use wcf\data\user\jcoins\statement\UserJcoinsStatementAction;
use wcf\system\WCF;

/**
 * Adds jCoins on create a conversation
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class JCoinsConversationAddListener implements IEventListener {

	/**
	 * @see	wcf\system\event\IEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if (!MODULE_CONVERSATION || !MODULE_JCOINS || JCOINS_RECEIVECOINS_CREATECONVERSATION == 0) return;
		if ($eventObj->getActionName() != 'create') return;
		
		// catch 3rdparty plugins, which creates Conversations without an logged in user
		if (WCF::getUser()->userID == 0) return; 
		
		$this->statementAction = new UserJcoinsStatementAction(array(), 'create', array(
		    'data' => array(
			'reason' => 'wcf.jcoins.statement.conversationadd.recive',
			'sum' => JCOINS_RECEIVECOINS_CREATECONVERSATION,
		    ),
		    'changeBalance' => 1
		));
		$this->statementAction->validateAction();
		$this->statementAction->executeAction();
	}

}