<?php
namespace wcf\system\cronjob;
use wcf\data\cronjob\Cronjob;
use wcf\system\WCF;
use wcf\data\jCoins\premiumGroup\PremiumGroup;
use wcf\data\user\UserEditor;

class JCoinsDailyTaxCronjob extends AbstractCronjob {
	/**
	 * @see	wcf\system\cronjob\ICronjob::execute()
	 */
	public function execute(Cronjob $cronjob) {
		parent::execute($cronjob);
		
		$sql = "SELECT	userID, premiumGroupID
			FROM	wcf".WCF_N."_user_to_group_premium
			WHERE until < ".TIME_NOW;
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute();

		while ($row = $statement->fetchArray()) {
			$premiumGroup = new PremiumGroup($row->premiumGroupID);
			$user = new UserEditor($row['userID']);
			$user->removeFromGroups(array($premiumGroup->groupID));
			$user->resetCache(); 
		}
	}
}