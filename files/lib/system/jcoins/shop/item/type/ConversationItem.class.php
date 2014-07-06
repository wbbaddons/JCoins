<?php
namespace wcf\system\jcoins\shop\item\type; 

use wcf\data\conversation\ConversationAction; 
use wcf\system\WCF; 

class ConversationItem extends \wcf\system\jcoins\shop\item\type\ShopItem {
	
	public static function getIdentifer() {
		return 'conversation';
	}
	
	public function boughtAction(array $paramters) {
		parent::boughtAction($paramters);
		
		return array(
		    'showSuccess' => true
		); 
	}
	
	public function buy(array $paramters) {
		parent::buy($paramters);
		
		$paramters = $this->prepare($paramters);
                
		$data = array(
		    'userID' => WCF::getSession()->userID, 
		    'username' => WCF::getSession()->getUser()->username, 
		    'time' => TIME_NOW, 
		    'isDraft' => 0, 
		    'participantCanInvite' => 0, 
		    'subject' => $paramters['subject']
		); 
		
		$messageData = array(
			'message' => $paramters['text'],
			'enableBBCodes' => 1, 
			'enableHtml' => 0, 
			'enableSmilies' => 1, 
			'showSignature' => 1
		); 
		
		$conversationData = array(
		    'data' => $data, 
		    'messageData' => $messageData, 
		    'participants' => array($paramters['userid'])
		); 
		
		
		$action = new ConversationAction(array(), 'create', $conversationData);
		$conversation = $action->executeAction(); 
		
		if ($paramters['close'] == 1) {
			$action = new ConversationAction(array($conversation['returnValues']), 'close', array());
			$action->executeAction(); 
		}
		
		return array(
		    'showSuccess' => true
		); 
	}
}