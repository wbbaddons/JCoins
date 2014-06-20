<?php
namespace wcf\system\package\plugin;

use wcf\data\jcoins\shop\item\type\JCoinsShopItemType; 
use wcf\system\exception\SystemException;
use wcf\system\WCF;

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
	 * @see	\wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::prepareImport()
	 */
	protected function prepareImport(array $data) {
		return array(
			'isMultible' => (isset($data['elements']['multible'])) ? intval($data['elements']['multible']) : 0,
			'className' => (isset($data['elements']['classname'])) ? $data['elements']['classname'] : '', 
			'identifer' => (isset($data['elements']['identifer'])) ? $data['elements']['identifer'] : ''
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
				$package = new \wcf\data\package\Package($this->installation->getPackageID());
				
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