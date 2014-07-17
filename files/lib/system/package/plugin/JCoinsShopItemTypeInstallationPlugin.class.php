<?php
namespace wcf\system\package\plugin;

use wcf\data\jcoins\shop\item\type\JCoinsShopItemType; 
use wcf\system\exception\SystemException;
use wcf\system\WCF;
use wcf\system\Regex; 

/**
 * Installs, updates and deletes JCoins Shop-Item Types.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 * @subpackage	acp.package.plugin
 * @category	Community Framework
 */
class JCoinsShopItemTypeInstallationPlugin extends AbstractXMLPackageInstallationPlugin {
	/**
	 * @see	\wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::$className
	 */
	public $className = 'wcf\data\jcoins\shop\item\type\JCoinsShopItemTypeEditor';

	/**
	 * list of params
	 * @var	array<array>
	 */
	protected $params = array();
	
	public $allowedTypes = array('TEXT', 'INTEGER', 'BOOL', 'TEXTAREA'); 
	
	/**
	 * @see	\wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::handleDelete()
	 */
	protected function handleDelete(array $items) {
		$sql = "DELETE FROM	wcf".WCF_N."_".$this->tableName."
			WHERE		className = ?
					AND packageID = ?";
		$statement = WCF::getDB()->prepareStatement($sql);
		foreach ($items as $item) {
			$statement->execute(array(
				$item['elements']['classname'],
				$this->installation->getPackageID()
			));
		}
	}
	
	/**
	 * @see	\wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::getElement()
	 */
	protected function getElement(\DOMXPath $xpath, array &$elements, \DOMElement $element) {
		$nodeValue = $element->nodeValue;

		// read pages
		if ($element->tagName == 'parameters') {
			$nodeValue = array();

			$param = $xpath->query('child::ns:parameter', $element);
			foreach ($param as $p) {
				
				$child = $xpath->query('child::*', $p);
				
				foreach ($child as $c) {
					$value[$c->tagName] = $c->nodeValue; 
				}
				
				$nodeValue[] = $value;
			}
		}

		$elements[$element->tagName] = $nodeValue;
	}

	/**
	 * @see	\wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::import()
	 */
	protected function import(array $row, array $data) {
		// extract pages
		$params = $data['parameters'];
		unset($data['parameters']);

		// import or update action
		$object = parent::import($row, $data);

		// store pages for later import
		$this->params[$object->getObjectID()] = $params;
	}
	
	/**
	 * @see	\wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::postImport()
	 */
	protected function postImport() {
		// clear params
		$sql = "DELETE FROM	wcf".WCF_N."_jcoins_shop_item_type_parameter
			WHERE		packageID = ?";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($this->installation->getPackageID()));

		if (!empty($this->params)) {
			// insert pages
			$sql = "INSERT INTO	wcf".WCF_N."_jcoins_shop_item_type_parameter
						(itemTypeID, name, regex, type, packageID)
				VALUES		(?, ?, ?, ?, ?)";
			$statement = WCF::getDB()->prepareStatement($sql);
			foreach ($this->params as $itemID => $params) {
				foreach ($params as $param) {
					$param = $this->validateParameters($param); 
					$statement->execute(array(
						$itemID,
						$param['name'], 
						(isset($param['regex'])) ? $param['regex'] : '', 
						$param['type'], 
						$this->installation->getPackageID()
					));
				}
			}
		}
	}
	
	/**
	 * validate parameters
	 * @param array<String> $param
	 * @return array<String>
	 */
	protected function validateParameters($param) {
		if (!isset($param['name']) || empty($param['name'])) {
			throw new SystemException('a Parameter name cannot be empty');
		}
		
		if (isset($param['regex']) && !empty($param['regex'])) {
			$regex = new Regex($param['regex']); 
			if (!$regex->isValid()) {
				throw new SystemException('the regex of "'. $param['name'] .'" is invalid');
			}
		} else {
			$param['regex'] = ''; 
		}
		
		if (isset($param['type'])) {
			$param['type'] = strtoupper($param['type']); 
			
			if (!in_array($param['type'], $this->allowedTypes)) {
				throw new SystemException('the type for "'. $param['name'] .'" is invalid');
			}
		} else {
			throw new SystemException('the type for "'. $param['name'] .'" is invalid');
		}
		
		return $param; 
	}


	/**
	 * @see	\wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::prepareImport()
	 */
	protected function prepareImport(array $data) {
		return array(
			'isMultiple' => (isset($data['elements']['multiple'])) ? intval($data['elements']['multiple']) : 0,
			'className' => (isset($data['elements']['classname'])) ? $data['elements']['classname'] : '', 
			'identifer' => (isset($data['elements']['identifer'])) ? $data['elements']['identifer'] : '', 
			'parameters' => (isset($data['elements']['parameters'])) ? $data['elements']['parameters'] : array(),
		);
	}

	/**
	 * @see	\wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::validateImport()
	 */
	protected function validateImport(array $data) {
		if (empty($data['className'])) {
			throw new SystemException('className cannot be empty');
		}
		
		if (empty($data['identifer'])) {
			throw new SystemException('identifer cannot be empty');
		} else {
			$type = JCoinsShopItemType::getByIdentifer($data['identifer']); 
			
			if ($type->getObjectID() != 0) {
				$package = new \wcf\data\package\Package($type->packageID);
				
				throw new SystemException('identifer is not unique (use by: '. $package->packageName .')');
			}
		}
	}

	/**
	 * @see	\wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::findExistingItem()
	 */
	protected function findExistingItem(array $data) {
		return null;
	}
}