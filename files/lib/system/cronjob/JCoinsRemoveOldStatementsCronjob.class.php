<?php
namespace wcf\system\cronjob;
use wcf\data\cronjob\Cronjob;
use wcf\system\WCF;
use wcf\system\database\util\PreparedStatementConditionBuilder;

/**
 * removing old statements
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
		
		$conditions = new PreparedStatementConditionBuilder();
		$conditions->add("time < ?", TIME_NOW - 86400 * JCOINS_STATEMENT_DELETEAFTER);
		
		if (JCOINS_STATEMENTS_DELETEONLYTRASHED) {
		    $conditions->add("isTrashed = ?", true);
		}
		
		$sql = "DELETE FROM wcf". WCF_N ."_statement_entrys";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute($conditions->getParameters());
	}
}
