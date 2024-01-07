

DROP TABLE IF EXISTS spellathon_live_rooms;

CREATE TABLE spellathon_live_rooms (
  id int NOT NULL AUTO_INCREMENT,
  created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  start_at timestamp NULL DEFAULT NULL,
  started tinyint DEFAULT '0',
  completed tinyint DEFAULT '0',
  question_set longtext,
  relevance int DEFAULT NULL,
  time_start_seconds int DEFAULT NULL,
  PRIMARY KEY (id)
);


INSERT INTO spellathon_live_rooms VALUES (1,'2023-07-27 23:35:22','2023-07-27 23:37:00',1,0,'[{\"content\":\"Curiosity\",\"meaning\":\"Eager desire to learn or know more about something\",\"question_type\":\"guess\"},{\"content\":\"Serendipity\",\"meaning\":\"Finding something valuable by chance\",\"question_type\":\"guess\"},{\"content\":\"Fascination\",\"meaning\":\"The state of being intensely interested or attracted\",\"question_type\":\"dictation\"},{\"content\":\"Mesmerizing\",\"meaning\":\"Holding the attention and interest of someone in a captivating way\",\"question_type\":\"dictation\"},{\"content\":\"Glimmer\",\"meaning\":\"To shine with a faint, wavering light\",\"question_type\":\"guess\"},{\"content\":\"Elixir\",\"meaning\":\"A magical or medicinal potion\",\"question_type\":\"dictation\"},{\"content\":\"Mesmerize\",\"meaning\":\"To capture someone\'s attention completely\",\"question_type\":\"dictation\"},{\"content\":\"Zestful\",\"meaning\":\"Full of energy and enthusiasm\",\"question_type\":\"jumble\"},{\"content\":\"Elation\",\"meaning\":\"A feeling of great joy or pride\",\"question_type\":\"guess\"},{\"content\":\"Luminous\",\"meaning\":\"Emitting light or full of light\",\"question_type\":\"jumble\"}]',3,0);
INSERT INTO spellathon_live_rooms VALUES (2,'2023-07-27 23:38:27','2023-07-27 23:40:00',0,0,'[{\"content\":\"Dinosaur\",\"meaning\":\"Extinct reptiles that lived millions of years ago\",\"question_type\":\"jumble\"},{\"content\":\"Library\",\"meaning\":\"Place housing books and other materials for reading\",\"question_type\":\"guess\"},{\"content\":\"Imagination\",\"meaning\":\"Ability to create mental images and ideas\",\"question_type\":\"jumble\"},{\"content\":\"Halcyon\",\"meaning\":\"Calm, peaceful, and carefree\",\"question_type\":\"dictation\"},{\"content\":\"Nebulous\",\"meaning\":\"Unclear, vague, or hazy\",\"question_type\":\"guess\"},{\"content\":\"Waterfall\",\"meaning\":\"A cascade of water falling from a height\",\"question_type\":\"guess\"},{\"content\":\"Zest\",\"meaning\":\"Enthusiastic and energetic enjoyment\",\"question_type\":\"dictation\"},{\"content\":\"Twilight\",\"meaning\":\"The soft, diffused light from the sky when the sun is below the horizon\",\"question_type\":\"guess\"},{\"content\":\"Grace\",\"meaning\":\"Elegance and beauty in movement or appearance\",\"question_type\":\"dictation\"},{\"content\":\"Glisten\",\"meaning\":\"To shine with a sparkling or reflective light\",\"question_type\":\"guess\"}]',2,NULL);
INSERT INTO spellathon_live_rooms VALUES (3,'2023-07-27 23:38:50','2023-07-27 23:40:00',1,0,'[{\"content\":\"Fascination\",\"meaning\":\"The state of being intensely interested or attracted\",\"question_type\":\"dictation\"},{\"content\":\"Zestful\",\"meaning\":\"Full of energy and enthusiasm\",\"question_type\":\"guess\"},{\"content\":\"Emerge\",\"meaning\":\"To come forth or become visible\",\"question_type\":\"dictation\"},{\"content\":\"Glitter\",\"meaning\":\"To shine with small, bright flashes of light\",\"question_type\":\"guess\"},{\"content\":\"Treasure\",\"meaning\":\"Valuable items or wealth hidden or kept safe\",\"question_type\":\"guess\"},{\"content\":\"Adventure\",\"meaning\":\"Exciting or daring experience or journey\",\"question_type\":\"guess\"},{\"content\":\"Mellifluous\",\"meaning\":\"Pleasantly smooth and musical\",\"question_type\":\"guess\"},{\"content\":\"Dreamy\",\"meaning\":\"Having a magical or unreal quality\",\"question_type\":\"dictation\"},{\"content\":\"Bubbly\",\"meaning\":\"Full of lively or excited activity\",\"question_type\":\"guess\"},{\"content\":\"Elixir\",\"meaning\":\"A magical or medicinal potion\",\"question_type\":\"dictation\"}]',3,0);
INSERT INTO spellathon_live_rooms VALUES (4,'2023-07-28 02:17:57','2023-07-28 02:20:00',1,0,'[{\"content\":\"Adventure\",\"meaning\":\"Exciting or daring experience or journey\",\"question_type\":\"jumble\"},{\"content\":\"Jubilant\",\"meaning\":\"Filled with joy and celebration\",\"question_type\":\"dictation\"},{\"content\":\"Penumbra\",\"meaning\":\"A partially shaded area around the edges of a shadow\",\"question_type\":\"dictation\"},{\"content\":\"Susurrus\",\"meaning\":\"A soft, murmuring or rustling sound\",\"question_type\":\"jumble\"},{\"content\":\"Biology\",\"meaning\":\"The study of living organisms\",\"question_type\":\"dictation\"},{\"content\":\"Resplendent\",\"meaning\":\"Shining brightly and impressively\",\"question_type\":\"guess\"},{\"content\":\"Quiescent\",\"meaning\":\"Quiet, still, or inactive\",\"question_type\":\"guess\"},{\"content\":\"Scintillating\",\"meaning\":\"Sparkling and brilliant\",\"question_type\":\"dictation\"},{\"content\":\"Luminous\",\"meaning\":\"Emitting light or full of light\",\"question_type\":\"guess\"},{\"content\":\"Sonorous\",\"meaning\":\"Producing a rich, full, and impressive sound\",\"question_type\":\"guess\"}]',3,0);
INSERT INTO spellathon_live_rooms VALUES (5,'2023-07-30 23:48:46','2023-07-30 23:50:00',1,0,'[{\"content\":\"Demagogue\",\"meaning\":\"A leader or orator who espouses the cause of the common people\",\"question_type\":\"guess\"},{\"content\":\"match\",\"meaning\":\"\",\"question_type\":\"jumble\"},{\"content\":\"important\",\"meaning\":\"\",\"question_type\":\"dictation\"},{\"content\":\"Philogynist\",\"meaning\":\"A person who likes or admires women\",\"question_type\":\"guess\"},{\"content\":\"Alchemy\",\"meaning\":\"The medieval forerunner of chemistry\",\"question_type\":\"guess\"},{\"content\":\"Drove\",\"meaning\":\"A herd or flock of animals being driven in a body\",\"question_type\":\"guess\"},{\"content\":\"Grove\",\"meaning\":\"A small growth of trees without underbrush\",\"question_type\":\"guess\"},{\"content\":\"dinner\",\"meaning\":\"\",\"question_type\":\"jumble\"},{\"content\":\"front\",\"meaning\":\"\",\"question_type\":\"dictation\"},{\"content\":\"town\",\"meaning\":\"\",\"question_type\":\"dictation\"}]',3,0);

