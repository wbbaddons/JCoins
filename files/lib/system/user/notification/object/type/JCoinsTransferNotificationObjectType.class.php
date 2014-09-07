<?php
namespace wcf\system\user\notification\object\type;

/**
 * Object type for transfer-notifications
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class JCoinsTransferNotificationObjectType extends AbstractUserNotificationObjectType {

	/**
	 * @see	wcf\system\user\notification\object\type\AbstractUserNotificationObjectType::$decoratorClassName
	 */
	protected static $decoratorClassName = 'wcf\system\user\notification\object\JCoinsTransferNotificationObject';

	/**
	 * @see	wcf\system\user\notification\object\type\AbstractUserNotificationObjectType::$objectClassName
	 */
	protected static $objectClassName = 'wcf\data\user\jcoins\statement\UserJcoinsStatement';

	/**
	 * @see	wcf\system\user\notification\object\type\AbstractUserNotificationObjectType::$objectListClassName
	 */
	protected static $objectListClassName = 'wcf\data\user\jcoins\statement\UserJcoinsStatementList';
	
}
