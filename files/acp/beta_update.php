<?php
// sql pipe doesn't support renaming
$stmt = \wcf\system\WCF::getDB()->prepareStatement("ALTER TABLE wcf1_jcoins_shop_item_type RENAME COLUMN isMultible TO isMultiple;");
$stmt->execute();
