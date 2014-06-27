<?php
namespace wcf\data\jcoins\shop\item;

use wcf\data\AbstractDatabaseObjectAction;
use wcf\system\exception\UserInputException;
use wcf\system\WCF; 
use wcf\data\jcoins\shop\item\JCoinsShopItemList; 

/**
 * Provides functions to handle JCoinsShopItemAction.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class JCoinsShopItemAction extends AbstractDatabaseObjectAction implements \wcf\data\ISortableAction, \wcf\data\IToggleAction {

	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$className
	 */
	protected $className = 'wcf\data\jcoins\shop\item\JCoinsShopItemEditor';
	
	/**
	 * @see	\wcf\data\AbstractDatabaseObjectAction::$permissionsDelete
	 */
	protected $permissionsDelete = array('admin.jcoins.shop.canManage');
	
	/**
	 * @see	\wcf\data\AbstractDatabaseObjectAction::$permissionsUpdate
	 */
	protected $permissionsUpdate = array('admin.jcoins.shop.canManage');
	
	/**
	 * @see	\wcf\data\AbstractDatabaseObjectAction::$requireACP
	 */
	protected $requireACP = array('create', 'delete', 'toggle', 'update', 'updatePosition');
	
	/**
	 * @see	\wcf\data\IToggleAction::validateToggle()
	 */
	public function validateToggle() {
		parent::validateUpdate();
	}
	
	/**
	 * @see	\wcf\data\IToggleAction::toggle()
	 */
	public function toggle() {
		foreach ($this->objects as $item) {
			$item->update(array(
				'isDisabled' => $item->isDisabled ? 0 : 1
			));
		}
	}
	
	/**
	 * @see	\wcf\data\ISortableAction::validateUpdatePosition()
	 */
	public function validateUpdatePosition() {
		WCF::getSession()->checkPermissions($this->permissionsUpdate);

		if (!isset($this->parameters['data']['structure']) || !is_array($this->parameters['data']['structure'])) {
			throw new UserInputException('structure');
		}

		$itemList = new JCoinsShopItemList();
		$itemList->getConditionBuilder()->add('jcoins_shop_item.itemID IN (?)', array($this->parameters['data']['structure'][0]));
		if ($itemList->countObjects() != count($this->parameters['data']['structure'][0])) {
			throw new UserInputException('structure');
		}

		$this->readInteger('offset', true, 'data');
	}
	
	/**
	 * @see	\wcf\data\ISortableAction::updatePosition()
	 */
	public function updatePosition() {
		$sql = "UPDATE	wcf".WCF_N."_jcoins_shop_item
			SET	showOrder = ?
			WHERE	itemID = ?";
		$statement = WCF::getDB()->prepareStatement($sql);

		$showOrder = $this->parameters['data']['offset'];
		WCF::getDB()->beginTransaction();
		foreach ($this->parameters['data']['structure'][0] as $itemID) {
			$statement->execute(array(
				$showOrder++,
				$itemID
			));
		}
		WCF::getDB()->commitTransaction();
	}
	
	/**
	 * @see	\wcf\data\AbstractDatabaseObjectAction::create()
	 */
	public function create() {
		$showOrder = 0;
		if (isset($this->parameters['data']['showOrder'])) {
			$showOrder = $this->parameters['data']['showOrder'];
			unset($this->parameters['data']['showOrder']);
		}

		$item = parent::create();
		$itemEditor = new JCoinsShopItemEditor($item);
		$itemEditor->setShowOrder($showOrder);

		$type = $item->getType();
		
		$sql = "INSERT INTO wcf". WCF_N ."_jcoins_shop_item_parameter (itemID, parameterID, value) VALUES (?, ?, ?)";
		$statement = WCF::getDB()->prepareStatement($sql);
		
		foreach ($type->getParameters() as $parameter) {
			if (!isset($this->parameters['parameters'][$parameter['parameterID']])) {
				$this->parameters['parameters'][$parameter['parameterID']] = ''; 
			}
			
			$statement->execute(array($item->getObjectID(), $parameter['parameterID'], $this->parameters['parameters'][$parameter['parameterID']]));
		}
		
		return new JCoinsShopItem($item->getObjectID());
	}
	
	/**
	 * @see	\wcf\data\AbstractDatabaseObjectAction::update()
	 */
	public function update() {
		$showOrder = 0;
		if (isset($this->parameters['data']['showOrder'])) {
			$showOrder = $this->parameters['data']['showOrder'];
			unset($this->parameters['data']['showOrder']);
		}

		parent::update();
		
		foreach ($this->getObjects() as $object) {
			$itemEditor = new JCoinsShopItemEditor($object);
			$itemEditor->setShowOrder($showOrder);
			
			$type = $object->getType();
			
			$sql = "UPDATE wcf". WCF_N ."_jcoins_shop_item_parameter SET value = ? WHERE itemID = ? AND parameterID = ?";
			$statement = WCF::getDB()->prepareStatement($sql);

			foreach ($type->getParameters() as $parameter) {
				if (isset($this->parameters['parameters'][$parameter['parameterID']])) {
					$statement->execute(array($this->parameters['parameters'][$parameter['parameterID']], $object->getObjectID(), $parameter['parameterID']));
				}
			}
		}
	}
	
	public function validateBuy() {
		foreach ($this->getObjects() as $object) {
			$object->getType()->validateBuy(); 
			
			if (!$object->canBuy()) {
				throw new \wcf\system\exception\PermissionDeniedException(); 
			}
		}
	}
	
	public function buy() {
		$return = array(); 
		
		foreach ($this->getObjects() as $object) {
			// log it 
			// @TODO
			
			// earn money here
			// @TODO
			
			$object->getType()->buy($object->getParameters()); 
			$return[$object->getObjectID()] = $object->getType()->boughtAction($object->getParameters());
		}
		
		if (count($return) == 1) {
			foreach ($return as $r) {
				return $r; 
			}
		}
		
		return $return; 
	}
	
	public function validateBought() {
		foreach ($this->getObjects() as $object) {
			if (!$object->hasBought() || $object->isMultiple()) {
				throw new \wcf\system\exception\PermissionDeniedException(); 
			}
		}
	}
	
	public function bought() {
		$return = array(); 
		
		foreach ($this->getObjects() as $object) {
			$return[$object->getObjectID()] = $object->getType()->boughtAction($object->getParameters());
		}
		
		if (count($return) == 1) {
			foreach ($return as $r) {
				return $r; 
			}
		}
		
		return $return; 
	}
}
