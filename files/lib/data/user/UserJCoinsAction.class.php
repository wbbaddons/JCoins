<?php
namespace wcf\data\user; 

use wcf\data\user\jcoins\statement\UserJcoinsStatementList; 
use wcf\data\user\jcoins\statement\UserJcoinsStatementAction; 
use wcf\system\database\util\PreparedStatementConditionBuilder; 
use wcf\system\WCF; 

/**
 * Executes user-related jcoins actions.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 * @subpackage	data.user
 * @category	Community Framework
 */
class UserJCoinsAction extends \wcf\data\user\UserAction {
	/**
	 * @see	\wcf\data\AbstractDatabaseObjectAction::$requireACP
	 */
	protected $requireACP = array('create', 'ban', 'delete', 'disable', 'enable', 'unban', 'resetJCoins');
	
	/**
	 * reset the jcoins for user
	 */
	public function resetJCoins() {
		$condition = new PreparedStatementConditionBuilder(); 
		$condition->add('user.userID IN (?)', $this->objectIDs);
		
		// reset it, without set transfer-log
		$stmt = WCF::getDB()->prepareStatement('UPDATE wcf'.WCF_N.'_user user SET user.jCoinsBalance = 0 '.$condition);
		$stmt->execute($condition->getParameters());
		
		// trash statements
		$list = new UserJcoinsStatementList();
		$list->getConditionBuilder()->add('user_jcoins_statement.userID IN (?)', $this->objectIDs);
		$list->readObjectIDs();
		
		// trash statements
		$action = new UserJcoinsStatementAction($list->objectIDs, 'trashAll');
		$action->executeAction();
		
		$this->unmarkItems();
	}
	
	/**
	 * validate reset the jcoins for user
	 */
	public function validateResetJCoins() {
		$this->__validateAccessibleGroups();
	}
}