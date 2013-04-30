<?php
namespace wcf\system\cronjob;
use wcf\data\cronjob\Cronjob;
use wcf\system\WCF;
use wcf\data\jCoins\statement\StatementEditor; 

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

		$i = 0; 
		
		while ($row = $statement->fetchArray()) {
			$user = new UserEditor($row['userID']);
			$newCoins = $user->jCoinsBalance * $tax / 100 * -1; 
			StatementEditor::create(array(
				'userID'	=> $row['userID'], 
				'time'		=> TIME_NOW, 
				'reason'	=> "DAILYTAX", 
				'sum'		=> $newCoins
			));
			
			++$i;
			
			if ($i > 1000) return; 
		}
	}
}