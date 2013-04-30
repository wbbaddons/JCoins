<?php
namespace wcf\system\user\notification\object\type;

class JCoinsTransferNotificationObjectType extends AbstractUserNotificationObjectType {
	/**
	 * @see wcf\system\user\notification\object\type\AbstractUserNotificationObjectType::$decoratorClassName
	 */
	protected static $decoratorClassName = 'wcf\system\user\notification\object\JCoinsTransferNotificationObject';

	/**
	 * @see wcf\system\user\notification\object\type\AbstractUserNotificationObjectType::$objectClassName
	 */
	protected static $objectClassName = 'wcf\data\jCoins\statement\Statement';

	/**
	 * @see wcf\system\user\notification\object\type\AbstractUserNotificationObjectType::$objectListClassName
	 */
	protected static $objectListClassName = 'wcf\data\jCoins\statement\StatementList';
}