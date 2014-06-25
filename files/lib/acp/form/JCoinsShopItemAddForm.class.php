<?php
namespace wcf\acp\form;

use wcf\form\AbstractForm;
use wcf\system\exception\UserInputException;
use wcf\system\language\I18nHandler;
use wcf\system\WCF;
use wcf\system\Regex; 

/**
 * Shows the shop item add-form.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 * @subpackage	acp.form
 */
class JCoinsShopItemAddForm extends AbstractForm {

	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.jcoins.shop.item.add';

	/**
	 * @see \wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.jcoins.shop.canManage');

	/**
	 * @see	\wcf\page\AbstractPage::$neededModules
	 */
	public $neededModules = array('MODULE_JCOINS', 'MODULE_JCOINS_SHOP');

	/**
	 * @see	\wcf\page\AbstractPage::$action
	 */
	public $action = 'add';
	
	/**
	 * the selected type
	 * @var integer 
	 */
	public $typeID = 0; 

	/**
	 *
	 * @var \wcf\data\jcoins\shop\item\type\JCoinsShopItemType 
	 */
	public $type = null; 
	
	/**
	 * type list
	 * @var \wcf\data\jcoins\shop\item\type\JCoinsShopItemTypeList 
	 */
	public $typeList = array(); 
	
	public $price = 0; 
	
	public $description = ""; 
	
	public $name = ""; 
	
	public $showOrder = 0; 
	
	public $parameterParameters = array(); 
	
	/**
	 * @see	\wcf\page\IPage::readData()
	 */
	public function readData() {
		
		I18nHandler::getInstance()->register('description');
		I18nHandler::getInstance()->register('name');
		
		parent::readData();
		
		$this->typeList = new \wcf\data\jcoins\shop\item\type\JCoinsShopItemTypeList(); 
	}

	/**
	 * @see	\wcf\form\IForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();

		I18nHandler::getInstance()->readValues();
		
		if (isset($_POST['price'])) $this->price = intval($_POST['price']);
		if (isset($_POST['type'])) $this->typeID = intval($_POST['type']);
		$this->type = new \wcf\data\jcoins\shop\item\type\JCoinsShopItemType($this->typeID);
		
		$this->readParameterParameters(); 
	}

	public function readParameterParameters() {
		foreach ($this->type->getParameters() as $parameter) {
			if (isset($_POST['param_'.$parameter['parameterID'].'_'.$parameter['name']])) {
				$this->parameterParameters[$parameter['name']] = $_POST['param_'.$parameter['parameterID'].'_'.$parameter['name']];
				
				switch ($parameter['type']) {
					case 'INTEGER': 
						$this->parameterParameters[$parameter['name']] = intval($this->parameterParameters[$parameter['name']]); 
						break; 
					
					case 'BOOL':
						$this->parameterParameters[$parameter['name']] = 1; // true (it is an text-field)
						break;
				}
			} else {
				switch ($parameter['type']) {
					case 'INTEGER':
					case 'BOOL': // 0 == false (it is an text-field)
						$this->parameterParameters[$parameter['name']] = 0; 
						break; 
						
					case 'TEXT':
					default: 
						$this->parameterParameters[$parameter['name']] = '';
						break; 
				}
			}
		}
	}
	
	public function validateParameterParameters() {
		foreach ($this->type->getParameters() as $parameter) {
			if (!empty($parameter['regex'])) {
				$regex = new Regex($parameter['regex']); 
				
				if (!$regex->match($this->parameterParameters[$parameter['name']])) {
					throw new UserInputException($parameter['name']); 
				}
			}
		}
	}
	
	/**
	 * @see	\wcf\form\IForm::validate()
	 */
	public function validate() {
		parent::validate();
		
		if (!I18nHandler::getInstance()->validateValue('name')) {
			throw new UserInputException('name'); 
		}
		
		if ($this->price < 1) {
			throw new UserInputException('price'); 
		}
		
		if ($this->type->getObjectID() == 0) {
			throw new UserInputException('type'); 
		}
		
		$this->validateParameterParameters();
	}

	/**
	 * @see	\wcf\form\IForm::save()
	 */
	public function save() {
		parent::save();
		
		$action = new \wcf\data\jcoins\shop\item\JCoinsShopItemAction(array(), 'create', array(
		    'data' => array(
			'itemType' => $this->type->itemTypeID, 
			'isDisabled' => 0, 
			'price' => $this->price, 
			'description' => I18nHandler::getInstance()->isPlainValue('description') ? I18nHandler::getInstance()->getValue('description') : '', 
			'name' => I18nHandler::getInstance()->isPlainValue('name') ? I18nHandler::getInstance()->getValue('name') : '', 
			'showOrder' => $this->showOrder
			), 
		    'parameters' => $this->parameterParameters
		)); 
		$return = $action->executeAction(); 
		
		$itemID = $return['returnValues']->itemID;
		
		// save I18n name
		if (!I18nHandler::getInstance()->isPlainValue('name')) {
			$updateData = array();
			$updateData['name'] = 'wcf.jcoins.shop.item.name' . $itemID;
			I18nHandler::getInstance()->save('name', $updateData['name'], 'wcf.jcoins');
		}
		
		// save I18n description
		if (!I18nHandler::getInstance()->isPlainValue('description')) {
			$updateData = array();
			$updateData['description'] = 'wcf.jcoins.shop.item.description' . $itemID;
			I18nHandler::getInstance()->save('description', $updateData['description'], 'wcf.jcoins');
		}
		
		if (count($updateData)) {
			$editor = new \wcf\data\jcoins\shop\item\JCoinsShopItemEditor($return['returnValues']);
			$editor->update($updateData);
		}
		
		$this->saved(); 
		
		I18nHandler::getInstance()->reset();
		
		// show success
		WCF::getTPL()->assign('success', true);
	}

	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		$this->typeList->readObjects(); 
		
		I18nHandler::getInstance()->assignVariables();
		
		WCF::getTPL()->assign(array(
		    'types' => $this->typeList->getObjects(), 
		    'type' => $this->typeID,
		    'price' => $this->price,
		    'showOrder' => $this->showOrder
		));
	}

}
