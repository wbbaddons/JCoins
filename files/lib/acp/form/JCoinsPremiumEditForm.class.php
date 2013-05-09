<?php
namespace wcf\acp\form;
use wcf\acp\form\JCoinsPremiumAddForm; 
use wcf\system\WCF;
use wcf\data\jCoins\premiumGroup\PremiumGroup; 
use wcf\system\exception\IllegalLinkException;
use wcf\data\jCoins\premiumGroup\PremiumGroupAction;  
use wcf\system\language\I18nHandler; 
use wcf\data\package\PackageCache;

/**
 * jcoins Premium Group Edit Form
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 * @subpackage	acp.form
 */
class JCoinsPremiumEditForm extends JCoinsPremiumAddForm {
	/**
	 * @see	wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.jcoins.premium.edit';

	/**
	 * @see	wcf\page\AbstractPage::$templateName
	 */
	public $templateName = 'JCoinsPremiumGroupAction';

	/**
	 * @see wcf\page\AbstractPage::$action
	 */
	public $action = 'edit';
	
	/**
	 * the premium group obj
	 * @var wcf\data\jCoins\premiumGroup\PremiumGroup
	 */
	public $pGroupObj   = null; 
	
	/**
	 * the object ID from the premiumgroup
	 * @var integer
	 */
	public $pGroupID = 0; 
	
	/**
	 * @see	wcf\page\AbstractPage::readParameters
	 */
	public function readParameters() {
		parent::readParameters();
		
		$this->pGroupID = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : 0; 
		$this->pGroupObj = new PremiumGroup($this->pGroupID);
		
		if (!$this->pGroupObj->premiumGroupID) throw new IllegalLinkException(); 
	}
	
	/**
	 * @see wcf\page\AbstractPage::readData
	 */
	public function readData() {
		parent::readData();

		if (empty($_POST)) {
			I18nHandler::getInstance()->setOptions('description', PackageCache::getInstance()->getPackageID('de.joshsboard.jCoins'),  $this->pGroupObj->description, 'wcf.jCoins.premiumGroups.description\d+');
		}
	}

	/**
	 * @see	wcf\form\IForm::save()
	 */
	public function save() {
		if (I18nHandler::getInstance()->isPlainValue('description')) {
			I18nHandler::getInstance()->remove($this->description, PackageCache::getInstance()->getPackageID('com.woltlab.wcf.user'));
			$this->description = I18nHandler::getInstance()->getValue('description');
		}
		else {
			I18nHandler::getInstance()->save('description', $this->description, 'wcf.jCoins', PackageCache::getInstance()->getPackageID('de.joshsboard.jCoins'));
		}
		
		// update premiumgroup
		$this->objectAction = new PremiumGroupAction(array($this->pGroupID), 'update', array('data' => array(
			'jCoins'	=> $this->jCoins,
			'description'	=> 'wcf.jCoins.premiumGroups.description'.$this->pGroupID
		)));
		$this->objectAction->executeAction();
		
		// show success
		WCF::getTPL()->assign(array(
			'success' => true
		));
		
		$this->pGroupObj = new PremiumGroup($this->pGroupID);
	}

	/**
	 * @see	wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'premiumGroupID' => $this->pGroupObj->premiumGroupID
		));
	}
}