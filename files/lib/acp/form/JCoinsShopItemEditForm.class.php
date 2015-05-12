<?php
namespace wcf\acp\form;

use wcf\data\jcoins\shop\item\JCoinsShopItem;
use wcf\system\exception\IllegalLinkException;
use wcf\system\language\I18nHandler;
use wcf\system\WCF;

/**
 * Shows the shop item edit-form.
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 * @subpackage	acp.form
 */
class JCoinsShopItemEditForm extends JCoinsShopItemAddForm {

	/**
	 * @see	\wcf\page\AbstractPage::$action
	 */
	public $action = 'edit';

	/**
	 * shop item
	 * @var	\wcf\data\jcoins\shop\item\JCoinsShopItem
	 */
	public $item = null;

	/**
	 * item id
	 * @var	integer
	 */
	public $itemID = 0;

	/**
	 * @see	\wcf\page\IPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();

		if (isset($_REQUEST['id'])) $this->itemID = intval($_REQUEST['id']);
		$this->item = new JCoinsShopItem($this->itemID);

		if (!$this->item->itemID) throw new IllegalLinkException();
	}

	/**
	 * @see	\wcf\page\IPage::readData()
	 */
	public function readData() {
		parent::readData();

		if (empty($_POST)) {
			I18nHandler::getInstance()->setOptions('description', PACKAGE_ID, $this->item->description, 'wcf.jcoins.shop.item.description\d+');
			I18nHandler::getInstance()->setOptions('name', PACKAGE_ID, $this->item->name, 'wcf.jcoins.shop.item.name\d+');
			
			$this->typeID = $this->item->itemType;
			$this->price = $this->item->price;
			$this->showOrder = $this->item->showOrder;
			$this->parseBBCodes = (bool) $this->item->parseBBCodes;
			$this->allowHTML = (bool) $this->item->allowHTML;
			$this->allowSmileys = (bool) $this->item->allowSmileys;
			
			foreach ($this->item->getParameters() as $id => $param) {
				$this->parameterParameters[$id] = $param; 
			}
		}
	}

	/**
	 * @see	\wcf\form\IForm::save()
	 */
	public function save() {
		$description = 'wcf.jcoins.shop.item.description' . $this->item->itemID;
		if (I18nHandler::getInstance()->isPlainValue('description')) {
			I18nHandler::getInstance()->remove($description);
			$description = I18nHandler::getInstance()->getValue('description');
		} else {
			I18nHandler::getInstance()->save('description', $description, 'wcf.jcoins');
		}
		
		$name = 'wcf.jcoins.shop.item.name' . $this->item->itemID;
		if (I18nHandler::getInstance()->isPlainValue('name')) {
			I18nHandler::getInstance()->remove($description);
			$name = I18nHandler::getInstance()->getValue('name');
		} else {
			I18nHandler::getInstance()->save('name', $name, 'wcf.jcoins');
		}
		
		$action = new \wcf\data\jcoins\shop\item\JCoinsShopItemAction(array($this->item), 'update', array(
		    'data' => array(
			'itemType' => $this->type->itemTypeID, 
			'price' => $this->price, 
			'description' => $description, 
			'name' => $name, 
			'showOrder' => $this->showOrder, 
			'parseBBCodes' => ($this->parseBBCodes) ? 1 : 0,
			'allowHTML' => ($this->allowHTML) ? 1 : 0,
			'allowSmileys' => ($this->allowSmileys) ? 1 : 0,
			), 
		    'parameters' => $this->parameterParameters
		));
		$action->executeAction(); 

		$this->saved(); 
		
		// show success
		WCF::getTPL()->assign('success', true);
	}

	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		I18nHandler::getInstance()->assignVariables(!empty($_POST));

		
		
		WCF::getTPL()->assign('item', $this->item);
	}
}
