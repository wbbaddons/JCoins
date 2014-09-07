<?php
namespace wcf\system\user\notification\object;

use wcf\data\DatabaseObjectDecorator;
use wcf\system\request\LinkHandler;

/**
 * Transfer notification object
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class JCoinsTransferNotificationObject extends DatabaseObjectDecorator implements IUserNotificationObject {

	/**
	 * @see	wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'wcf\data\user\jcoins\statement\UserJcoinsStatement';

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
		return LinkHandler::getInstance()->getLink('OwnCoinsStatement');
	}

	/**
	 * @see	wcf\system\user\notification\object\IUserNotificationObject::getAuthorID()
	 */
	public function getAuthorID() {
		return $this->executedUserID;
	}

}
