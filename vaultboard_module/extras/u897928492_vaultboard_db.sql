DROP TABLE IF EXISTS `learn_typing_groups`;

CREATE TABLE `learn_typing_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `group_order` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `p_text` text NOT NULL,
  `alphabets` text NOT NULL,
  `combinations` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `learn_typing_groups`
--

INSERT INTO `learn_typing_groups` (`id`, `group_name`, `group_order`, `skill_id`, `p_text`, `alphabets`, `combinations`) VALUES
(1, 'Exercise - 1', 1, 1, 'Test your typing prowers in the middle row!', 'asdf', 'aaaa ssss dddd ffff ffff dddd ssss aaaa'),
(2, 'Exercise - 2', 2, 1, 'Type your way through the middle like a pro!', 'asdf', 'aaaa ssss dddd ffff ffff dddd ssss aaaa'),
(3, 'Exercise - 3', 3, 1, 'Level up your typing accuracy!', 'asdf', 'aa ss dd ff ff dd ss aa aa ss dd ff ff dd ss aa'),
(4, 'Exercise - 4', 1, 2, 'Lets Introduce new keys!', 'jkl;', ';; ll kk jj jj kk ll ;; ;; ll kk jj jj kk ll ;;'),
(5, 'Exercise - 5', 2, 2, 'Master the art of typing with precision call!', 'jkl;', ';; jj ll jj kk ;; jj kk ll jj ;; ll jj ll jj ;;'),
(6, 'Exercise - 6', 1, 3, 'Test your typing prowess in the middle row!', 'asdfjkl;', 'alks fdl; dksl a;fj ssls klsa ;lfd j;af'),
(7, 'Exercise - 7', 2, 3, 'Level up your typing accuracy!', 'asdfjkl;', 'd;af fkfj a;dl sdl; alkd lkfd jkfd sla;'),
(8, 'Exercise - 8', 1, 4, 'Conquer the top row with your typing skills!', 'eriu', 'eerr erer iiuu iuiu rree rere uuii uiui'),
(9, 'Exercise - 9', 2, 4, 'Practice makes a man perfect, lets try again', 'eriu', 'erer iuiu uiui rere eiru urei ieur ruei'),
(10, 'Exercise - 10', 3, 4, 'Lets mix home keys DFLK and ERIU, and try now', 'eriudflk', 'defr edrf dref ferd kiju ikuj kuji ijuk'),
(11, 'Exercise - 11', 4, 4, 'Lets try some tough combinations now', 'eriudflk', 'djfk reiu kjfd urie ifrk fduj eirj kfdi'),
(12, 'Exercise - 12', 5, 4, 'Can you type the top row at lightning speed?', 'Home Keys and eriu', 'fsre sfer lkui ;jiu af;l asui rke; i;ar'),
(14, 'Exercise - 14', 1, 8, 'Master the left-hand keys!', 'fgdt', 'fg fg fg ft ft ft dg df dg dt df'),
(15, 'Exercise - 15', 2, 8, 'Type through the row with finesse and accuracy!', 'fgrt', 'frt frt frt rtg rtg fgf fgt fgt fgt'),
(16, 'Exercise - 16', 3, 8, 'Conquer the depths of the keyboard!', 'defrt', 'dfrt dfrt dfrt dfrt dert dert dert dert'),
(17, 'Exercise-17', 1, 9, 'Master the right-hand keys!', 'hijku', 'jhj jhj jhj jhj jujhj jujhj jujhj jujhj hijk hujk hijk hujk'),
(18, 'Exercise-18', 2, 9, 'Hit the keys with precision and speed!', 'hijku', 'jhjkik jhjkik jhjkik kikjuj kikjuj kikjuj jujkik jujkik'),
(19, 'Exercise-19', 3, 9, 'Conquer the keyboard with your right hand!', 'hijku', 'jhik jhik jhik jihk jihk jihi jihi jihi kih kih kih huhi huhi'),
(20, 'Exercise-20', 1, 10, 'Type through the middle row with cheers!', 'fghjt', 'fg jh fg jh ft jh fgt fgt fgt ght ght ght th th th'),
(21, 'Exercise - 21', 1, 11, 'Unleash the power of typing!', 'fsw', 'fff ddd sss www fff ddd sss www fff ddd sss www'),
(22, 'Exercise - 22', 2, 11, 'Type swiftly and accurately with your left hand!', 'fsw', 'fds fds fdsw fdsw frf ded sws frf ded sws frf ded sws'),
(23, 'Exercise - 23', 3, 11, 'Cast spells of speed and accuracy!', 'fsw', 'fdd fss ree rww rww rew rew rews rews dew dews'),
(24, 'Exercise - 24', 4, 11, 'Master the art of typing with precision!', 'fsw', 'ffds ffds ffdsw fdsw fds fdsw wsdf wsdf sdf fdsdf fdsdf'),
(25, 'Exercise - 25', 5, 11, 'Channel the energy and type like a pro!', 'fsw', 'ffss ffss ffsf ff ssf ff ssf fdsdf fdsdf frf ded sws'),
(26, 'Exercise - 26', 1, 12, 'Hit the keys with precision and speed!', 'loy', 'juj juj jujyj jujyj jyj jhj jhj jhjyj jhjyj jujhj jujhj ujh ujh'),
(27, 'Exercise - 27', 2, 12, 'Harness the strength and dexterity of typing!', 'loy', 'jklol jklol jklol lol lol lol lol jujhj klol jujhj klol kol kol'),
(28, 'Exercise - 28', 3, 12, 'Practice makes a man perfect, lets try again!', 'loy', 'jhyhj jhyhj jhjyj juj jyj jhj jyj jyj jij jij jklkjyj jklkjyj'),
(29, 'Exercise - 29', 1, 13, 'Rise above the challenge & conquer the keyboard!', 'loswy', 'juj jyyj yoj toy roy ryt rfy juj jyyj uujj'),
(30, 'Exercise - 30', 1, 14, 'Type your way through the bottom row!', 'vbnm', 'fvf frfvf fbf frfbf rev vet fvf frfvf fbf frfbf rev vet'),
(31, 'Exercise - 31', 1, 15, 'Type your way through the bottom row!', 'vbnm', 'jmj jujmj jnj jujnj jmj jujmj jnj jujnj'),
(32, 'Exercise - 32', 1, 16, 'Practice with Vowels along V, B, N and M', 'vbnm', 'ou ough rough tough trough enough ou ough rough tough trough enough'),
(33, 'Exercise - 33', 1, 17, 'Level up your typing accuracy!', 'ap', 'faf far fat fatter far farmer faf far fat fatter far farmer frame fame famine fade'),
(34, 'Exercise - 34', 2, 17, 'Practice makes a man perfect, lets try again!', 'ap', 'pot port pit put pop pup puppy pot port pit put pop pup puppy poppy pappy'),
(35, 'Exercise - 35', 3, 17, 'Conquer the depths of the keyboard!', 'ap', 'purr top rope romp trap tramp trumpet purr top rope romp trap tramp trumpet'),
(36, 'Exercise - 36', 1, 18, 'Embrace the challenge and type learning!', 'q', 'quit quite quiet quill queen quilt quest quit quite quiet quill queen quilt quest'),
(37, 'Exercise - 37', 2, 18, 'Hit the keys with precision and speed!', 'q', 'quote quoted equate equation equal quack quaint quote quoted equate equation'),
(38, 'Exercise - 38', 1, 19, 'Practice makes a man perfect, lets try again!', 'zx', 'zoo zulu zigzag fax tax text exit mix fix zoo zulu zigzag fax tax text exit mix fix'),
(39, 'Exercise - 39', 2, 19, 'Reach new heights with your accuracy!', 'zx', 'six zoom boxes gizmo mixed maze raze lax flax size mixes zit sox zany lazy yax'),
(40, 'Exercise - 40', 1, 20, 'Type symbols & punctuation with accuracy!', '!@#$%', '!! @@ ## $$ %% %% $$ ## @@ !!'),
(41, 'Exercise - 41', 2, 20, 'Practice makes a man perfect, lets try again!', '!@#$%', '!@ @# #$ $% %$ $# #@ @! @$ !#'),
(42, 'Exercise - 42', 1, 21, 'Add flair to your typing with precision & style!', '^&*()', '^^ && ** (( )) )) (( ** && ^^'),
(43, 'Exercise - 43', 2, 21, 'Level up your typing accuracy!', '^&*()', '^& &* *( () )* *& &^ *^ &('),
(44, 'Exercise - 44', 1, 22, 'Unlock the secrets of special characters!', 'Sentence', 't!e qu#c$ brown fox j^m&s o*er t() lazy dog! #TGIF'),
(45, 'Exercise - 45', 2, 22, 'Play the keyboard like a maestro!', 'Sentence', 'i l@v# e$t%n$ pi^^a & w&t*h&ng m%v&es !! W()kends.'),
(46, 'Exercise - 46', 1, 23, 'Know the characters & type with confidence!', 'ASDF', 'AAAA SSSS DDDD FFFF FFFF DDDD SSSS AAAA'),
(47, 'Exercise - 47', 2, 23, 'Practice makes a man perfect, lets try again!', 'ASDF', 'AA SS DD FF FF DD SS AA AA SS DD FF FF DD SS AA'),
(48, 'Exercise - 48', 3, 23, 'Crack the code and type with ease!', 'ASDF', 'ASDF ADSF AFDS ASFD FDSA FASD DFSA SDAF'),
(49, 'Record Level', 1, 24, 'We are here...Type your way to the victory!', 'ADFJKLS & Space', 'flask fads lads flak skald daks ask dak dak aks'),
(50, 'Record Level', 1, 25, 'Reach new heights with your typing accuracy!', 'Home Keys and ERIU', 'flake judas kulfi flask frisk kufis juke freak'),
(51, 'Record Level', 1, 26, 'Unlock your true typing potential!', 'Home Keys & TGH', 'true tire tired retire fit retired tried he her here the thee these there their'),
(52, 'Record Level', 1, 27, 'Time to Emerge as a typing champion of keyboard!', 'Home Keys & WSLOY', 'lilly  while silly whist whistle when trill thrill try'),
(53, 'Record Level', 1, 28, 'Challenge yourself with ultimate typing test!', 'Home Keys & VBNM', 'often men mine den rim every mind over fibre'),
(54, 'Record Level', 1, 29, 'Master the art of typing with precision!', 'Home Keys & APQZX', 'hope the Learn Typing course has made your typing experience so much better'),
(55, 'Record Level', 1, 30, 'Practice with finesse and accuracy!', 'Home Keys & Special Chars', 'lets meet at the park at 2:30 p.m. Dont forget to bring your umbrella!'),
(56, 'Record Level', 1, 31, 'Challenge your skills and type like a pro!', 'ASDF & Space', 'FLASK FADS LADS FLAK SKALD DAKS ASK DAK DAK AKS');

-- --------------------------------------------------------

--
-- Table structure for table `learn_typing_levels`
--
DROP TABLE IF EXISTS `learn_typing_levels`;

CREATE TABLE `learn_typing_levels` (
  `id` int(11) NOT NULL,
  `level_name` varchar(255) NOT NULL,
  `level_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `learn_typing_levels`
