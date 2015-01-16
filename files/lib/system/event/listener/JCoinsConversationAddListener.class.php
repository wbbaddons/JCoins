<?php
namespace wcf\system\event\listener;
use wcf\data\user\jcoins\statement\UserJcoinsStatementAction;
use wcf\system\WCF;

/**
 * Adds jCoins on create a conversation
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class JCoinsConversationAddListener implements IParameterizedEventListener {

	/**
	 * @see \wcf\system\event\listener\IParameterizedEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName, array &$parameters) {
		if (!MODULE_CONVERSATION || !MODULE_JCOINS || JCOINS_RECEIVECOINS_CREATECONVERSATION == 0) return;
		if ($eventObj->getActionName() != 'create') return;
		
		// catch 3rdparty plugins, which creates Conversations without an logged in user
		if (WCF::getUser()->userID == 0) return; 
		
		$return = $eventObj->getReturnValues();
		
		$this->statementAction = new UserJcoinsStatementAction(array(), 'create', array(
		    'data' => array(
			'reason' => 'wcf.jcoins.statement.conversationadd.recive',
			'sum' => JCOINS_RECEIVECOINS_CREATECONVERSATION,
			'additionalData' => array('title' => $return['returnValues']->subject), 
			'link' => \wcf\system\request\LinkHandler::getInstance()->getLink('Conversation', array('object' => $return['returnValues']))
		    ),
		    'changeBalance' => 1
		));
		$this->statementAction->validateAction();
		$this->statementAction->executeAction();
	}

}