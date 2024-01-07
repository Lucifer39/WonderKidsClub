

--
-- Database: `vocab_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `learn_typing_skills`
--

DROP TABLE IF EXISTS learn_typing_skills;

CREATE TABLE `learn_typing_skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL,
  `skill_order` int(11) NOT NULL,
  `level_id` int(11) NOT NULL
);

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
-- Indexes for table `learn_typing_skills`
--
ALTER TABLE `learn_typing_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `level_id` (`level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `learn_typing_skills`
--
ALTER TABLE `learn_typing_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `learn_typing_skills`
--
ALTER TABLE `learn_typing_skills`
  ADD CONSTRAINT `learn_typing_skills_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `learn_typing_levels` (`id`);
COMMIT;

