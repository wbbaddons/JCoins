<?php
namespace wcf\system\user\group;

use wcf\system\user\storage\UserStorageHandler;
use wcf\system\SingletonFactory;
use wcf\system\WCF;

/**
 * Handles user-related premium-groups.
 * @author	Dennis Kraffczyk
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class UserPremiumGroupHandler extends SingletonFactory {

        /**
         * ids of premium-groups in which the current user is member
         * @var	array<integer>
         */
        protected $groupIDs = array();
        protected $untils = array();

        /**
         * @see	wcf\system\SingletonFactory::init()
         */
        protected function init() {
                UserStorageHandler::getInstance()->loadStorage(array(WCF::getUser()->userID));
                $data = UserStorageHandler::getInstance()->getStorage(array(WCF::getUser()->userID), 'jCoinsPremiumGroupIDs');

                if ($data[WCF::getUser()->userID] === null) {
                        $sql = "SELECT	groupID
				FROM	wcf" . WCF_N . "_user_to_group_temp
				WHERE	userID = ?";
                        $statement = WCF::getDB()->prepareStatement($sql);
                        $statement->execute(array(WCF::getUser()->userID));
                        while ($row = $statement->fetchArray()) {
                                $this->groupIDs[] = $row['groupID'];
                        }

                        UserStorageHandler::getInstance()->update(WCF::getUser()->userID, 'jCoinsPremiumGroupIDs', serialize($this->groupIDs));
                } else {
                        $this->groupIDs = unserialize($data[WCF::getUser()->userID]);
                }
        }

        /**
         * Returns a list of premium-group-ids in which the current user is member.
         * @return	array<integer>
         */
        public function getAccessiblePremiumGroupIDs() {
                return $this->groupIDs;
        }

        /**
         * Returns true if current user is member in given premium-group.
         * @param	integer		$groupID
         * @return	boolean
         */
        public function isMember($groupID) {
                return in_array($groupID, $this->groupIDs);
        }

        public function getUntil($groupID) {
                if ($this->isMember($groupID)) {
                        if (!isset($this->untils[$groupID])) {
                                $sql = "SELECT	until
                                        FROM	wcf" . WCF_N . "_user_to_group_temp
                                        WHERE	userID = ? AND groupID = ?";
                                $statement = WCF::getDB()->prepareStatement($sql);
                                $statement->execute(array(WCF::getUser()->userID, $groupID));
                                $row = $statement->fetchArray();

                                $this->untils[$groupID] = $row['until'];
                        }

                        return $this->untils[$groupID];
                }
        }

}
