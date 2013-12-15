<?php
namespace wcf\system\cronjob;

use wcf\data\cronjob\Cronjob;
use wcf\data\user\jcoins\statement\StatementAction;
use wcf\data\user\jcoins\statement\StatementList;

/**
 * Removing old statements
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 * @subpackage	system.cronjob
 * @category	Community Framework
 */
class JCoinsRemoveOldStatementsCronjob extends AbstractCronjob {

	/**
	 * @see	wcf\system\cronjob\ICronjob::execute()
	 */
	public function execute(Cronjob $cronjob) {
		parent::execute($cronjob);

		$statementList = new StatementList();
		$statementList->getConditionBuilder()->add('user_jcoins_statement.time < ?', array(TIME_NOW - 86400 * JCOINS_STATEMENTS_DELETEAFTER));
		if (JCOINS_STATEMENTS_DELETEONLYTRASHED) $statementList->getConditionBuilder()->add('user_jcoins_statement.isTrashed = ?', array(1));
		$statementList->readObjects();

		if (!$statementList->count()) return;

		$statementAction = new StatementAction($statementList->getObjects(), 'delete');
		$statementAction->executeAction();
	}

}
