<?php
namespace wcf\data\jcoins\shop\item\type;

use wcf\data\DatabaseObject;
use wcf\system\WCF; 

/**
 * Represents a shop item type. 
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class JCoinsShopItemType extends DatabaseObject {

	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'jcoins_shop_item_type';

	/**
	 * @see	\wcf\data\DatabaseObject::$databaseIndexName
	 */
	protected static $databaseTableIndexName = 'itemTypeID';
	
	/**
	 * get a Item-Type by identifer
	 * @param type $identifer
	 */
	public static function getByIdentifer($identifer) {
		$sql = "SELECT	*
			FROM	wcf".WCF_N."_". self::$databaseTableName ."
			WHERE	identifer = ?";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($identifer));
		$row = $statement->fetchArray();
		if (!$row) $row = array();

		return new self(null, $row);
	}
	
	/**
	 * get all parameters for the shop item type
	 * @return array<mixed>
	 */
	public function getParameters() {
		$sql = "SELECT	*
			FROM	wcf".WCF_N."_jcoins_shop_item_type_parameter
			WHERE	itemTypeID = ?";
		
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($this->getObjectID()));
		
		$param = array(); 
		
		while ($row = $statement->fetchArray()) {
			$param[] = $row; 
		}
		
		return $param; 
	}
}
