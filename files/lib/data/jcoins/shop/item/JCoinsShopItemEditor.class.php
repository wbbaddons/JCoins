<?php
namespace wcf\data\jcoins\shop\item; 

use wcf\data\DatabaseObjectEditor;

/**
 * Provides functions for shop items
 * 
 * @author	Joshua Rüsweg, Matthias Schmidt (setShowOrder-Methode)
 * @package	de.joshsboard.jcoins
 */
class JCoinsShopItemEditor extends DatabaseObjectEditor implements \wcf\data\IEditableCachedObject {

	/**
	 * @see	\wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'wcf\data\jcoins\shop\item\JCoinsShopItem';

	/**
	 * clears the shopitemtype cache
	 */
	public static function resetCache() {
		\wcf\system\cache\builder\JCoinsShopItemCacheBuilder::getInstance()->reset(); 
	}
	
	/**
	 * Sets the show order of the items.
	 * 
	 * @param	integer		$showOrder
	 */
	public function setShowOrder($showOrder = 0) {
		$newShowOrder = 1;

		$sql = "SELECT	MAX(showOrder)
			FROM	wcf".WCF_N."_jcoins_shop_item";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute();
		$maxShowOrder = $statement->fetchColumn();
		if (!$maxShowOrder) $maxShowOrder = 0;

		if (!$showOrder || $showOrder > $maxShowOrder) {
			$newShowOrder = $maxShowOrder + 1;
		}
		else {
			// shift other notices
			$sql = "UPDATE	wcf".WCF_N."_jcoins_shop_item
				SET	showOrder = showOrder + 1
				WHERE	showOrder >= ?";
			$statement = WCF::getDB()->prepareStatement($sql);
			$statement->execute(array(
				$showOrder
			));

			$newShowOrder = $showOrder;
		}

		$this->update(array(
			'showOrder' => $newShowOrder
		));
	}
}
