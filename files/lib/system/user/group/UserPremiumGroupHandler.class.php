<?php
namespace wcf\system\user\group;
use wcf\system\user\storage\UserStorageHandler;
use wcf\system\SingletonFactory;
use wcf\system\WCF;

/**
 * Handles user-related premium-groups.
 * @author	Dennis Kraffczyk
 * @package	de.joshsboard.jcoins
 */
 class UserPremiumGroupHandler extends SingletonFactory {	
	/**
	 * ids of premium-groups in which the current user is member
	 * @var array<integer>
	 */
	protected $premiumGroupIDs = array();
	
	/**
	 * @see wcf\system\SingletonFactory::init()
	 */
	protected function init() {
		UserStorageHandler::getInstance()->loadStorage(array(WCF::getUser()->userID));
		$data = UserStorageHandler::getInstance()->getStorage(array(WCF::getUser()->userID), 'premiumGroupIDs');
		
		if ($data[WCF::getUser()->userID] === null) {
			$sql = "SELECT	premiumGroupID
				FROM	wcf".WCF_N."_user_to_group_premium
				WHERE	userID = ?";
			$statement = WCF::getDB()->prepareStatement($sql);
			$statement->execute(array(WCF::getUser()->userID));
			while ($row = $statement->fetchArray()) {
				$this->premiumGroupIDs[] = $row['premiumGroupID'];
			}
			
			UserStorageHandler::getInstance()->update(WCF::getUser()->userID, 'premiumGroupIDs', serialize($this->premiumGroupIDs));
		}
		else {
			$this->purchasedProducts = unserialize($data[WCF::getUser()->userID]);
		}
	}
	
	/**
	 * Returns a list of premium-group-ids in which the current user is member.
	 * @return array<integer>
	 */
	public function getAccessiblePremiumGroupIDs() {
		return $this->premiumGroupIDs;
	}
	
	/**
	 * Returns true if current user is member in given premium-group.
	 * @param	integer		$premiumGroupID
	 * @return boolean
	 */
	public function isMember($premiumGroupID) {
		return in_array($premiumGroupID, $this->premiumGroupIDs);
	}
 }
 