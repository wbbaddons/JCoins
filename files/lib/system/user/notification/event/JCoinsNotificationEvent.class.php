<?php
namespace wcf\system\user\notification\event;
use wcf\system\user\notification\event\AbstractUserNotificationEvent;

class JCoinsNotificationEvent extends AbstractUserNotificationEvent {
	/**
	 * @see	wcf\system\user\notification\event\IUserNotificationEvent::getMessage()
	 */
	public function getTitle() {
		return $this->getLanguage()->getDynamicVariable('wcf.user.notification.jcoins.title');
	}

	/**
	 * @see	wcf\system\user\notification\event\IUserNotificationEvent::getMessage()
	 */
	public function getMessage() {
		return $this->getLanguage()->getDynamicVariable('wcf.user.notification.jcoins.message', array(
			'statement' => $this->userNotificationObject,
			'author' => $this->author
		));	
	}
	
	/**
	 * @see	wcf\system\user\notification\event\IUserNotificationEvent::getEmailMessage()
	 */
	public function getEmailMessage() {
		return $this->getLanguage()->getDynamicVariable('wcf.user.notification.jcoins.mail', array(
			'statement' => $this->userNotificationObject,
			'author' => $this->author
		));
	}
}