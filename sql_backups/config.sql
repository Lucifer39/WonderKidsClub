

DROP TABLE IF EXISTS config;

CREATE TABLE config (
  id int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `value` varchar(45) DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  created_at datetime DEFAULT NULL,
  PRIMARY KEY (id)
);

INSERT INTO config VALUES (1,'ques_before_login','2','2023-12-30 09:12:38','2023-12-30 09:12:38');