--
-- Table structure for table `spellathon_room_players`
--

DROP TABLE IF EXISTS spellathon_room_players;

CREATE TABLE spellathon_room_players (
  id int NOT NULL AUTO_INCREMENT,
  room_id int NOT NULL,
  started tinyint DEFAULT '0',
  completed tinyint DEFAULT '0',
  score int DEFAULT NULL,
  student_id int NOT NULL,
  room_time_keeper tinyint DEFAULT '0',
  left_room tinyint DEFAULT '0',
  PRIMARY KEY (id)
) ;


--
-- Dumping data for table `spellathon_room_players`
--

INSERT INTO spellathon_room_players VALUES (1,1,1,0,0,2,1,0);
INSERT INTO spellathon_room_players VALUES (2,3,1,0,NULL,2,1,0);
INSERT INTO spellathon_room_players VALUES (3,3,1,0,NULL,4,1,0);
INSERT INTO spellathon_room_players VALUES (4,4,1,0,15,2,1,0);
INSERT INTO spellathon_room_players VALUES (5,4,1,0,10,4,1,0);
INSERT INTO spellathon_room_players VALUES (6,5,1,0,NULL,2,1,0);

--
-- Table structure for table `spellathon_words`
--

DROP TABLE IF EXISTS spellathon_words;

CREATE TABLE spellathon_words (
  id int NOT NULL AUTO_INCREMENT,
  word varchar(100) DEFAULT NULL,
  meaning longtext,
  relevance int DEFAULT NULL,
  category varchar(255) DEFAULT NULL,
  question_type varchar(45) DEFAULT 'spell',
  PRIMARY KEY (id)
);

--
-- Dumping data for table `spellathon_words`
--

