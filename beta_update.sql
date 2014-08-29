ALTER TABLE  wcf1_user_jcoins_statement ADD additionalData MEDIUMTEXT;

ALTER TABLE  wcf1_user_jcoins_statement ADD (
	parseBBCodes BOOLEAN NOT NULL DEFAULT 1, 
	allowHTML BOOLEAN NOT NULL DEFAULT 0, 
	allowSmileys BOOLEAN NOT NULL DEFAULT 0
);