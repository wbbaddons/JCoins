<?php
namespace wcf\system\event\listener;
use wcf\system\event\IEventListener;
use wcf\data\jCoins\statement\StatementAction;

/**
 * add jcoins on create an conversation message
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class JCoinsConversationMessageAddListener implements IEventListener {
	/**
	 * @see	\wcf\system\event\IEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if (!MODULE_CONVERSATION || !MODULE_JCOINS || JCOINS_RECEIVECOINS_ADDCONVERSATIONREPLY == 0) return;
		if ($eventObj->getActionName() != 'create' && $eventObj->getActionName() != 'quickReply') return; 
		
		$this->statementAction = new StatementAction(array(), 'create', array(
			'data' => array(
				'reason' => 'wcf.jCoins.statement.conversationreplyadd.recive',
				'sum' => JCOINS_RECEIVECOINS_ADDCONVERSATIONREPLY
			), 
                        'changeBalance' => 1
		));
                $this->statementAction->validateAction();
		$this->statementAction->executeAction();
	}
}
