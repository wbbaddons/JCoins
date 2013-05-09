<?php
namespace wcf\data\jCoins\statement;

use wcf\data\DatabaseObjectEditor;
use wcf\data\user\UserEditor;
use wcf\data\user\User;

/**
 * a statement editor
 * 
 * @author  Joshua Rüsweg
 * @package de.joshsboard.jcoins
 */
class StatementEditor extends DatabaseObjectEditor {
	/**
	 * @see	wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'wcf\data\jCoins\statement\Statement';
	
	/**
	 * @see wcf\data\DatabaseObjectEditor::create()
	 */
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
	
	public static function trashAll($objectIDs) {
		$sql = "UPDATE ".static::getDatabaseTableName()." SET isTrashed = 1 WHERE entryID IN (?)";
		$objects = "";
		
		foreach ($objectIDs as $id) {
			if (empty($objects)) {
				$objects = $id; 
			} else {
				$objects .= ", ".$id;
			}
		}
		
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array(
			$objects
		));
	}
}