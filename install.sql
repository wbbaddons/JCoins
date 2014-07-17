DROP TABLE IF EXISTS wcf1_user_jcoins_statement;
CREATE TABLE wcf1_user_jcoins_statement (
	entryID			INT(10) 		NOT NULL AUTO_INCREMENT PRIMARY KEY,
	userID 			INT(10)			NOT NULL,
	executedUserID		INT(10),
	time 			INT(10)			NOT NULL DEFAULT 0,
	reason 			VARCHAR(255)		NOT NULL DEFAULT '',
	link			VARCHAR(255)		NOT NULL DEFAULT '',
	sum 			INT(10) 		NOT NULL DEFAULT 0, 
	isTrashed		BOOLEAN			NOT NULL DEFAULT 0,
	isModTransfer		BOOLEAN			NOT NULL DEFAULT 0,
	KEY user (userID),
	KEY executedUser (executedUserID)
);

DROP TABLE IF EXISTS wcf1_user_group_premium;
CREATE TABLE wcf1_user_group_premium (
	premiumGroupID		INT(10)			NOT NULL AUTO_INCREMENT PRIMARY KEY,
	groupID 		INT(10),
	jCoins 			INT(10) 		NOT NULL DEFAULT 0,
	period 			INT(10) 		NOT NULL DEFAULT 0,
	isDisabled 		TINYINT(1) 		NOT NULL DEFAULT 0,
	description		MEDIUMTEXT		NOT NULL,
	KEY userGroup (groupID)
);

-- SHOP :) 

DROP TABLE IF EXISTS wcf1_jcoins_shop_item_type;
CREATE TABLE wcf1_jcoins_shop_item_type (
	itemTypeID  		INT(10)			NOT NULL AUTO_INCREMENT PRIMARY KEY,
        identifer               MEDIUMTEXT              NOT NULL, 
        isMultiple              BOOLEAN                 NOT NULL DEFAULT 1,
        className               MEDIUMTEXT              NOT NULL, 
        packageID               INT(10)
);

DROP TABLE IF EXISTS wcf1_jcoins_shop_item_type_parameter;
CREATE TABLE wcf1_jcoins_shop_item_type_parameter (
	parameterID  		INT(10)			NOT NULL AUTO_INCREMENT PRIMARY KEY,
        itemTypeID              INT(10)                 NOT NULL, 
        name                    VARCHAR(30)             NOT NULL, 
        regex                   VARCHAR(255), 
        type                    MEDIUMTEXT, 
        packageID               INT(10)
);

DROP TABLE IF EXISTS wcf1_jcoins_shop_item;
CREATE TABLE wcf1_jcoins_shop_item (
	itemID  		INT(10)			NOT NULL AUTO_INCREMENT PRIMARY KEY,
        itemType                INT(10),
        isDisabled              BOOLEAN                 NOT NULL DEFAULT 0,
        price                   INT(10)                 NOT NULL DEFAULT 0, 
        description             MEDIUMTEXT              NOT NULL, 
        name                    VARCHAR(255)            NOT NULL DEFAULT '',
	parseBBCodes		BOOLEAN			NOT NULL DEFAULT 1, 
	allowHTML		BOOLEAN			NOT NULL DEFAULT 0, 
	allowSmileys		BOOLEAN			NOT NULL DEFAULT 0, 
        showOrder               INT(10)
);

DROP TABLE IF EXISTS wcf1_jcoins_shop_item_parameter;
CREATE TABLE wcf1_jcoins_shop_item_parameter (
	itemID  		INT(10)                 NOT NULL,
        parameterID             INT(10),
        value                   TEXT
);

DROP TABLE IF EXISTS wcf1_jcoins_shop_item_bought;
CREATE TABLE wcf1_jcoins_shop_item_bought (
	itemID  		INT(10),
        userID                  INT(10),
        date                    INT(10)
);

ALTER TABLE wcf1_jcoins_shop_item ADD FOREIGN KEY (itemType) REFERENCES wcf1_jcoins_shop_item_type (itemTypeID) ON DELETE CASCADE;


ALTER TABLE wcf1_jcoins_shop_item_bought ADD FOREIGN KEY (itemID) REFERENCES wcf1_jcoins_shop_item (itemID) ON DELETE CASCADE;
ALTER TABLE wcf1_jcoins_shop_item_bought ADD FOREIGN KEY (userID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;

ALTER TABLE wcf1_jcoins_shop_item_type_parameter ADD FOREIGN KEY (itemTypeID) REFERENCES wcf1_jcoins_shop_item_type (itemTypeID) ON DELETE CASCADE;

ALTER TABLE wcf1_jcoins_shop_item_parameter ADD FOREIGN KEY (parameterID) REFERENCES wcf1_jcoins_shop_item_type_parameter (parameterID) ON DELETE CASCADE;
ALTER TABLE wcf1_jcoins_shop_item_parameter ADD FOREIGN KEY (itemID) REFERENCES wcf1_jcoins_shop_item (itemID) ON DELETE CASCADE;
-- END SHOP 



ALTER TABLE  wcf1_user ADD  jCoinsBalance INT(10) NOT NULL DEFAULT '0';

-- foreign keys
ALTER TABLE wcf1_user_jcoins_statement ADD FOREIGN KEY (executedUserID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE wcf1_user_jcoins_statement ADD FOREIGN KEY (userID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;

ALTER TABLE wcf1_user_group_premium ADD FOREIGN KEY (groupID) REFERENCES wcf1_user_group (groupID) ON DELETE CASCADE;