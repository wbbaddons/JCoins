<?php
namespace wcf\system\jcoins\shop\item\type; 

class ExampleItem extends \wcf\system\jcoins\shop\item\type\ShopItem {
	
	public static function getIdentifer() {
		return 'Exampletwo';
	}
	
	public function boughtAction(array $paramters) {
		parent::boughtAction($paramters);
		
		//simple add 1337 JCoins to the current user
		$action = new \wcf\data\user\jcoins\statement\UserJcoinsStatementAction(array(), 'create', array(
		    'data' => array(
			'reason' => '1337',
			'sum' => 1337,
		    ),
		    'changeBalance' => 1
		)); 
		$action->executeAction(); 
	}
}