--

INSERT INTO `learn_typing_levels` (`id`, `level_name`, `level_order`) VALUES
(1, 'Level-1', 1),
(2, 'Level-2', 2),
(3, 'Level-3', 3),
(4, 'Level-4', 4),
(5, 'Level-5', 5),
(6, 'Level-6', 6),
(7, 'Level-7', 7),
(8, 'Level-8', 8);

-- --------------------------------------------------------

--
-- Table structure for table `learn_typing_progress`
--

DROP TABLE IF EXISTS `learn_typing_progress`;

CREATE TABLE `learn_typing_progress` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `learn_typing_progress`
--

INSERT INTO `learn_typing_progress` (`id`, `student_id`, `group_id`, `completed`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 2, 1, 1),
(4, 1, 3, 1),
(5, 1, 4, 1),
(6, 4, 1, 1),
(7, 1, 5, 1),
(8, 1, 6, 1),
(9, 1, 7, 1),
(10, 5, 1, 1),
(11, 5, 2, 1),
(12, 4, 2, 1),
(13, 4, 3, 1),
(14, 4, 4, 1),
(15, 7, 1, 0),
(16, 5, 3, 0),
(18, 3, 1, 1),
(19, 2, 2, 0),
(22, 11, 1, 0),
(23, 4, 5, 1),
(24, 16, 1, 1),
(25, 3, 2, 0),
(26, 16, 2, 1),
(27, 1, 49, 1),
(28, 1, 8, 1),
(29, 24, 1, 1),
(30, 24, 2, 1),
(31, 24, 3, 0),
(32, 26, 1, 0),
(33, 31, 1, 1),
(34, 31, 2, 1),
(35, 31, 3, 1),
(36, 31, 4, 1),
(37, 31, 5, 1),
(38, 31, 6, 1),
(39, 31, 7, 1),
(40, 31, 49, 1),
(41, 31, 8, 1),
(42, 31, 9, 1),
(43, 31, 10, 1),
(44, 31, 11, 1),
(45, 31, 12, 1),
(46, 31, 50, 1),
(47, 31, 14, 1),
(48, 31, 15, 1),
(49, 31, 16, 1),
(50, 31, 17, 1),
(51, 31, 18, 1),
(52, 31, 19, 1),
(53, 31, 20, 1),
(54, 31, 51, 1),
(55, 31, 21, 1),
(56, 31, 22, 1),
(57, 31, 23, 1),
(58, 31, 24, 1),
(59, 31, 25, 1),
(60, 31, 26, 1),
(61, 31, 27, 1),
(62, 31, 28, 1),
(63, 31, 29, 1),
(64, 31, 52, 1),
(65, 31, 30, 1),
(66, 31, 31, 1),
(67, 31, 32, 1),
(68, 31, 53, 1),
(69, 31, 33, 1),
(70, 31, 34, 1),
(71, 31, 35, 1),
(72, 31, 36, 1),
(73, 31, 37, 1),
(74, 31, 38, 1),
(75, 31, 39, 1),
(76, 31, 54, 1),
(77, 31, 40, 1),
(78, 31, 41, 1),
(79, 31, 42, 1),
(80, 31, 43, 1),
(81, 31, 44, 1),
(82, 31, 45, 1),
(83, 31, 55, 1),
(84, 31, 46, 1),
(85, 31, 56, 1),
(86, 31, 47, 1),
(87, 31, 48, 1),
(89, 32, 1, 1),
(90, 32, 2, 1),
(91, 32, 3, 1),
(92, 32, 4, 1),
(93, 32, 5, 1),
(94, 32, 6, 1),
(95, 32, 7, 1),
(96, 32, 49, 1),
(97, 32, 8, 1),
(98, 32, 9, 1),
(99, 32, 10, 1),
(100, 32, 11, 1),
(101, 32, 12, 1),
(102, 32, 50, 1),
(103, 32, 14, 1),
(104, 32, 15, 1),
(105, 32, 16, 1),
(106, 32, 17, 1),
(107, 32, 18, 1),
(108, 32, 19, 1),
(109, 32, 20, 1),
(110, 32, 51, 1),
(111, 32, 21, 1),
(112, 32, 22, 1),
(113, 32, 23, 1),
(114, 32, 24, 1),
(115, 32, 25, 1),
(116, 32, 26, 1),
(117, 32, 27, 1),
(118, 32, 28, 1),
(119, 32, 29, 1),
(120, 32, 52, 1),
(121, 32, 30, 1),
(122, 32, 31, 1),
(123, 32, 32, 1),
(124, 32, 53, 1),
(125, 32, 33, 1),
(126, 32, 34, 1),
(127, 32, 35, 1),
(128, 32, 36, 1),
(129, 32, 37, 1),
(130, 32, 38, 1),
(131, 32, 39, 1),
(132, 32, 54, 1),
(133, 32, 40, 1),
(134, 32, 41, 1),
(135, 32, 42, 1),
(136, 32, 43, 1),
(137, 32, 44, 1),
(138, 32, 45, 1),
(139, 32, 55, 1),
(140, 32, 46, 1),
(141, 32, 56, 1),
(142, 32, 47, 1),
(143, 32, 48, 1),
(156, 4, 6, 1),
(157, 4, 7, 1),
(158, 4, 49, 1),
(159, 4, 8, 1),
(160, 4, 9, 1),
(161, 4, 10, 1),
(162, 4, 11, 0);

