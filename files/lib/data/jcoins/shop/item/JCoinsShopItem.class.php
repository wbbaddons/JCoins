<?php
namespace wcf\data\jcoins\shop\item;

use wcf\data\DatabaseObject;
use wcf\system\bbcode\MessageParser; 
use wcf\system\WCF;

/**
 * Represents a shop item type. 
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class JCoinsShopItem extends DatabaseObject implements \wcf\system\request\IRouteController {

	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'jcoins_shop_item';

	/**
	 * @see	\wcf\data\DatabaseObject::$databaseIndexName
	 */
	protected static $databaseTableIndexName = 'itemID';
	
	/**
	 * shop-item item type
	 * @var \wcf\system\jcoins\shop\item\ShopItem
	 */
	public $type = null; 
	
	/**
	 * cache for user
	 * @var array<boolean> 
	 */
	private $boughtCache = array(); 
	
	/**
	 * all parameters for the item
	 * @var array<mixed> 
	 */
	private $parameters = array(); 
	
	public function __construct($id, array $row = null, DatabaseObject $object = null) {
		parent::__construct($id, $row, $object);
		
		$this->type = \wcf\system\jcoins\shop\ShopHandler::getInstance()->getItemTypeByID($this->itemType);
			
		$condition = new \wcf\system\database\util\PreparedStatementConditionBuilder();
		$condition->add('itemID = ?', array($this->getObjectID()));
		$condition->add('parameterID IN (?)', array(array_map(function ($value) {
			return $value['parameterID'];
		}, $this->type->getParameters())));
		$sql = "SELECT * FROM wcf". WCF_N ."_jcoins_shop_item_parameter ".$condition;
		$stmt = \wcf\system\WCF::getDB()->prepareStatement($sql); 
		$stmt->execute($condition->getParameters());
		
		while ($row = $stmt->fetchArray()) {
			$this->parameters[$row['parameterID']] = $row['value']; 
		}
	}
	
	/**
	 * get the shop-item-type
	 */
	public function getType() {
		return $this->type; 
	}
	
	/**
	 * returns true, if the user can buy the item
	 * @param	integer		$userID
	 * @return	boolean
	 */
	public function canBuy($userID = null) {
		if ($userID === null) {
			$userID = \wcf\system\WCF::getSession()->userID; 
		}
		
		if ($userID == 0) return false; // guest cannot buy products
		
		if ($this->price > \wcf\system\WCF::getSession()->getUser()->jCoinsBalance) return false; 
		
		if (!$this->type->isMultiple() && $this->hasBought()) return false; 
		
		return true; 
	}
	
	/**
	 * returns true, if the user has bought the item
	 * @param	integer		$userID
	 * @return	boolean
	 */
	public function hasBought($userID = null) {
		if ($userID === null) {
			$userID = \wcf\system\WCF::getSession()->userID; 
		}
		
		// is this already cached? :) 
		if (isset($this->boughtCache[$userID])) return $this->boughtCache[$userID]; 
		
		// we first assume that he has not bought it
		// we can change this, if he has bought it yet
		$this->boughtCache[$userID] = false; 
		
		if ($userID == 0) return false; // guest cannot buy products
		
		// we must query the database :/ 
		// but it is not reasonable to directly caching all users
		$sql = "SELECT COUNT(*) as count FROM wcf". WCF_N ."_jcoins_shop_item_bought WHERE userID = ? AND itemID = ?";
		$stmt = \wcf\system\WCF::getDB()->prepareStatement($sql); 
		$stmt->execute(array($userID, $this->itemID));
		
		if ($stmt->fetchColumn() > 0) {
			$this->boughtCache[$userID] = true; 
			return true; 
		}
		
		return false; 
	}
	
	/**
	 * returns true, if the item is multiple
	 * @return boolean
	 */
	public function isMultiple() {
		return $this->type->isMultiple(); 
	}
	
	/**
	 * @see \wcf\data\ITitledObject::getTitle()
	 */
	public function getTitle() {
		return $this->name; 
	}
	
	/**
	 * get all parameter values for the item
	 * @return array<mixed>
	 */
	public function getParameters() {
		return $this->parameters; 
	}
	
	/**
	 * get the parsed description
	 * @return string
	 */
	public function getDescription() {
		MessageParser::getInstance()->setOutputType('text/html');
		return MessageParser::getInstance()->parse(WCF::getLanguage()->get($this->description), $this->allowSmileys, $this->allowHTML, $this->parseBBCodes, false);
	}
}
