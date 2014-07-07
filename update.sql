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