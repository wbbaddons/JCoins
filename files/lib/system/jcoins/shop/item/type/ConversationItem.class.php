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
		
		$paramters = $this->prepare($paramters); 
		
		$data = array(
		    'userID' => WCF::getSession()->userID, 
		    'username' => WCF::getSession()->username, 
		    'time' => TIME_NOW
		); 
		
		$messageData = array('text' => $paramters['text']); 
		
		$action = new ConversationAction(array(), 'create', array('participants' => $paramters['userid'], 'data' => $data, 'messageData' => $messageData));
		$conversation = $action->executeAction(); 
		
		if ($paramters['close'] == 1) {
			$action = new ConversationAction(array($conversation), 'close', array());
			$action->executeAction(); 
		}
		
		return array(
		    'showSuccess' => true
		); 
	}
}