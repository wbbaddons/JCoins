<?php
// sql pipe doesn't support renaming
$stmt = \wcf\system\WCF::getDB()->prepareStatement("ALTER TABLE wcf". WCF_N ."_jcoins_shop_item_type RENAME COLUMN isMultible TO isMultiple;");
$stmt->execute();

$stmt = \wcf\system\WCF::getDB()->prepareStatement("
ALTER TABLE  wcf". WCF_N ."_jcoins_shop_item ADD (
	parseBBCodes BOOLEAN NOT NULL DEFAULT 1, 
	allowHTML BOOLEAN NOT NULL DEFAULT 0, 
	allowSmileys BOOLEAN NOT NULL DEFAULT 0
)");
$stmt->execute(); 

// for update :)
$sql = "UPDATE wcf". WCF_N ."_user_jcoins_statement SET additionalData = ?";
$stmt = wcf\system\WCF::getDB()->prepareStatement($sql); 
$stmt->execute(array('a:0:{}'));