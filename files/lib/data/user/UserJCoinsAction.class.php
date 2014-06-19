<?php
namespace wcf\data\user; 

use wcf\system\database\util\ConditionBuilder; 
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
	}
	
	/**
	 * validate reset the jcoins for user
	 */
	public function validateResetJCoins() {
		$this->__validateAccessibleGroups();
	}
}