<?php
namespace wcf\system\event\listener;
use wcf\system\event\IEventListener;
use wcf\data\jCoins\statement\StatementEditor;
use wcf\system\WCF;

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
		
		StatementEditor::create(array(
			'userID'			=> WCF::getUser()->userID,
			'executedUserID'		=> 0, 
			'time'				=> TIME_NOW, 
			'reason'			=> "wcf.jCoins.statement.conversationreplyadd.recive",
			'sum'				=> JCOINS_RECEIVECOINS_ADDCONVERSATIONREPLY
		));
	}
}
