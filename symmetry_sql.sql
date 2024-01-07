

DROP TABLE IF EXISTS symmetry_mapping;

CREATE TABLE symmetry_mapping (
  id int NOT NULL AUTO_INCREMENT,
  imgName varchar(45) DEFAULT NULL,
  straight_lines int NOT NULL DEFAULT '0',
  curved_lines int NOT NULL DEFAULT '0',
  standing_lines int NOT NULL DEFAULT '0',
  sleeping_lines int NOT NULL DEFAULT '0',
  slanting_lines int DEFAULT '0',
  lines_of_symmetry int DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO symmetry_mapping VALUES (1,'0',0,2,0,0,0,2);
INSERT INTO symmetry_mapping VALUES (2,'1',5,2,3,2,0,0);
INSERT INTO symmetry_mapping VALUES (3,'9',0,3,0,0,1,0);
INSERT INTO symmetry_mapping VALUES (4,'8',0,4,0,0,0,1);
INSERT INTO symmetry_mapping VALUES (5,'7',5,2,2,3,0,0);
INSERT INTO symmetry_mapping VALUES (6,'6',1,3,0,0,1,0);
INSERT INTO symmetry_mapping VALUES (7,'5',7,2,1,2,4,0);
INSERT INTO symmetry_mapping VALUES (8,'4',14,0,6,6,2,0);
INSERT INTO symmetry_mapping VALUES (9,'3',0,4,0,0,3,0);
INSERT INTO symmetry_mapping VALUES (10,'2',0,2,1,2,1,0);
INSERT INTO symmetry_mapping VALUES (11,'A',11,0,0,5,6,1);
INSERT INTO symmetry_mapping VALUES (12,'B',3,4,3,0,0,0);
INSERT INTO symmetry_mapping VALUES (13,'C',2,2,0,0,2,1);
INSERT INTO symmetry_mapping VALUES (14,'D',2,2,2,0,0,1);
INSERT INTO symmetry_mapping VALUES (15,'E',12,0,6,6,0,1);
INSERT INTO symmetry_mapping VALUES (16,'F',10,0,5,5,0,0);
INSERT INTO symmetry_mapping VALUES (17,'G',6,2,3,2,1,0);
INSERT INTO symmetry_mapping VALUES (18,'H',12,0,6,6,0,2);
INSERT INTO symmetry_mapping VALUES (19,'I',4,0,2,2,0,2);
INSERT INTO symmetry_mapping VALUES (20,'J',2,2,0,1,1,0);
INSERT INTO symmetry_mapping VALUES (21,'K',12,0,3,4,5,0);
INSERT INTO symmetry_mapping VALUES (22,'L',6,0,3,3,0,0);
INSERT INTO symmetry_mapping VALUES (23,'M',13,0,4,5,4,1);
INSERT INTO symmetry_mapping VALUES (24,'N',10,0,4,4,2,0);
INSERT INTO symmetry_mapping VALUES (25,'O',0,2,0,0,0,2);
INSERT INTO symmetry_mapping VALUES (26,'P',4,2,3,1,0,0);
INSERT INTO symmetry_mapping VALUES (27,'Q',2,6,0,0,2,0);
INSERT INTO symmetry_mapping VALUES (28,'R',5,4,3,2,0,0);
INSERT INTO symmetry_mapping VALUES (29,'S',2,2,0,0,2,0);
INSERT INTO symmetry_mapping VALUES (30,'T',8,0,4,4,0,1);
INSERT INTO symmetry_mapping VALUES (31,'U',2,2,0,2,0,1);
INSERT INTO symmetry_mapping VALUES (32,'V',7,0,0,3,4,1);
INSERT INTO symmetry_mapping VALUES (33,'W',13,0,0,5,8,1);
INSERT INTO symmetry_mapping VALUES (34,'X',12,0,0,4,8,2);
INSERT INTO symmetry_mapping VALUES (35,'Y',9,0,2,3,4,1);
INSERT INTO symmetry_mapping VALUES (36,'Z',10,0,4,4,2,0);
