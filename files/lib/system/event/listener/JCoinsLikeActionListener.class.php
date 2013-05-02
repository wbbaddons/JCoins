<?php
namespace wcf\system\event\listener;
use wcf\system\event\IEventListener;
use wcf\data\jCoins\statement\StatementEditor;
use wcf\data\like\object\LikeObject;
use wcf\data\object\type\ObjectTypeCache;
use wcf\data\like\Like;

/**
 * add jcoins on like an object
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class JCoinsLikeActionListener implements IEventListener {
	/**
	 * @see	\wcf\system\event\IEventListener::execute()
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
	    
		switch ($returnValues['oldValue']) {
			case Like::LIKE:
                            if (JCOINS_RECEIVECOINS_LIKE != 0) {
                                    StatementEditor::create(array(
                                            'userID'			=> $like->objectUserID,
                                            // executed by the System
                                            'executedUserID'		=> 0, 
                                            'time'				=> TIME_NOW, 
                                            'reason'			=> "wcf.jCoins.statement.like.revoke", // @TODO
                                            'sum'				=> JCOINS_RECEIVECOINS_LIKE * -1 
                                    ));
                                }
				break; 
		    
			case Like::DISLIKE: 
                                if (JCOINS_RECEIVECOINS_DISLIKE != 0) {
                                    StatementEditor::create(array(
                                            'userID'			=> $like->objectUserID,
                                            // executed by the System
                                            'executedUserID'		=> 0, 
                                            'time'				=> TIME_NOW, 
                                            'reason'			=> "wcf.jCoins.statement.dislike.revoke", // @TODO
                                            'sum'				=> JCOINS_RECEIVECOINS_DISLIKE * -1 
                                    ));
                                }
				break; 
		}
	    
	    switch ($returnValues['newValue']) {
		    case Like::LIKE: 
                        if (JCOINS_RECEIVECOINS_LIKE != 0) {
			StatementEditor::create(array(
			    'userID'		=> $like->objectUserID,
			    // executed by the System
			    'executedUserID'	=> 0, 
			    'time'		=> TIME_NOW, 
			    'reason'		=> "wcf.jCoins.statement.like.recive",
			    'sum'		=> JCOINS_RECEIVECOINS_LIKE
			));
                        }
			break; 
		    
			case Like::DISLIKE:
				if (JCOINS_RECEIVECOINS_DISLIKE != 0) {
				    StatementEditor::create(array(
					'userID'		=> $like->objectUserID,
					'executedUserID'	=> 0, 
					'time'		=> TIME_NOW, 
					'reason'		=> "wcf.jCoins.statement.dislike.recive",
					'sum'		=> JCOINS_RECEIVECOINS_DISLIKE
				    ));
			    }
			    break;
	    }
	}
}