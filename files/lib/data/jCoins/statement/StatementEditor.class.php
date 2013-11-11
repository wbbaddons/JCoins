<?php
namespace wcf\data\jCoins\statement;

use wcf\data\DatabaseObjectEditor;

/**
 * Provides functions to edit statements.
 * 
 * @author	Joshua Rüsweg
 * @package	de.joshsboard.jcoins
 */
class StatementEditor extends DatabaseObjectEditor {

	/**
	 * @see	wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'wcf\data\jCoins\statement\Statement';

}
