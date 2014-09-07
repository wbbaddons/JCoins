<?php
namespace wcf\system\event\listener;

use wcf\system\event\IEventListener;
use wcf\data\user\jcoins\statement\UserJcoinsStatementAction;
use wcf\system\WCF;

/**
 * Adds jCoins on create a conversation message
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class JCoinsConversationMessageAddListener implements IEventListener {

	/**
	 * @see	wcf\system\event\IEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if (!MODULE_CONVERSATION || !MODULE_JCOINS || JCOINS_RECEIVECOINS_ADDCONVERSATIONREPLY == 0) return;
		if ($eventObj->getActionName() != 'create' && $eventObj->getActionName() != 'quickReply') return;

		// catch 3rdparty plugins, which creates Conversations without an logged in user
		if (WCF::getUser()->userID == 0) return; 
		
		$parameters = $eventObj->getParameters();
		if (isset($parameters['isFirstPost'])) return;
		
		if ($eventObj->getActionName() == 'create') {
			$return = $eventObj->getReturnValues();
			$conversation = $return['returnValues']->getConversation();

			$this->statementAction = new UserJcoinsStatementAction(array(), 'create', array(
			    'data' => array(
				'reason' => 'wcf.jcoins.statement.conversationreplyadd.recive',
				'sum' => JCOINS_RECEIVECOINS_ADDCONVERSATIONREPLY, 
				'additionalData' => array('title' => $conversation->subject), 
				'link' => $return['returnValues']->getLink()
			    ),
			    'changeBalance' => 1
			));
			$this->statementAction->validateAction();
			$this->statementAction->executeAction();
		} else {
			$conversation = new \wcf\data\conversation\Conversation((isset($parameters['objectID'])) ? intval($parameters['objectID']) : 0);
			
			$this->statementAction = new UserJcoinsStatementAction(array(), 'create', array(
				'data' => array(
				    'reason' => 'wcf.jcoins.statement.conversationadd.recive',
				    'sum' => JCOINS_RECEIVECOINS_CREATECONVERSATION,
				    'additionalData' => array('title' => $conversation->subject), 
				    // we havn't a specefic link, 
				    // because the quickreply-editor doesn't gave 
				    // the object and a work-around is an unnecessary additional expenses
				    'link' => \wcf\system\request\LinkHandler::getInstance()->getLink('Conversation', array('object' => $conversation)) 
				),
				'changeBalance' => 1
			    ));
			$this->statementAction->validateAction();
			$this->statementAction->executeAction();
		}
	}

}
