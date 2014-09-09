<?php
namespace wcf\system\event\listener;

use wcf\system\event\IEventListener;
use wcf\data\user\jcoins\statement\UserJcoinsStatementAction;
use wcf\data\object\type\ObjectTypeCache;
use wcf\data\like\Like;
use wcf\util\StringUtil; 

/**
 * Adds jCoins on like an object
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class JCoinsLikeActionListener implements IEventListener {

	/**
	 * @see	wcf\system\event\IEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {

		if (MODULE_JCOINS == 0 || MODULE_LIKE == 0) {
			return;
		}

		switch ($eventObj->getActionName()) {
			case 'like':
			case 'dislike':
				break;
			default:
				return;
		}

		$returnValues = $eventObj->getReturnValues();
		$returnValues = $returnValues['returnValues'];
		$objectID = $eventObj->getParameters();
		
		$like = ObjectTypeCache::getInstance()->getObjectTypeByName('com.woltlab.wcf.like.likeableObject', $objectID['data']['objectType'])->getProcessor()->getObjectByID($objectID['data']['objectID']);
		
		// the object-user-id is unknown
		if (!$like->userID) {
			return; 
		}
		
		$addtionalData = array('username' => \wcf\system\WCF::getUser()->username); 
		
		if ($like->getObjectID() != 0) {
			$addtionalData['title'] = $like->getTitle(); 
		}
		
		// because a title which is to long is uncool (profile-comments)
		if (isset($addtionalData['title']) && StringUtil::length($addtionalData['title']) > 30) {
			$addtionalData['title'] = StringUtil::substring($addtionalData['title'], 0, 26);
			$addtionalData['title'] .= '...';
		}
		
		switch ($returnValues['oldValue']) {
			case Like::LIKE:
				if (JCOINS_RECEIVECOINS_LIKE != 0) {
					$this->statementAction = new UserJcoinsStatementAction(array(), 'create', array(
					    'data' => array(
						'userID' => $like->objectUserID,
						'reason' => 'wcf.jcoins.statement.like.revoke',
						'sum' => JCOINS_RECEIVECOINS_LIKE * -1, 
						'link' => $like->getURL(), 
						'additionalData' => $addtionalData
					    ),
					    'changeBalance' => 1
					));
					$this->statementAction->validateAction();
					$this->statementAction->executeAction();
				}
				break;

			case Like::DISLIKE:
				if (JCOINS_RECEIVECOINS_DISLIKE != 0) {
					$this->statementAction = new UserJcoinsStatementAction(array(), 'create', array(
					    'data' => array(
						'userID' => $like->objectUserID,
						'reason' => 'wcf.jcoins.statement.dislike.revoke',
						'sum' => JCOINS_RECEIVECOINS_DISLIKE * -1, 
						'link' => $like->getURL(), 
						'additionalData' => $addtionalData
					    ),
					    'changeBalance' => 1
					));
					$this->statementAction->validateAction();
					$this->statementAction->executeAction();
				}
				break;
		}

		switch ($returnValues['newValue']) {
			case Like::LIKE:
				if (JCOINS_RECEIVECOINS_LIKE != 0) {
					$this->statementAction = new UserJcoinsStatementAction(array(), 'create', array(
					    'data' => array(
						'userID' => $like->objectUserID,
						'reason' => 'wcf.jcoins.statement.like.recive',
						'sum' => JCOINS_RECEIVECOINS_LIKE, 
						'link' => $like->getURL(), 
						'additionalData' => $addtionalData
					    ),
					    'changeBalance' => 1
					));
					$this->statementAction->validateAction();
					$this->statementAction->executeAction();
				}
				break;

			case Like::DISLIKE:
				if (JCOINS_RECEIVECOINS_DISLIKE != 0) {
					$this->statementAction = new UserJcoinsStatementAction(array(), 'create', array(
					    'data' => array(
						'userID' => $like->objectUserID,
						'reason' => 'wcf.jcoins.statement.dislike.recive',
						'sum' => JCOINS_RECEIVECOINS_DISLIKE, 
						'link' => $like->getURL(), 
						'additionalData' => $addtionalData
					    ),
					    'changeBalance' => 1
					));
					$this->statementAction->validateAction();
					$this->statementAction->executeAction();
				}
				break;
		}
	}

}
