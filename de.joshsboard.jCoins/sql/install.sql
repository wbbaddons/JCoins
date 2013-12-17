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

ALTER TABLE  wcf1_user ADD  jCoinsBalance INT(10) NOT NULL DEFAULT '0';

-- foreign keys
ALTER TABLE wcf1_user_jcoins_statement ADD FOREIGN KEY (executedUserID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE wcf1_user_jcoins_statement ADD FOREIGN KEY (userID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;

ALTER TABLE wcf1_user_group_premium ADD FOREIGN KEY (groupID) REFERENCES wcf1_user_group (groupID) ON DELETE CASCADE;
