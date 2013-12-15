<?php
namespace wcf\action;

use wcf\data\user\jcoins\statement\StatementAction;
use wcf\data\user\jcoins\statement\StatementList;
use wcf\util\HeaderUtil;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;

/**
 * sum up all statement entrys from an user
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoin
 */
class SumUpStatementsAction extends AbstractAction {

	/**
	 * @see	wcf\action\AbstractAction::$loginRequired
	 */
	public $loginRequired = true;

	/**
	 * statement-action
	 * @var	wcf\data\jCoins\statement\StatementAction
	 */
	public $statementAction = null;

	/**
	 * list of statements to sum up
	 * @var	wcf\data\jCoins\statement\StatementList
	 */
	public $statementList = null;

	/**
	 * @see	wcf\action\IAction::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();

		$this->statementList = new StatementList();
		$this->statementList->getConditionBuilder()->add('statement_entrys.userID = ?', array(WCF::getUser()->userID));

		if ($this->statementList->countObjects() < 2) {
			throw new PermissionDeniedException();
		}

		$this->statementList->readObjectIDs();
	}

	/**
	 * @see	wcf\action\IAction::execute()
	 */
	public function execute() {
		parent::execute();

		// mark as trashed
		$this->statementAction = new StatementAction($this->statementList->objectIDs, 'trashAll');
		$this->statementAction->executeAction();

		$this->statementAction = new StatementAction(array(), 'create', array(
		    'data' => array(
			'reason' => 'wcf.jcoins.summaryOfAccountBalances',
			'sum' => WCF::getUser()->jCoinsBalance,
			'time' => TIME_NOW,
			'userID' => WCF::getUser()->userID
		    )
		));
		$this->statementAction->executeAction();

		$this->executed();

		$url = LinkHandler::getInstance()->getLink('OwnCoinsStatement');
		HeaderUtil::delayedRedirect($url, WCF::getLanguage()->get('wcf.jcoins.statement.successfullsumup'));
		exit;
	}

}
