
DROP TABLE IF EXISTS booster_criteria;

CREATE TABLE booster_criteria (
  id int NOT NULL AUTO_INCREMENT,
  booster int NOT NULL,
  minimum_day_streak int DEFAULT '0',
  minimum_questions int DEFAULT '0',
  created_at datetime DEFAULT CURRENT_TIMESTAMP,
  updated_at datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

INSERT INTO booster_criteria VALUES (1,1,3,0,'2023-11-27 14:32:43','2023-11-27 14:32:43');
INSERT INTO booster_criteria VALUES (2,2,5,0,'2023-11-27 14:33:18','2023-11-27 14:33:18');
INSERT INTO booster_criteria VALUES (3,3,7,0,'2023-11-27 14:33:26','2023-11-27 14:33:26');
INSERT INTO booster_criteria VALUES (4,4,10,0,'2023-11-27 14:33:40','2023-11-27 14:33:40');
INSERT INTO booster_criteria VALUES (5,1,0,3,'2023-11-27 14:33:55','2023-11-27 14:33:55');

--
-- Table structure for table `boosters`
--

DROP TABLE IF EXISTS boosters;

CREATE TABLE boosters (
  id int NOT NULL AUTO_INCREMENT,
  booster_name varchar(255) NOT NULL,
  booster_timer int DEFAULT NULL,
  score_multiplier int DEFAULT '1',
  incorrect_score_multiplier int DEFAULT '1',
  minimum_time int DEFAULT NULL,
  booster_icon varchar(100) DEFAULT NULL,
  booster_content varchar(500) DEFAULT NULL,
  booster_info varchar(500) DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  created_at datetime DEFAULT CURRENT_TIMESTAMP,
  updated_at datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

INSERT INTO boosters VALUES (1,'2X Booster ',120,2,1,30,'double_multiplier.png','You are using the 2x Booster from daily streak!!','This booster will give a 2X score multiplier to every correct option chosen within 30 secs for the next 2 minutes.',1,'2023-11-18 15:05:45','2023-11-19 17:09:02');
INSERT INTO boosters VALUES (2,'3X Booster ',120,3,1,30,'triple_multiplier.jpg','You are using the 3x Booster from daily streak!!','This booster will give a 3X score multiplier to every correct option chosen within 30 secs for the next 2 minutes.',1,'2023-11-18 15:15:29','2023-11-19 17:09:41');
INSERT INTO boosters VALUES (3,'4X Booster',120,4,1,30,'quadruple_multiplier.png','You are using the 4x Booster from daily streak!!','This booster will give a 4X score multiplier to every correct option chosen within 30 secs for the next 2 minutes.',1,'2023-11-18 15:17:02','2023-11-19 17:09:58');
INSERT INTO boosters VALUES (4,'5X Booster',120,5,1,30,'pentuple_multiplier.png','You are using the 5x Booster from daily streak!!','This booster will give a 5X score multiplier to every correct option chosen within 30 secs for the next 2 minutes.',1,'2023-11-18 15:17:57','2023-11-19 17:10:12');

