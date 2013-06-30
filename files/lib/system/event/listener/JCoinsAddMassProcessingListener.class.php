<?php
namespace wcf\system\event\listener;
use wcf\system\event\IEventListener;
use wcf\system\exception\UserInputException;
use wcf\system\WCF;

/**
 * add jcoins mass processsing
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class JCoinsAddMassProcessingListener implements IEventListener {
	/**
	 * @see	\wcf\system\event\IEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if (!MODULE_JCOINS) return;
		
		switch ($eventName) {
			case 'readFormParameters': 
				$eventObj->reason = (isset($_POST['reason'])) ? StringUtil::trim($_POST['reason']) : ""; 
				$eventObj->sum = (isset($_POST['sum'])) ? intval($_POST['sum']) : 0; 
				$eventObj->fromUser = (isset($_POST['fromUser']) && $_POST['fromUser'] != 0) ? WCF::getUser()->userID : 0; 
				break; 
			    
			case 'validate':
				$eventObj->availableActions[] = "addJCoins"; 
			    
				if ($eventObj->reason == "") {
					throw new UserInputException('reason');
				}
				break;
				
			case 'saved': 
				if ($eventObj->action != 'addJCoins') return; 
				
				WCF::getSession()->checkPermissions(array('admin.jcoins.canExecuteMassProcessing'));
				
				$userTransferData = WCF::getSession()->getVar('userTransferData');
				if ($userTransferData === null) $userTransferData = array();
				$transferID = count($userTransferData);
				$userTransferData[$transferID] = array(
					'sum' => $eventObj->sum,
					'reason' => $eventObj->reason,
					'fromUser' => $eventObj->fromUser, 
					'userIDs' => $eventObj->fetchUsers()
				);
				WCF::getSession()->register('userTransferData', $userTransferData);

				WCF::getTPL()->assign('transferID', $transferID);
				break; 
				
			case 'assignVariables': 
				WCF::getTPL()->assign(array(
					'sum' => (isset($eventObj->sum)) ? $eventObj->sum : 0, 
					'reason' => (isset($eventObj->reason)) ? $eventObj->reason : 0, 
					'fromUser' => (isset($eventObj->fromUser)) ? $eventObj->fromUser : 0
				)); 
				break; 
		}
	}
}