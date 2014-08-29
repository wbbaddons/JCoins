<?php
// sql pipe doesn't support renaming
$stmt = \wcf\system\WCF::getDB()->prepareStatement("ALTER TABLE wcf1_jcoins_shop_item_type RENAME COLUMN isMultible TO isMultiple;");
$stmt->execute();

$stmt = \wcf\system\WCF::getDB()->prepareStatement("
ALTER TABLE  wcf1_user_jcoins_statement ADD (
	parseBBCodes BOOLEAN NOT NULL DEFAULT 1, 
	allowHTML BOOLEAN NOT NULL DEFAULT 0, 
	allowSmileys BOOLEAN NOT NULL DEFAULT 0
)");
$stmt->execute(); 