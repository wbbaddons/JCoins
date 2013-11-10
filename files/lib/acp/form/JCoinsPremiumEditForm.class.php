<?php
namespace wcf\acp\form;

use wcf\data\user\group\premiumGroup\PremiumGroup;
use wcf\data\user\group\premiumGroup\PremiumGroupAction;
use wcf\system\exception\IllegalLinkException;
use wcf\system\language\I18nHandler;
use wcf\system\WCF;

/**
 * Shows the premium-group edit-form.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 * @subpackage	acp.form
 */
class JCoinsPremiumEditForm extends JCoinsPremiumAddForm {
    /**
     * @see	\wcf\page\AbstractPage::$activeMenuItem
     */
    public $activeMenuItem = 'wcf.acp.menu.link.jcoins.premium.add';

    /**
     * @see	\wcf\page\AbstractPage::$neededModules
     */
    public $neededModules = array('MODULE_JCOINS', 'MODULE_JCOINS_PREMIUMGROUPS');

    /**
     * @see	\wcf\page\AbstractPage::$action
     */
    public $action = 'edit';

    /**
     * premium group
     * @var	\wcf\data\jCoins\premiumGroup\PremiumGroup
     */
    public $premiumGroup = null;

    /**
     * premium-group id
     * @var	integer
     */
    public $premiumGroupID = 0;

    /**
     * @see	\wcf\page\IPage::readParameters()
     */
    public function readParameters() {
        parent::readParameters();

        if (isset($_REQUEST['id'])) $this->premiumGroupID = intval($_REQUEST['id']);
        $this->premiumGroup = new PremiumGroup($this->premiumGroupID);

        if (!$this->premiumGroup->premiumGroupID) throw new IllegalLinkException();
    }

    /**
     * @see	\wcf\page\IPage::readData()
     */
    public function readData() {
        parent::readData();

        if (empty($_POST)) {
            I18nHandler::getInstance()->setOptions('description', PACKAGE_ID, $this->premiumGroup->description, 'wcf.jcoins.premiumGroups.description\d+');

            $this->jCoins = $this->premiumGroup->jCoins;
            $this->period = $this->premiumGroup->period;
            $this->groupID = $this->premiumGroup->groupID;
        }
    }

    /**
     * @see	\wcf\form\IForm::save()
     */
    public function save() {
        
        $description = 'wcf.jcoins.premiumGroups.description' . $this->premiumGroup->premiumGroupID;
        if (I18nHandler::getInstance()->isPlainValue('description')) {
            I18nHandler::getInstance()->remove($description);
            $description = I18nHandler::getInstance()->getValue('description');
        } else {
            I18nHandler::getInstance()->save('description', $description, 'wcf.jcoins');
        }

        // update premiumgroup
        $this->objectAction = new PremiumGroupAction(array($this->premiumGroup), 'update', array(
            'data' => array(
                'jCoins' => $this->jCoins,
                'description' => $description
            )
        ));
        $this->objectAction->executeAction();

        // show success
        WCF::getTPL()->assign('success', true);
    }

    /**
     * @see	\wcf\page\IPage::assignVariables()
     */
    public function assignVariables() {
        parent::assignVariables();

        I18nHandler::getInstance()->assignVariables(!empty($_POST));

        WCF::getTPL()->assign('premiumGroup', $this->premiumGroup);
    }

    /**
     * @see	\wcf\acp\form\JCoinsPremiumAddForm::validateGroup()
     */
    public function validateGroup() {
        // the group can not be changed, therefore it must not be checked
    }
}