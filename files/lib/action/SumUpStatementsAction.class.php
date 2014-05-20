<?php
namespace wcf\action;

use wcf\data\user\jcoins\statement\UserJcoinsStatementAction;
use wcf\data\user\jcoins\statement\UserJcoinsStatementList;
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
	 * @var	wcf\data\jCoins\statement\UserJcoinsStatementAction
	 */
	public $statementAction = null;

	/**
	 * list of statements to sum up
	 * @var	wcf\data\jCoins\statement\UserJcoinsStatementList
	 */
	public $statementList = null;

	/**
	 * @see	wcf\action\IAction::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();

		$this->statementList = new UserJcoinsStatementList();
		$this->statementList->getConditionBuilder()->add('user_jcoins_statement.userID = ?', array(WCF::getUser()->userID));

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
		$this->statementAction = new UserJcoinsStatementAction($this->statementList->objectIDs, 'trashAll');
		$this->statementAction->executeAction();

		$this->statementAction = new UserJcoinsStatementAction(array(), 'create', array(
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