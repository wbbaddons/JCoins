<?php
namespace wcf\page;
use wcf\data\jcoins\shop\item\JCoinsShopItem;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\util\FileReader;

/**
 * Shows an shop download
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class JCoinsShopDownloadPage extends AbstractPage {
	/**
	 * @see	\wcf\page\IPage::$useTemplate
	 */
	public $useTemplate = false;
	
	/**
	 * item id
	 * @var	integer
	 */
	public $itemID = 0;
	
	/**
	 * item id
	 * @var	\wcf\data\jcoins\shop\item\JCoinsShopItem
	 */
	public $item = 0;
	
	/**
	 * @see	\wcf\page\AbstractPage::$neededModules
	 */
	public $neededModules = array('MODULE_JCOINS', 'MODULE_JCOINS_SHOP');
	
	/**
	 * file reader object
	 * @var	\wcf\util\FileReader
	 */
	public $fileReader = null;
	
	public $neededPermissions = array('user.jcoins.canUseShop', 'user.jcoins.canUse');
	
	/**
	 * @see	\wcf\page\IPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['id'])) $this->itemID = intval($_REQUEST['id']);
		$this->item = new JCoinsShopItem($this->itemID);
		if (!$this->item->itemID) {
			throw new IllegalLinkException();
		}
	}
	
	/**
	 * @see	\wcf\page\IPage::checkPermissions()
	 */
	public function checkPermissions() {
		parent::checkPermissions();
		
		if (!$this->item->hasBought()) {
			throw new PermissionDeniedException(); 
		}
	}
	
	/**
	 * @see	\wcf\page\IPage::readData()
	 */
	public function readData() {
		parent::readData();
		
		$downloadItem = new \wcf\system\jcoins\shop\item\type\DownloadItem();
		
		$parameters = $downloadItem->prepare($this->item->getParameters());
		
		// init file reader
		$this->fileReader = new FileReader(RELATIVE_WCF_DIR.$parameters['source'], array());
	}
	
	/**
	 * @see	\wcf\page\IPage::show()
	 */
	public function show() {
		parent::show();
		
		// send file to client
		$this->fileReader->send();
		exit;
	}
}
