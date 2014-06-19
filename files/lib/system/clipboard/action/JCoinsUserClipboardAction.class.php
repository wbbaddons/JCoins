<?php
namespace wcf\system\clipboard\action;

use wcf\data\clipboard\action\ClipboardAction;
use wcf\system\clipboard\action\UserClipboardAction; 
use wcf\system\WCF; 

/**
 * Prepares clipboard editor for jcoins actions
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 * @subpackage	system.clipboard.action
 * @category	Woltlab Community Framework
 */
class JCoinsUserClipboardAction extends UserClipboardAction {

	/**
	 * @see	\wcf\system\clipboard\action\AbstractClipboardAction::$actionClassActions
	 */
	protected $actionClassActions = array('resetJCoins');
	
	/**
	 * @see	wcf\system\clipboard\action\AbstractClipboardAction::$supportedActions
	 */
	protected $supportedActions = array('resetJCoins');
	
	/**
	 * @see	wcf\system\clipboard\action\IClipboardAction::execute()
	 */
	public function execute(array $objects, ClipboardAction $action) {
		$item = parent::execute($objects, $action);
		
		if ($item === null) {
			return null;
		}

		// handle actions
		switch ($action->actionName) {
			case 'resetJCoins':
				$item->addInternalData('confirmMessage', WCF::getLanguage()->getDynamicVariable('wcf.clipboard.item.com.woltlab.wcf.user.resetJCoins.confirmMessage', array(
					'count' => $item->getCount()
				)));
			break;
		}
		
		return $item;
	}
	
	/**
	 * @see	wcf\system\clipboard\action\IClipboardAction::getClassName()
	 */
	public function getClassName() {
		return 'wcf\data\user\UserJCoinsAction';
	}
	
	/**
	 * @see	wcf\system\clipboard\action\IClipboardAction::getTypeName()
	 */
	public function getTypeName() {
		return 'com.woltlab.wcf.user';
	}
	
	/**
	 * Validates posts to copy them into a new thread.
	 * 
	 * @return	array<integer>
	 */
	public function validateResetJCoins() {
		return $this->__validateAccessibleGroups(array_keys($this->objects));
	}
}
