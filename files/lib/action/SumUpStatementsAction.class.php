<?php
namespace wcf\action;
use wcf\action\AbstractAction;
use wcf\data\jCoins\statement\StatementEditor;
use wcf\data\jCoins\statement\StatementList;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\WCF;
use wcf\util\HeaderUtil;
use wcf\system\request\LinkHandler;

class SumUpStatementsAction extends AbstractAction {

	/**
	 * @see wcf\action\AbstractAction::$loginRequired
	 */
	public $loginRequired = true;

	public function execute() {
		parent::execute();

		$list = new StatementList(); 
		$list->getConditionBuilder()->add("statement_entrys.userID = ?", array(WCF::getSession()->getUser()->userID));
		$list->readObjectIDs(); 
		
		// you cannot execute this action under 2 entrys
		if ($list->countObjects() < 2) {
		    throw new PermissionDeniedException(); 
		}
		
		StatementEditor::deleteAll($list->getObjectIDs()); 
		
		StatementEditor::create(array(
			'userID'	    => WCF::getSession()->getUser()->userID,
			'executedUserID'    => 0, 
			'time'		    => TIME_NOW, 
			'reason'	    => "Zusammenfassung alter Kontostände", 
			'sum'		    => WCF::getSession()->getUser()->jCoinsBalance,
			'changeBalance'	    => false
		));

		$this->executed(); 
	}
	
	public function executed() {
	    parent::executed();
	    
	    HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('OwnCoinsStatement'), WCF::getLanguage()->get('wcf.jCoins.statement.successfullsumup'));
	    exit; 
	}
}