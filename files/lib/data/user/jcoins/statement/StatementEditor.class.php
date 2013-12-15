<?php
namespace wcf\data\user\jcoins\statement;

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
	protected static $baseClass = 'wcf\data\user\jcoins\statement\Statement';

}
