<?php
namespace wcf\system\cronjob;
use wcf\data\cronjob\Cronjob;
use wcf\data\user\User;
use wcf\system\WCF;
use wcf\data\jCoins\statement\StatementEditor; 

/**
 * adding the daily tax
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 * @subpackage	system.cronjob
 * @category	Community Framework
 */
class JCoinsDailyTaxCronjob extends AbstractCronjob {
	/**
	 * @see	wcf\system\cronjob\ICronjob::execute()
	 */
	public function execute(Cronjob $cronjob) {
		parent::execute($cronjob);

		if (JCOINS_COINS_TAX == 0) return; 
		
		$tax = JCOINS_COINS_TAX / 100; 
		
		$sql = "SELECT	userID
			FROM	wcf". WCF_N ."_user";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute();
		
		while ($row = $statement->fetchArray()) {
			$user = new User($row['userID']);
			$newCoins = $user->jCoinsBalance * $tax / 100 * -1; 
			StatementEditor::create(array(
				'userID'	=> $row['userID'], 
				'time'		=> TIME_NOW, 
				'reason'	=> "DAILYTAX", 
				'sum'		=> $newCoins
			));
		}
	}
}
