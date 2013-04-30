<?php
namespace wcf\data\jCoins\statement;

use wcf\data\DatabaseObjectEditor;
use wcf\data\user\UserEditor;
use wcf\data\user\User;


class StatementEditor extends DatabaseObjectEditor {
	/**
	 * @see	wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'wcf\data\jCoins\statement\Statement';
	
	public static function create(array $parameters = array()) {
		$changeBalance = true;
	    
		if (isset($parameters['changeBalance'])) {
		    $changeBalance = (bool)$parameters['changeBalance']; 
		    unset($parameters['changeBalance']);
		}
		
		$statement = parent::create($parameters); 
		
		if ($changeBalance) {
			$user = new User($parameters['userID']);
			$userEditor = new UserEditor($user);
			
			$newCoins = $user->jCoinsBalance + $parameters['sum']; 
			$userEditor->update(array('jCoinsBalance' => $newCoins));
		}
		
		return $statement;
	}
}