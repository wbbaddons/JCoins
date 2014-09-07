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
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
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
	 * defines wheather allow bbcodes in the content
	 * @var boolean
	 */
	public $parseBBCodes = true;

	/**
	 * defines wheather allow html in the content
	 * @var boolean
	 */
	public $allowHTML = false;

	/**
	 * defines wheather allow smileys in the content
	 * @var boolean
	 */
	public $allowSmileys = false;
	
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
		
		if (isset($_POST['parseBBCodes']) & $_POST['parseBBCodes'] == 1) $this->parseBBCodes = true;
		if (isset($_POST['allowHTML']) && $_POST['allowHTML'] == 1) $this->allowHTML = true;
		if (isset($_POST['allowSmileys']) && $_POST['allowSmileys'] == 1) $this->allowSmileys = true;
		
		$this->type = new \wcf\data\jcoins\shop\item\type\JCoinsShopItemType($this->typeID);
		
		$this->readParameterParameters(); 
	}

	public function readParameterParameters() {
		foreach ($this->type->getParameters() as $parameter) {
			if (isset($_POST['param_'.$parameter['parameterID'].'_'.$parameter['name']])) {
				$this->parameterParameters[$parameter['parameterID']] = $_POST['param_'.$parameter['parameterID'].'_'.$parameter['name']];
				
				switch ($parameter['type']) {
					case 'INTEGER': 
						$this->parameterParameters[$parameter['parameterID']] = intval($this->parameterParameters[$parameter['parameterID']]); 
						break; 
					
					case 'BOOL':
						$this->parameterParameters[$parameter['parameterID']] = 1; // true (it is an text-field)
						break;
				}
			} else {
				switch ($parameter['type']) {
					case 'INTEGER':
					case 'BOOL': // 0 == false (it is an text-field)
						$this->parameterParameters[$parameter['parameterID']] = 0; 
						break; 
						
					case 'TEXT':
					default: 
						$this->parameterParameters[$parameter['parameterID']] = '';
						break; 
				}
			}
		}
	}
	
	public function validateParameterParameters() {
		foreach ($this->type->getParameters() as $parameter) {
			if (!empty($parameter['regex'])) {
				$regex = new Regex($parameter['regex']); 
				
				if (!$regex->match($this->parameterParameters[$parameter['parameterID']])) {
					throw new UserInputException($parameter['parameterID'], 'regex'); 
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
		
		if ($this->price > 4294967294) {
			throw new UserInputException('price', 'max'); 
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
			'parseBBCodes' => ($this->parseBBCodes) ? 1 : 0,
			'allowHTML' => ($this->allowHTML) ? 1 : 0,
			'allowSmileys' => ($this->allowSmileys) ? 1 : 0,
			'showOrder' => $this->showOrder
			), 
		    'parameters' => $this->parameterParameters
		)); 
		$return = $action->executeAction(); 
		
		$itemID = $return['returnValues']->itemID;
		
		$updateData = array();
		
		// save I18n name
		if (!I18nHandler::getInstance()->isPlainValue('name')) {
			$updateData['name'] = 'wcf.jcoins.shop.item.name' . $itemID;
			I18nHandler::getInstance()->save('name', $updateData['name'], 'wcf.jcoins');
		}
		
		// save I18n description
		if (!I18nHandler::getInstance()->isPlainValue('description')) {
			$updateData['description'] = 'wcf.jcoins.shop.item.description' . $itemID;
			I18nHandler::getInstance()->save('description', $updateData['description'], 'wcf.jcoins');
		}
		
		if (count($updateData)) {
			$editor = new \wcf\data\jcoins\shop\item\JCoinsShopItemEditor($return['returnValues']);
			$editor->update($updateData);
		}
		
		$this->saved(); 
		
		I18nHandler::getInstance()->reset();
		
		$this->price = 0; 
		$this->parameterParameters = array(); 
		
		$this->parseBBCodes = true;
		$this->allowHTML = $this->allowSmileys = false;
		
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
			'showOrder' => $this->showOrder, 
			'parameterValues' => $this->parameterParameters,
			'parseBBCodes' => ($this->parseBBCodes) ? 1 : 0,
			'allowHTML' => ($this->allowHTML) ? 1 : 0,
			'allowSmileys' => ($this->allowSmileys) ? 1 : 0
		));
	}

}