INSERT INTO spellathon_words VALUES (1,'Abdication','An act of abdicating or renouncing the throne',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (2,'Almanac','An annual calendar containing important dates and statistical information such as astronomical data and tide tables',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (3,'Amphibian','A cold-blooded vertebrate animal that is born in water and breathes with gills',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (4,'Allegory','A story, poem, or picture that can be interpreted to reveal a hidden meaning, typically a moral or political one',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (5,'Axiom','A statement or proposition on which an abstractly defined structure is based',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (6,'Belligerent','A nation or person engaged in war or conflict, as recognized by international law',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (7,'Biopsy','An examination of tissue removed from a living body to discover the presence, cause or extent of a disease',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (8,'Blasphemy','The action or offence of speaking sacrilegiously about God or sacred things; profane talk',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (9,'Chronology','The arrangement of events or dates in the order of their occurrence',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (10,'Crusade','A vigorous campaign for political, social, or religious change',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (11,'Ephemeral','Lasting for a very short time',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (12,'Extempore','Spoken or done without preparation',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (13,'Exonerate','Release someone from a duty or obligation',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (14,'Gregarious','Fond of company',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (15,'Indelible','Making marks that cannot be removed',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (16,'Infallible','Incapable of making mistakes or being wrong',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (17,'Inevitable','Certain to happen',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (18,'Nostalgia','A sentimental longing or wistful affection for a period in the past',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (19,'Panacea','A solution or remedy for all difficulties or diseases',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (20,'Pantheism','A doctrine which identifies God with the universe',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (21,'Pedantic','Excessively concerned with minor details or rules',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (22,'Plagiarism','The practice of taking someone else’s work or ideas and passing them off as one’s own',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (23,'Potable','Safe to drink',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (24,'Regalia','The emblems or insignia of royalty',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (25,'Sacrilege','Violation or misuse of what is regarded as sacred',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (26,'Sinecure','A position requiring little or no work but giving the holder status or financial benefit',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (27,'Souvenir','A thing that is kept as a reminder of a person, place, or event',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (28,'Utopia','An imaginary ideal society free of poverty and suffering',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (29,'Venial','Denoting a sin that is not regarded as depriving the soul of divine grace',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (30,'Verbatim','In exactly the same words as were used originally',2,'Generic','guess');
INSERT INTO spellathon_words VALUES (31,'Anarchy','A state of disorder due to absence or non-recognition of authority or other controlling systems',2,'Systems','guess');
INSERT INTO spellathon_words VALUES (32,'Aristocracy','A form of government in which power is held by the nobility',2,'Systems','guess');
INSERT INTO spellathon_words VALUES (33,'Autocracy','A system of government by one person with absolute power',2,'Systems','guess');
INSERT INTO spellathon_words VALUES (34,'Autonomy','A self-governing country or region',2,'Systems','guess');
INSERT INTO spellathon_words VALUES (35,'Bureaucracy','A system of government in which most of the important decisions are taken by state officials rather than by elected representatives',2,'Systems','guess');
INSERT INTO spellathon_words VALUES (36,'Democracy','A system of government by the whole population or all the eligible members of a state, typically through elected representatives',2,'Systems','guess');
INSERT INTO spellathon_words VALUES (37,'Gerontocracy','A state, society, or group governed by old people',2,'Systems','guess');
INSERT INTO spellathon_words VALUES (38,'Kakistocracy','A state or country run by the worst, least qualified, or most unscrupulous citizens',2,'Systems','guess');
INSERT INTO spellathon_words VALUES (39,'Neocracy','Government by new or inexperienced hands',2,'Systems','guess');
INSERT INTO spellathon_words VALUES (40,'Ochlocracy','Government by the populace',2,'Systems','guess');
INSERT INTO spellathon_words VALUES (41,'Oligarchy','A small group of people having control of a country or organization',2,'Systems','guess');
INSERT INTO spellathon_words VALUES (42,'Plutocracy','Government by the wealthy',2,'Systems','guess');
INSERT INTO spellathon_words VALUES (43,'Secular','Government not connected with religious or spiritual matters',2,'Systems','guess');
INSERT INTO spellathon_words VALUES (44,'Monarchy','A form of government with a monarch at the head',2,'Systems','guess');
INSERT INTO spellathon_words VALUES (45,'Thearchy','A political system based on the government of men by God',2,'Systems','guess');
INSERT INTO spellathon_words VALUES (46,'Archives','A collection of historical documents or records providing information about a place, institution, or group of people',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (47,'Aviary','A large cage, building, or enclosure to keep birds ',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (48,'Abattoir','A building where animals are butchered',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (49,'Apiary','A place where bees are kept; a collection of beehives',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (50,'Aquarium','A building containing tanks of live fish of different species',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (51,'Arena','A place or scene of activity, debate, or conflict',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (52,'Arsenal','A collection of weapons and military equipment',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (53,'Asylum','An institution for the care of people who are mentally ill',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (54,'Burrow','A hole or tunnel dug by a small animal, especially a rabbit, as a dwelling',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (55,'Cache','A collection of items of the same type stored in a hidden or inaccessible place',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (56,'Casino','A public room or building where gambling games are played',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (57,'Cemetery','A large burial ground, especially one not in a churchyard',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (58,'Cloakroom','A room in a public building where outdoor clothes or luggage may be left',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (59,'Crematorium','A place where a dead person’s body is cremated',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (60,'Convent','A Christian community of nuns living together under monastic vows',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (61,'Creche','Nursery where babies and young children are cared for during the working day',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (62,'Decanter','A stoppered glass container into which wine or spirit is decanted',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (63,'Dormitory','A large bedroom for a number of people in a school or institution',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (64,'Drey','The nest of a squirrel, typically in the form of a mass of twigs in a tree',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (65,'Gymnasium','A room or building equipped for gymnastics, games, and other physical exercise',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (66,'Granary','A storehouse for threshed grain',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (67,'Hangar','A large building with an extensive floor area, typically for housing aircraft',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (68,'Hutch','A box or cage, typically with a wire mesh front, for keeping rabbits or other small domesticated animals',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (69,'Infirmary','A place in a large institution for the care of those who are ill',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (70,'Kennel','A small shelter for a dog',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (71,'Lair','A place where wild animal live',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (72,'Mint','A place where coins, medals, or tokens are made',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (73,'Menagerie','A collection of wild animals kept in captivity for exhibition',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (74,'Monastery','A building or buildings occupied by a community of monks living under religious vows',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (75,'Morgue','A place where bodies are kept for identification',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (76,'Orchard','A piece of enclosed land planted with fruit trees',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (77,'Reservoir','A large natural or artificial lake used as a source of water supply',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (78,'Scullery','A small kitchen or room at the back of a house used for washing dishes and another dirty household work',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (79,'Sheath','A close-fitting cover for the blade of a knife or sword',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (80,'Sanatorium','A room or building for sick children in a boarding school',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (81,'Tannery','A place where animal hides are tanned',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (82,'Wardrobe','A large, tall cupboard in which clothes may be hung or stored',2,'Venue / place / spot','guess');
INSERT INTO spellathon_words VALUES (83,'Battery','A group of guns or missile launchers operated together at one place',2,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (84,'Bale','A large bundle bound for storage or transport',2,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (85,'Bevy','A large gathering of people of a particular type',2,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (86,'Bouquet','An arrangement of flowers that is usually given as a present',2,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (87,'Brood','A family of young animals',2,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (88,'Cache','A group of things that have been hidden in a secret place',2,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (89,'Caravan','A group of people, typically with vehicles or animals travelling together',2,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (90,'Caucus','A closed political meeting',2,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (91,'Clique','An exclusive circle of people with a common purpose',2,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (92,'Claque','A group of followers hired to applaud at a performance',3,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (93,'Constellation','A series of stars',3,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (94,'Cortege','A funeral procession',3,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (95,'Congregation','A group of worshippers',3,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (96,'Drove','A herd or flock of animals being driven in a body',3,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (97,'Flotilla','A small fleet of ships or boats',3,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (98,'Grove','A small growth of trees without underbrush',3,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (99,'Hamlet','A community of people smaller than a village',3,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (100,'Herd','A group of cattle or sheep or other domestic mammals',3,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (101,'Horde','A large group of people',3,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (102,'Posse','A temporary police force',3,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (103,'Shoal','A large number of fish swimming together',3,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (104,'Torrent','A strong and fast-moving stream of water or other liquid',3,'Group / collection','guess');
INSERT INTO spellathon_words VALUES (105,'Agnostic','One who is not sure about God’s existence',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (106,'Arsonist','A person who deliberately sets fire to a building',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (107,'Amateur','One who does a thing for pleasure and not as a profession',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (108,'Ambidextrous','One who can use either hand with ease',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (109,'Auditor','One who makes an official examination of accounts',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (110,'Anarchist','A person who believes in or tries to bring about a state of lawlessness',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (111,'Apostate','A person who has changed his faith',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (112,'Atheist','One who does not believe in the existence of God',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (113,'Arbitrator','A person appointed by two parties to solve a dispute',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (114,'Ascetic','One who leads an austere life',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (115,'Bohemian','An unconventional style of living',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (116,'Cacographer','One who is bad in spellings',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (117,'Cannibal','One who feeds on human flesh',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (118,'Chauvinist','A person who is blindly devoted to an idea/ a person displaying aggressive or exaggerated patriotism',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (119,'Connoisseur','A critical judge of any art and craft',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (120,'Contemporaries','Persons living at the same time',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (121,'Convalescent','One who is recovering health after illness',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (122,'Coquette','A girl/woman who flirts with a man',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (123,'Cosmopolitan','A person who regards the whole world as his country',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (124,'Cynosure','One who is a centre of attraction',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (125,'Cynic','One who sneers at the beliefs of others',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (126,'Demagogue','A leader or orator who espouses the cause of the common people',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (127,'Debonair','A person having a sophisticated charm',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (128,'Demagogue','A leader who sways his followers by his oratory',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (129,'Dilettante','A dabbler (not serious) in art, science and literature',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (130,'Epicure','One who is for pleasure of eating and drinking',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (131,'Egotist','One who often talks of his achievements',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (132,'Emigrant','Someone who leaves one country to settle in another',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (133,'Effeminate','A man who is womanish in his habits',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (134,'Fastidious','One who is hard to please (very selective in his habits)',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (135,'Fugitive','One who runs away from justice',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (136,'Fanatic','One who is filled with excessive enthusiasm in religious matters',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (137,'Fatalist','One who believes in fate',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (138,'Gourmand','A lover of good food',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (139,'Honorary','Conferred as an honour',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (140,'Heretic','A person who acts against religion',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (141,'Highbrow','A person of intellectual or erudite tastes',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (142,'Hypochondriac','A patient with imaginary symptoms and ailments',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (143,'Henpeck','A person who is controlled by wife',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (144,'Indefatigable','One who shows sustained enthusiastic action with unflagging vitality',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (145,'Iconoclast','Someone who attacks cherished ideas or traditional institutions',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (146,'Introvert','One who does not express himself freely',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (147,'Immoral','Who behaves without moral principles',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (148,'Impregnable','A person who is incapable of being tampered with',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (149,'Insolvent','One who is unable to pay his debts',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (150,'Lunatic','A person who is mentally ill',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (151,'Misanthrope','A person who dislikes humankind and avoids human society',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (152,'Mercenary','A person who is primarily concerned with making money at the expense of ethics',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (153,'Narcissist','Someone in love with himself',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (154,'Numismatist','One who collect coins as hobby',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (155,'Philogynist','A person who likes or admires women',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (156,'Philanthropist','A lover of mankind',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (157,'Polyglot','A person who speaks more than one language',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (158,'Recluse','One who lives in solitude',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (159,'Somnambulist','Someone who walks in sleep',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (160,'Stoic','A person who is indifferent to the pains and pleasures of life',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (161,'Termagant','A scolding nagging bad-tempered woman',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (162,'Uxorious','A person who shows a great or excessive fondness for one’s wife',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (163,'Virtuoso','One who possesses outstanding technical ability in a particular art or field',3,'Person or people','guess');
INSERT INTO spellathon_words VALUES (164,'Alchemy','The medieval forerunner of chemistry',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (165,'Anchor','A person who presents a radio/television programme',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (166,'Anthropologist','One who studies the evolution of mankind',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (167,'Astronaut','A person who is trained to travel in a spacecraft',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (168,'Botany','The scientific study of the physiology, structure, genetics, ecology, distribution, classification and economic importance of plants',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (169,'Cartographer','A person who draws or produces maps',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (170,'Calligrapher','A person who writes beautiful writing',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (171,'Choreographer','A person who composes the sequence of steps and moves for a performance of dance',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (172,'Chauffeur','A person employed to drive a private or hired car',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (173,'Compere','A person who introduces the performers or contestants in a variety show',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (174,'Curator','A keeper or custodian of a museum or other collection',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (175,'Chronobiology','The branch of biology concerned with cyclical physiological phenomena',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (176,'Cypher','A secret or disguised way of writing',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (177,'Demography','The study of statistics',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (178,'Dactylology','The use of the fingers and hands to communicate and convey ideas',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (179,'Florist','A person who sells and arranges cut flowers',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (180,'Genealogy','A line of descent traced continuously from an ancestor',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (181,'Heliotherapy','The therapeutic use of sunlight',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (182,'Horticulture','The art or practise of garden cultivation and management',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (183,'Invigilator','One who supervises in the examination hall',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (184,'Jurisprudence','The theory or philosophy of law',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (185,'Lexicographer','A person who compiles dictionaries',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (186,'Odontology','The scientific study of the structure and diseases of teeth',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (187,'Radio Jockey','One who presents a radio programme',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (188,'Rhetoric','The art of effective or persuasive speaking or writing',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (189,'Petrology','The branch of science concerned with the origin, structure and composition of rocks',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (190,'Psephologist','One who studies the elections and trends in voting',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (191,'Sculptor','An artist who makes sculptures.',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (192,'Zoology','The scientific study of the behaviour, structure, physiology, classification and distribution of animals',3,'Profession or Research','guess');
INSERT INTO spellathon_words VALUES (193,'different','',2,'','spell');
INSERT INTO spellathon_words VALUES (194,' language','',2,'','spell');
INSERT INTO spellathon_words VALUES (195,' mammal','',2,'','spell');
INSERT INTO spellathon_words VALUES (196,' dessert','',2,'','spell');
INSERT INTO spellathon_words VALUES (197,' favorite','',2,'','spell');
INSERT INTO spellathon_words VALUES (198,' stomach','',2,'','spell');
INSERT INTO spellathon_words VALUES (199,'  probably','',2,'','spell');
INSERT INTO spellathon_words VALUES (200,' neither','',2,'','spell');
INSERT INTO spellathon_words VALUES (201,' numeral','',2,'','spell');
INSERT INTO spellathon_words VALUES (202,' million','',2,'','spell');
INSERT INTO spellathon_words VALUES (203,' message','',2,'','spell');
INSERT INTO spellathon_words VALUES (204,' except','',2,'','spell');
INSERT INTO spellathon_words VALUES (205,' laughter','',2,'','spell');
INSERT INTO spellathon_words VALUES (206,' inventor','',2,'','spell');
INSERT INTO spellathon_words VALUES (207,' journey','',2,'','spell');
INSERT INTO spellathon_words VALUES (208,' especially','',2,'','spell');
INSERT INTO spellathon_words VALUES (209,' league','',2,'','spell');
INSERT INTO spellathon_words VALUES (210,' ancient','',2,'','spell');
INSERT INTO spellathon_words VALUES (211,' nationality','',2,'','spell');
INSERT INTO spellathon_words VALUES (212,' vault','',2,'','spell');
INSERT INTO spellathon_words VALUES (213,' honorable','',2,'','spell');
INSERT INTO spellathon_words VALUES (214,' acquire','',2,'','spell');
INSERT INTO spellathon_words VALUES (215,' vacuum','',2,'','spell');
INSERT INTO spellathon_words VALUES (216,' persuade','',2,'','spell');
INSERT INTO spellathon_words VALUES (217,' mechanic','',2,'','spell');
INSERT INTO spellathon_words VALUES (218,' requirement','',2,'','spell');
INSERT INTO spellathon_words VALUES (219,' disastrous','',2,'','spell');
INSERT INTO spellathon_words VALUES (220,' scissors','',2,'','spell');
INSERT INTO spellathon_words VALUES (221,' vegetable','',2,'','spell');
INSERT INTO spellathon_words VALUES (222,' accidentally','',2,'','spell');
INSERT INTO spellathon_words VALUES (223,' authority','',2,'','spell');
INSERT INTO spellathon_words VALUES (224,' consequently','',2,'','spell');
INSERT INTO spellathon_words VALUES (225,' quotation','',2,'','spell');
INSERT INTO spellathon_words VALUES (226,' celery','',2,'','spell');
INSERT INTO spellathon_words VALUES (227,' phantom','',2,'','spell');
INSERT INTO spellathon_words VALUES (228,' statistics','',2,'','spell');
INSERT INTO spellathon_words VALUES (229,' endurance','',2,'','spell');
INSERT INTO spellathon_words VALUES (230,' competent','',2,'','spell');
INSERT INTO spellathon_words VALUES (231,' influence','',2,'','spell');
INSERT INTO spellathon_words VALUES (232,' courtesy','',2,'','spell');
INSERT INTO spellathon_words VALUES (233,' havoc','',2,'','spell');
INSERT INTO spellathon_words VALUES (234,' parallel','',2,'','spell');
INSERT INTO spellathon_words VALUES (235,' advantageous','',2,'','spell');
INSERT INTO spellathon_words VALUES (236,' souvenir','',2,'','spell');
INSERT INTO spellathon_words VALUES (237,' questionnaire','',2,'','spell');
INSERT INTO spellathon_words VALUES (238,' deficiency','',2,'','spell');
INSERT INTO spellathon_words VALUES (239,' outrageous','',2,'','spell');
INSERT INTO spellathon_words VALUES (240,' rectangular','',2,'','spell');
INSERT INTO spellathon_words VALUES (241,' honorary','',2,'','spell');
INSERT INTO spellathon_words VALUES (242,' vertigo','',2,'','spell');
INSERT INTO spellathon_words VALUES (243,' malady','',2,'','spell');
INSERT INTO spellathon_words VALUES (244,' parliament','',2,'','spell');
INSERT INTO spellathon_words VALUES (245,' necessity','',2,'','spell');
INSERT INTO spellathon_words VALUES (246,' recurrent','',2,'','spell');
INSERT INTO spellathon_words VALUES (247,' ominous','',2,'','spell');
INSERT INTO spellathon_words VALUES (248,' ubiquitous','',2,'','spell');
INSERT INTO spellathon_words VALUES (249,' potpourri','',2,'','spell');
INSERT INTO spellathon_words VALUES (250,' vivacious','',2,'','spell');
INSERT INTO spellathon_words VALUES (251,' vacillate','',2,'','spell');
INSERT INTO spellathon_words VALUES (252,' permeate','',2,'','spell');
INSERT INTO spellathon_words VALUES (253,'adventure','',2,'','spell');
INSERT INTO spellathon_words VALUES (254,'cinquain','',2,'','spell');
INSERT INTO spellathon_words VALUES (255,'proverb','',2,'','spell');
INSERT INTO spellathon_words VALUES (256,'trait','',2,'','spell');
INSERT INTO spellathon_words VALUES (257,'stress','',2,'','spell');
INSERT INTO spellathon_words VALUES (258,'salutation','',2,'','spell');
INSERT INTO spellathon_words VALUES (259,'prose','',2,'','spell');
INSERT INTO spellathon_words VALUES (260,'lyric','',2,'','spell');
INSERT INTO spellathon_words VALUES (261,'limerick','',2,'','spell');
INSERT INTO spellathon_words VALUES (262,'haiku','',2,'','spell');
INSERT INTO spellathon_words VALUES (263,'characterization','',2,'','spell');
INSERT INTO spellathon_words VALUES (264,'context','',2,'','spell');
INSERT INTO spellathon_words VALUES (265,'drama','',2,'','spell');
INSERT INTO spellathon_words VALUES (266,'entertain','',2,'','spell');
INSERT INTO spellathon_words VALUES (267,'euphemism','',2,'','spell');
INSERT INTO spellathon_words VALUES (268,'imperative','',2,'','spell');
INSERT INTO spellathon_words VALUES (269,'interrogative','',2,'','spell');
INSERT INTO spellathon_words VALUES (270,'pamphlet','',2,'','spell');
INSERT INTO spellathon_words VALUES (271,'repetition','',2,'','spell');
INSERT INTO spellathon_words VALUES (272,'source','',2,'','spell');
INSERT INTO spellathon_words VALUES (273,'symbolism','',2,'','spell');
INSERT INTO spellathon_words VALUES (274,'usage','',2,'','spell');
INSERT INTO spellathon_words VALUES (275,'variable','',2,'','spell');
INSERT INTO spellathon_words VALUES (276,'claim','',2,'','spell');
INSERT INTO spellathon_words VALUES (277,'schedule','',2,'','spell');
INSERT INTO spellathon_words VALUES (278,'root','',2,'','spell');
INSERT INTO spellathon_words VALUES (279,'pitch','',2,'','spell');
INSERT INTO spellathon_words VALUES (280,'mystery','',2,'','spell');
INSERT INTO spellathon_words VALUES (281,'diagram','',2,'','spell');
INSERT INTO spellathon_words VALUES (282,'imperative','',2,'','spell');
INSERT INTO spellathon_words VALUES (283,'earthquake','',2,'','spell');
INSERT INTO spellathon_words VALUES (284,'countdown','',2,'','spell');
INSERT INTO spellathon_words VALUES (285,'candlestick','',2,'','spell');
INSERT INTO spellathon_words VALUES (286,'barefoot','',2,'','spell');
INSERT INTO spellathon_words VALUES (287,'bathrobe','',2,'','spell');
INSERT INTO spellathon_words VALUES (288,'classroom','',2,'','spell');
INSERT INTO spellathon_words VALUES (289,'fingernail','',2,'','spell');
INSERT INTO spellathon_words VALUES (290,'roommate','',2,'','spell');
INSERT INTO spellathon_words VALUES (291,'dashboard','',2,'','spell');
INSERT INTO spellathon_words VALUES (292,'overdue','',2,'','spell');
INSERT INTO spellathon_words VALUES (293,'breakfast','',2,'','spell');
INSERT INTO spellathon_words VALUES (294,'shipwreck','',2,'','spell');
INSERT INTO spellathon_words VALUES (295,'tombstone','',2,'','spell');
INSERT INTO spellathon_words VALUES (296,'wildlife','',2,'','spell');
INSERT INTO spellathon_words VALUES (297,'guardrail','',2,'','spell');
INSERT INTO spellathon_words VALUES (298,'suitcase','',2,'','spell');
INSERT INTO spellathon_words VALUES (299,'surfboard','',2,'','spell');
INSERT INTO spellathon_words VALUES (300,'tiptoe','',2,'','spell');
INSERT INTO spellathon_words VALUES (301,'lighthouse','',2,'','spell');
INSERT INTO spellathon_words VALUES (302,'chairperson','',2,'','spell');
INSERT INTO spellathon_words VALUES (303,'brazen','',2,'','spell');
INSERT INTO spellathon_words VALUES (304,'mighty','',2,'','spell');
INSERT INTO spellathon_words VALUES (305,'conquer','',2,'','spell');
INSERT INTO spellathon_words VALUES (306,'fame','',2,'','spell');
INSERT INTO spellathon_words VALUES (307,'Greek','',2,'','spell');
INSERT INTO spellathon_words VALUES (308,'harbor','',2,'','spell');
INSERT INTO spellathon_words VALUES (309,'beacon','',2,'','spell');
INSERT INTO spellathon_words VALUES (310,'astride','',2,'','spell');
INSERT INTO spellathon_words VALUES (311,'torch','',2,'','spell');
INSERT INTO spellathon_words VALUES (312,'limb','',2,'','spell');
INSERT INTO spellathon_words VALUES (313,'about','',3,'','spell');
INSERT INTO spellathon_words VALUES (314,'army','',3,'','spell');
INSERT INTO spellathon_words VALUES (315,'anyone','',3,'','spell');
INSERT INTO spellathon_words VALUES (316,'bless','',3,'','spell');
INSERT INTO spellathon_words VALUES (317,'everything','',3,'','spell');
INSERT INTO spellathon_words VALUES (318,'change','',3,'','spell');
INSERT INTO spellathon_words VALUES (319,'choose','',3,'','spell');
INSERT INTO spellathon_words VALUES (320,'laugh','',3,'','spell');
INSERT INTO spellathon_words VALUES (321,'penny','',3,'','spell');
INSERT INTO spellathon_words VALUES (322,'string','',3,'','spell');
INSERT INTO spellathon_words VALUES (323,'ask','',3,'','spell');
INSERT INTO spellathon_words VALUES (324,'alone','',3,'','spell');
INSERT INTO spellathon_words VALUES (325,'bear','',3,'','spell');
INSERT INTO spellathon_words VALUES (326,'bring','',3,'','spell');
INSERT INTO spellathon_words VALUES (327,'elbow','',3,'','spell');
INSERT INTO spellathon_words VALUES (328,'grass','',3,'','spell');
INSERT INTO spellathon_words VALUES (329,'crawl','',3,'','spell');
INSERT INTO spellathon_words VALUES (330,'move','',3,'','spell');
INSERT INTO spellathon_words VALUES (331,'prize','',3,'','spell');
INSERT INTO spellathon_words VALUES (332,'touch','',3,'','spell');
INSERT INTO spellathon_words VALUES (333,'always','',3,'','spell');
INSERT INTO spellathon_words VALUES (334,'afternoon','',3,'','spell');
INSERT INTO spellathon_words VALUES (335,'bedsheet','',3,'','spell');
INSERT INTO spellathon_words VALUES (336,'birthday','',3,'','spell');
INSERT INTO spellathon_words VALUES (337,'himself','',3,'','spell');
INSERT INTO spellathon_words VALUES (338,'guess','',3,'','spell');
INSERT INTO spellathon_words VALUES (339,'flow','',3,'','spell');
INSERT INTO spellathon_words VALUES (340,'morning','',3,'','spell');
INSERT INTO spellathon_words VALUES (341,'school','',3,'','spell');
INSERT INTO spellathon_words VALUES (342,'whole','',3,'','spell');
INSERT INTO spellathon_words VALUES (343,'already','',3,'','spell');
INSERT INTO spellathon_words VALUES (344,'also','',3,'','spell');
INSERT INTO spellathon_words VALUES (345,'bent','',3,'','spell');
INSERT INTO spellathon_words VALUES (346,'without ','',3,'','spell');
INSERT INTO spellathon_words VALUES (347,'running','',3,'','spell');
INSERT INTO spellathon_words VALUES (348,'round','',3,'','spell');
INSERT INTO spellathon_words VALUES (349,'thing','',3,'','spell');
INSERT INTO spellathon_words VALUES (350,'better','',3,'','spell');
INSERT INTO spellathon_words VALUES (351,'desk','',3,'','spell');
INSERT INTO spellathon_words VALUES (352,'cherry','',3,'','spell');
INSERT INTO spellathon_words VALUES (353,'awake','',3,'','spell');
INSERT INTO spellathon_words VALUES (354,'almost','',3,'','spell');
INSERT INTO spellathon_words VALUES (355,'anything','',3,'','spell');
INSERT INTO spellathon_words VALUES (356,'began','',3,'','spell');
INSERT INTO spellathon_words VALUES (357,'behind','',3,'','spell');
INSERT INTO spellathon_words VALUES (358,'caught','',3,'','spell');
INSERT INTO spellathon_words VALUES (359,'churn','',3,'','spell');
INSERT INTO spellathon_words VALUES (360,'match','',3,'','spell');
INSERT INTO spellathon_words VALUES (361,'picnic','',3,'','spell');
INSERT INTO spellathon_words VALUES (362,'spring','',3,'','spell');
INSERT INTO spellathon_words VALUES (363,'afraid','',3,'','spell');
INSERT INTO spellathon_words VALUES (364,'along','',3,'','spell');
INSERT INTO spellathon_words VALUES (365,'become','',3,'','spell');
INSERT INTO spellathon_words VALUES (366,'brass','',3,'','spell');
INSERT INTO spellathon_words VALUES (367,'employ','',3,'','spell');
INSERT INTO spellathon_words VALUES (368,'half','',3,'','spell');
INSERT INTO spellathon_words VALUES (369,'frost','',3,'','spell');
INSERT INTO spellathon_words VALUES (370,'mouth','',3,'','spell');
INSERT INTO spellathon_words VALUES (371,'scratch','',3,'','spell');
INSERT INTO spellathon_words VALUES (372,'town','',3,'','spell');
INSERT INTO spellathon_words VALUES (373,'agree','',3,'','spell');
INSERT INTO spellathon_words VALUES (374,'age','',3,'','spell');
INSERT INTO spellathon_words VALUES (375,'bought','',3,'','spell');
INSERT INTO spellathon_words VALUES (376,'body','',3,'','spell');
INSERT INTO spellathon_words VALUES (377,'herself','',3,'','spell');
INSERT INTO spellathon_words VALUES (378,'crazy','',3,'','spell');
INSERT INTO spellathon_words VALUES (379,'front','',3,'','spell');
INSERT INTO spellathon_words VALUES (380,'really','',3,'','spell');
INSERT INTO spellathon_words VALUES (381,'shelf ','',3,'','spell');
INSERT INTO spellathon_words VALUES (382,'window','',3,'','spell');
INSERT INTO spellathon_words VALUES (383,'blind','',3,'','spell');
INSERT INTO spellathon_words VALUES (384,'dinner','',3,'','spell');
INSERT INTO spellathon_words VALUES (385,'cracker','',3,'','spell');
INSERT INTO spellathon_words VALUES (386,'compare','',3,'','spell');
INSERT INTO spellathon_words VALUES (387,'stick','',3,'','spell');
INSERT INTO spellathon_words VALUES (388,'sound','',3,'','spell');
INSERT INTO spellathon_words VALUES (389,'swim','',3,'','spell');
INSERT INTO spellathon_words VALUES (390,'month','',3,'','spell');
INSERT INTO spellathon_words VALUES (391,'mouse','',3,'','spell');
INSERT INTO spellathon_words VALUES (392,'actor','',3,'','spell');
INSERT INTO spellathon_words VALUES (393,'alike','',3,'','spell');
INSERT INTO spellathon_words VALUES (394,'bare','',3,'','spell');
INSERT INTO spellathon_words VALUES (395,'begin','',3,'','spell');
INSERT INTO spellathon_words VALUES (396,'cheese','',3,'','spell');
INSERT INTO spellathon_words VALUES (397,'grin','',3,'','spell');
INSERT INTO spellathon_words VALUES (398,'cure','',3,'','spell');
INSERT INTO spellathon_words VALUES (399,'mark','',3,'','spell');
INSERT INTO spellathon_words VALUES (400,'point','',3,'','spell');
INSERT INTO spellathon_words VALUES (401,'stairs','',3,'','spell');
INSERT INTO spellathon_words VALUES (402,'away','',3,'','spell');
INSERT INTO spellathon_words VALUES (403,'bedtime','',3,'','spell');
INSERT INTO spellathon_words VALUES (404,'brand','',3,'','spell');
INSERT INTO spellathon_words VALUES (405,'enjoy','',3,'','spell');
INSERT INTO spellathon_words VALUES (406,'happen','',3,'','spell');
INSERT INTO spellathon_words VALUES (407,'flower','',3,'','spell');
INSERT INTO spellathon_words VALUES (408,'scream','',3,'','spell');
INSERT INTO spellathon_words VALUES (409,'together','',3,'','spell');
INSERT INTO spellathon_words VALUES (410,'aloud','',3,'','spell');
INSERT INTO spellathon_words VALUES (411,'ago','',3,'','spell');
INSERT INTO spellathon_words VALUES (412,'bench','',3,'','spell');
INSERT INTO spellathon_words VALUES (413,'brush','',3,'','spell');
INSERT INTO spellathon_words VALUES (414,'doctor','',3,'','spell');
INSERT INTO spellathon_words VALUES (415,'climb','',3,'','spell');
INSERT INTO spellathon_words VALUES (416,'forgot','',3,'','spell');
INSERT INTO spellathon_words VALUES (417,'riding','',3,'','spell');
INSERT INTO spellathon_words VALUES (418,'shiny','',3,'','spell');
INSERT INTO spellathon_words VALUES (419,'warm','',3,'','spell');
INSERT INTO spellathon_words VALUES (420,'funny','',3,'','spell');
INSERT INTO spellathon_words VALUES (421,'raise','',3,'','spell');
INSERT INTO spellathon_words VALUES (422,'straight','',3,'','spell');
INSERT INTO spellathon_words VALUES (423,'garden','',3,'','spell');
INSERT INTO spellathon_words VALUES (424,'clock','',3,'','spell');
INSERT INTO spellathon_words VALUES (425,'lunch','',3,'','spell');
INSERT INTO spellathon_words VALUES (426,'sand','',3,'','spell');
INSERT INTO spellathon_words VALUES (427,'holiday','',3,'','spell');
INSERT INTO spellathon_words VALUES (428,'crop','',3,'','spell');
INSERT INTO spellathon_words VALUES (429,'balloon','',3,'','spell');
INSERT INTO spellathon_words VALUES (430,'adventure','',3,'','spell');
INSERT INTO spellathon_words VALUES (431,'neither','',3,'','spell');
INSERT INTO spellathon_words VALUES (432,'dollar','',3,'','spell');
INSERT INTO spellathon_words VALUES (433,'lose','',3,'','spell');
INSERT INTO spellathon_words VALUES (434,'elsewhere','',3,'','spell');
INSERT INTO spellathon_words VALUES (435,'library','',3,'','spell');
INSERT INTO spellathon_words VALUES (436,'wrist','',3,'','spell');
INSERT INTO spellathon_words VALUES (437,'health','',3,'','spell');
INSERT INTO spellathon_words VALUES (438,'disappear','',3,'','spell');
INSERT INTO spellathon_words VALUES (439,'stretch','',3,'','spell');
INSERT INTO spellathon_words VALUES (440,'crust','',3,'','spell');
INSERT INTO spellathon_words VALUES (441,'important','',3,'','spell');
INSERT INTO spellathon_words VALUES (442,'something','',3,'','spell');
INSERT INTO spellathon_words VALUES (443,'airplane','',3,'','spell');
INSERT INTO spellathon_words VALUES (444,'neighbor','',3,'','spell');
INSERT INTO spellathon_words VALUES (445,'hundred','',3,'','spell');
INSERT INTO spellathon_words VALUES (446,'driving','',3,'','spell');
INSERT INTO spellathon_words VALUES (447,'throw','',3,'','spell');
INSERT INTO spellathon_words VALUES (448,'shopping','',3,'','spell');
INSERT INTO spellathon_words VALUES (449,'newspaper','',3,'','spell');
INSERT INTO spellathon_words VALUES (450,'clear','',3,'','spell');
INSERT INTO spellathon_words VALUES (451,'treat','',3,'','spell');
INSERT INTO spellathon_words VALUES (452,'piece','',3,'','spell');
INSERT INTO spellathon_words VALUES (453,'cardboard','',3,'','spell');
INSERT INTO spellathon_words VALUES (454,'breakfast','',3,'','spell');
INSERT INTO spellathon_words VALUES (455,'slept','',3,'','spell');
INSERT INTO spellathon_words VALUES (456,'children','',3,'','spell');
INSERT INTO spellathon_words VALUES (457,'decimal','',3,'','spell');
INSERT INTO spellathon_words VALUES (458,'baseball','',3,'','spell');
INSERT INTO spellathon_words VALUES (459,'kitchen','',3,'','spell');
INSERT INTO spellathon_words VALUES (460,'thousand','',3,'','spell');
INSERT INTO spellathon_words VALUES (461,'circus','',3,'','spell');
INSERT INTO spellathon_words VALUES (462,'trouble','',3,'','spell');
INSERT INTO spellathon_words VALUES (463,'angriest','',3,'','spell');
INSERT INTO spellathon_words VALUES (464,'suit','',3,'','spell');
INSERT INTO spellathon_words VALUES (465,'clothing','',3,'','spell');
INSERT INTO spellathon_words VALUES (466,'young','',3,'','spell');
INSERT INTO spellathon_words VALUES (467,'listen','',3,'','spell');
INSERT INTO spellathon_words VALUES (468,'wrong','',3,'','spell');
INSERT INTO spellathon_words VALUES (469,'ice cream','',3,'','spell');
INSERT INTO spellathon_words VALUES (470,'worst','',3,'','spell');
INSERT INTO spellathon_words VALUES (471,'hallway','',3,'','spell');
