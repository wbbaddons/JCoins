<?php
namespace wcf\data\jCoins\premiumGroup;
use wcf\data\DatabaseObjectEditor;

/**
 * premium group editor 
 * 
 * @author  Joshua Rüsweg
 * @package de.joshsboard.jcoins
 */
class PremiumGroupEditor extends DatabaseObjectEditor {
	/**
	 * @see	wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'wcf\data\jCoins\premiumGroup\PremiumGroup';
}