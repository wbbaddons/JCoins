DROP TABLE IF EXISTS wcf1_statement_entrys;
CREATE TABLE wcf1_statement_entrys (
	entryID			INT(11) 		NOT NULL AUTO_INCREMENT PRIMARY KEY,
	userID 			INT(11) 		NOT NULL DEFAULT 0,
	executedUserID		INT(11) 		NOT NULL DEFAULT 0,
	time 			INT(9) 			NOT NULL DEFAULT 0,
	reason 			VARCHAR(255)		NOT NULL DEFAULT '',
	sum 			INT(11) 		NOT NULL DEFAULT 0, 
	isTrashed		BOOLEAN			NOT NULL DEFAULT 0
);

DROP TABLE IF EXISTS wcf1_user_group_premium;
CREATE TABLE wcf1_user_group_premium (
	premiumGroupID		INT(11)			NOT NULL AUTO_INCREMENT PRIMARY KEY,
	groupID 		INT(11) 		NOT NULL DEFAULT 0,
	jCoins 			INT(11) 		NOT NULL DEFAULT 0,
	period 			INT(11) 		NOT NULL DEFAULT 0,
	isDisabled 		TINYINT(1) 		NOT NULL DEFAULT 0,
	description		MEDIUMTEXT		NOT NULL
);

DROP TABLE IF EXISTS wcf1_user_to_group_premium;
CREATE TABLE wcf1_user_to_group_premium (
	userID 			INT(11) 		NOT NULL DEFAULT 0,
	premiumGroupID		INT(11) 		NOT NULL DEFAULT 0,
	until 			INT(11)			NOT NULL
);

ALTER TABLE  wcf1_user ADD  jCoinsBalance INT(11) NOT NULL DEFAULT '0';
