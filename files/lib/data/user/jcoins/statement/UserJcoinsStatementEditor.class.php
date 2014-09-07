<?php
namespace wcf\data\user\jcoins\statement;

use wcf\data\DatabaseObjectEditor;

/**
 * Provides functions to edit statements.
 * 
 * @author	Joshua Rüsweg
 * @copyright	2013-2014 Joshua Rüsweg
 * @license	Creative Commons Attribution-ShareAlike 4.0 <https://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package	de.joshsboard.jcoins
 */
class UserJcoinsStatementEditor extends DatabaseObjectEditor {

	/**
	 * @see	wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'wcf\data\user\jcoins\statement\UserJcoinsStatement';

}
