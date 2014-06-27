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
	 * execute the item
	 */
	public function buy(array $parameters); 
	
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
	public function prepare(array $parameters); 
	
	/**
	 * is the item multiple? 
	 * 
	 * @return boolean
	 */
	public function isMultiple();
}