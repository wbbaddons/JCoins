<?php
namespace wcf\system\worker;

use wcf\data\user\User;
use wcf\system\database\util\PreparedStatementConditionBuilder;
use wcf\system\exception\SystemException;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;
use wcf\data\user\jcoins\statement\UserJcoinsStatementAction;

/**
 * Worker implementation for transfer jCoins.
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 * @subpackage	system.worker
 * @category	Community Framework
 */
class TransferWorker extends AbstractWorker {

	/**
	 * condition builder object
	 * @var	wcf\system\database\util\PreparedStatementConditionBuilder
	 */
	protected $conditions = null;

	/**
	 * @see	wcf\system\worker\AbstractWorker::$limit
	 */
	protected $limit = 50;

	/**
	 * mail data
	 * @var	array
	 */
	protected $transferData = null;

	/**
	 * @see	wcf\system\worker\IWorker::validate()
	 */
	public function validate() {
		WCF::getSession()->checkPermissions(array('admin.jcoins.canExecuteMassProcessing'));

		if (!isset($this->parameters['transferID'])) {
			throw new SystemException("transferID missing");
		}

		$userTransferData = WCF::getSession()->getVar('userTransferData');
		if (!isset($userTransferData[$this->parameters['transferID']])) {
			throw new SystemException("transferID '" . $this->parameters['transferID'] . "' is invalid");
		}

		if (!isset($userTransferData[$this->parameters['transferID']]['sum'])) {
			throw new SystemException("sum of '" . $this->parameters['transferID'] . "' is invalid");
		}

		if (!isset($userTransferData[$this->parameters['transferID']]['reason'])) {
			throw new SystemException("reason of '" . $this->parameters['transferID'] . "' is invalid");
		}

		$this->transferData = $userTransferData[$this->parameters['transferID']];
	}

	/**
	 * @see	wcf\system\worker\IWorker::countObjects()
	 */
	public function countObjects() {
		$this->conditions = new PreparedStatementConditionBuilder();
		$this->conditions->add("user.userID IN (?)", array($this->transferData['userIDs']));

		$sql = "SELECT	COUNT(*) AS count
			FROM	wcf" . WCF_N . "_user user
			" . $this->conditions;
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute($this->conditions->getParameters());
		$row = $statement->fetchArray();

		$this->count = $row['count'];
	}

	/**
	 * @see	wcf\system\worker\IWorker::getProgress()
	 */
	public function getProgress() {
		$progress = parent::getProgress();

		if ($progress == 100) {
			// clear session
			$userTransferData = WCF::getSession()->getVar('userTransferData');
			unset($userTransferData[$this->parameters['transferID']]);
			WCF::getSession()->register('userTransferData', $userTransferData);
		}

		return $progress;
	}

	/**
	 * @see	wcf\system\worker\IWorker::execute()
	 */
	public function execute() {
		// get users
		$sql = "SELECT		user_option.*, user.*
			FROM		wcf" . WCF_N . "_user user
			LEFT JOIN	wcf" . WCF_N . "_user_option_value user_option
			ON		(user_option.userID = user.userID)
			" . $this->conditions . "
			ORDER BY	user.userID";
		$statement = WCF::getDB()->prepareStatement($sql, $this->limit, ($this->limit * $this->loopCount));
		$statement->execute($this->conditions->getParameters());
		while ($row = $statement->fetchArray()) {
			$user = new User(null, $row);

			$this->statementAction = new UserJcoinsStatementAction(array(), 'create', array(
			    'data' => array(
				'reason' => $this->transferData['reason'],
				'sum' => $this->transferData['sum'],
				'userID' => $user->userID,
				'executedUserID' => $this->transferData['fromUser']
			    ),
			    'changeBalance' => 1
			));
			$this->statementAction->validateAction();
			$this->statementAction->executeAction();
		}
	}

	/**
	 * @see	wcf\system\worker\IWorker::getProceedURL()
	 */
	public function getProceedURL() {
		return LinkHandler::getInstance()->getLink('UserList');
	}

}