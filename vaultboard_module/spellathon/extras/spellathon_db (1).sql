

DROP TABLE IF EXISTS class_group;

CREATE TABLE class_group (
  id int NOT NULL AUTO_INCREMENT,
  group_name int DEFAULT NULL,
  class_collection longtext,
  PRIMARY KEY (id)
);
INSERT INTO class_group VALUES (1,1,'Prep');
INSERT INTO class_group VALUES (2,2,'1,2');
INSERT INTO class_group VALUES (3,3,'3,4,5');

