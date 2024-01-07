

DROP TABLE IF EXISTS `toggle_section_config`;

CREATE TABLE `toggle_section_config` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section` varchar(45) DEFAULT NULL,
  `enable` tinyint DEFAULT '1',
  PRIMARY KEY (`id`)
);

INSERT INTO `toggle_section_config` VALUES (1,'vocab',1),(2,'type_master',1),(3,'discussion',0),(4,'competitions',1),(5,'context_vocab',1),(6,'spellathon',1),(7,'learn_typing',1);
