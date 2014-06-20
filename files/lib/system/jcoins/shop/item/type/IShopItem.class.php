<?php
namespace wcf\system\jcoins\shop\item\type; 

/**
 * a shop item
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
interface iShopItem {
	
	/**
	 * execute the bought-action
	 */
	public function boughtAction(array $paramters); 
	
	/**
	 * is the item purchasable? 
	 * 
	 * @return bool
	 */
	public function isPurchasable(); 
	
	/**
	 * get the identifer
	 * 
	 * @return String
	 */
	public static function getIdentifer(); 
	
	/**
	 * prepare
	 * 
	 * @return String
	 */
	public function prepare(); 
	
	/**
	 * is the item multiple? 
	 * 
	 * @return boolean
	 */
	public function isMultiple();
}