
DROP TABLE IF EXISTS learn_typing_groups;

CREATE TABLE `learn_typing_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `group_order` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `p_text` text NOT NULL,
  `alphabets` text NOT NULL,
  `combinations` text NOT NULL
);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `learn_typing_groups`
--
ALTER TABLE `learn_typing_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `learn_typing_groups`
--
ALTER TABLE `learn_typing_groups`
  ADD CONSTRAINT `learn_typing_groups_ibfk_1` FOREIGN KEY (`skill_id`) REFERENCES `learn_typing_skills` (`id`);
COMMIT;
