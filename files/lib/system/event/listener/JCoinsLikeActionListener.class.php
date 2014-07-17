<?php
namespace wcf\system\event\listener;

use wcf\system\event\IEventListener;
use wcf\data\user\jcoins\statement\UserJcoinsStatementAction;
use wcf\data\like\object\LikeObject;
use wcf\data\object\type\ObjectTypeCache;
use wcf\data\like\Like;

/**
 * Adds jCoins on like an object
 * 
 * @author	Joshua Rüsweg
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

		$objTID = ObjectTypeCache::getInstance()->getObjectTypeByName('com.woltlab.wcf.like.likeableObject', $objectID['data']['objectType']);
		$like = LikeObject::getLikeObject($objTID->objectTypeID, $objectID['data']['objectID']);
		$likedObject = $like->getLikedObject(); 
		
		switch ($returnValues['oldValue']) {
			case Like::LIKE:
				if (JCOINS_RECEIVECOINS_LIKE != 0) {
					$this->statementAction = new UserJcoinsStatementAction(array(), 'create', array(
					    'data' => array(
						'userID' => $like->objectUserID,
						'reason' => 'wcf.jcoins.statement.like.revoke',
						'sum' => JCOINS_RECEIVECOINS_LIKE * -1, 
						'link' => $likedObject->getURL(), 
						'additionalData' => array('title' => $likedObject->getTitle(), 'username' => \wcf\system\WCF::getUser()->username)
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
						'link' => $likedObject->getURL(), 
						'additionalData' => array('title' => $likedObject->getTitle(), 'username' => \wcf\system\WCF::getUser()->username)
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
						'link' => $likedObject->getURL(), 
						'additionalData' => array('title' => $likedObject->getTitle(), 'username' => \wcf\system\WCF::getUser()->username)
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
						'link' => $likedObject->getURL(), 
						'additionalData' => array('title' => $likedObject->getTitle(), 'username' => \wcf\system\WCF::getUser()->username)
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