-- --------------------------------------------------------

--
-- Table structure for table `learn_typing_skills`
--

DROP TABLE IF EXISTS `learn_typing_skills`;

CREATE TABLE `learn_typing_skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL,
  `skill_order` int(11) NOT NULL,
  `level_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `learn_typing_skills`
--

INSERT INTO `learn_typing_skills` (`id`, `skill_name`, `skill_order`, `level_id`) VALUES
(1, 'Home Keys Left Hand', 1, 1),
(2, 'Home Keys Right Hand', 2, 1),
(3, 'Home Keys Mixed Both Hands', 3, 1),
(4, 'Top Row Keys Both Hands', 1, 2),
(5, 'Bottom Row Keys Both Hands', 2, 2),
(6, 'Top and Bottom Row Keys Both Hands', 3, 2),
(7, 'All Keys Both Hands', 4, 2),
(8, 'T,G & H along with Home Keys left hand', 1, 3),
(9, 'T,G & H along with Home Keys right hand', 2, 3),
(10, 'Both Hands', 3, 3),
(11, 'Introducing W,S,L,O & Y along with Home Keys left hand', 1, 4),
(12, 'Introducing W,S,L,O & Y along with Home Keys right hand', 2, 4),
(13, 'Both Hands', 3, 4),
(14, 'Introducing V,B,N & M along with Home Keys left hand', 1, 5),
(15, 'Introducing V,B,N & M along with Home Keys right hand', 2, 5),
(16, 'Vowels with Letters', 3, 5),
(17, 'Introducing A P  Q  Z & X', 1, 6),
(18, 'Home Keys & Q', 2, 6),
(19, 'Home Keys & Z,X', 3, 6),
(20, 'Introducing Special Characters left side', 1, 7),
(21, 'Introducing Special Characters right side', 2, 7),
(22, 'Combination of Both', 3, 7),
(23, 'Introducing Capital Letters', 1, 8),
(24, 'Level - 1 Record', 4, 1),
(25, 'Level - 2 Record', 5, 2),
(26, 'Level - 3 Record', 4, 3),
(27, 'Level - 4 Record', 4, 4),
(28, 'Level - 5 Record', 4, 5),
(29, 'Level - 6 Record', 4, 6),
(30, 'Level - 7 Record', 4, 7),
(31, 'Level-8 Record', 1, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `learn_typing_groups`
--
ALTER TABLE `learn_typing_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- Indexes for table `learn_typing_levels`
--
ALTER TABLE `learn_typing_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_typing_progress`
--
ALTER TABLE `learn_typing_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `learn_typing_skills`
--
ALTER TABLE `learn_typing_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `level_id` (`level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `learn_typing_groups`
--
ALTER TABLE `learn_typing_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `learn_typing_levels`
--
ALTER TABLE `learn_typing_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `learn_typing_progress`
--
ALTER TABLE `learn_typing_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `learn_typing_skills`
--
ALTER TABLE `learn_typing_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `learn_typing_groups`
--
ALTER TABLE `learn_typing_groups`
  ADD CONSTRAINT `learn_typing_groups_ibfk_1` FOREIGN KEY (`skill_id`) REFERENCES `learn_typing_skills` (`id`);

--
-- Constraints for table `learn_typing_progress`
--
ALTER TABLE `learn_typing_progress`
  ADD CONSTRAINT `learn_typing_progress_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `learn_typing_progress_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `learn_typing_groups` (`id`);

--
-- Constraints for table `learn_typing_skills`
--
ALTER TABLE `learn_typing_skills`
  ADD CONSTRAINT `learn_typing_skills_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `learn_typing_levels` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
