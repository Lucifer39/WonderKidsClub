
DROP TABLE IF EXISTS proficiency_levels;

CREATE TABLE proficiency_levels (
  id int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  minimum_questions int DEFAULT NULL,
  icon varchar(255) DEFAULT NULL,
  PRIMARY KEY (id)
);

INSERT INTO proficiency_levels VALUES (1,'Counting Cadet',2,'counting_cadet.svg');
INSERT INTO proficiency_levels VALUES (2,'Math Maestro',3,'math_maestro.svg');
INSERT INTO proficiency_levels VALUES (3,'Number Ninja',4,'number_ninja.svg');

DROP TABLE IF EXISTS user_proficiency;

CREATE TABLE user_proficiency (
  id int NOT NULL AUTO_INCREMENT,
  userid int DEFAULT NULL,
  subtopic_id int DEFAULT NULL,
  questions_practiced int DEFAULT NULL,
  proficiency_level int DEFAULT NULL,
  updated_at datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);