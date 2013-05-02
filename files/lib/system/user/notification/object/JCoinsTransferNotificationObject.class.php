<?php
namespace wcf\system\user\notification\object;
use wcf\data\DatabaseObjectDecorator;

/**
 * transfer-notification object
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class JCoinsTransferNotificationObject extends DatabaseObjectDecorator implements IUserNotificationObject {
	/**
	 * @see	wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'wcf\data\jCoins\statement\Statement';

	/**
	 * @see	wcf\system\user\notification\object\IUserNotificationObject::getTitle()
	 */
	public function getTitle() {
		return $this->reason; 
	}

	/**
	 * @see	wcf\system\user\notification\object\IUserNotificationObject::getURL()
	 */
	public function getURL() {
		return "#";
	}

	/**
	 * @see	wcf\system\user\notification\object\IUserNotificationObject::getAuthorID()
	 */
	public function getAuthorID() {
		return $this->userID;
	}
}