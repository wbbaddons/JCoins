<?php
namespace wcf\data\jcoins\shop\item\type;

use wcf\data\DatabaseObject;

/**
 * Represents a shop item type. 
 * 
 * @author	Joshua Rüsweg
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
}
