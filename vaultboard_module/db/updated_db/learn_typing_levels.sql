
DROP TABLE IF EXISTS learn_typing_levels;

CREATE TABLE `learn_typing_levels` (
  `id` int(11) NOT NULL,
  `level_name` varchar(255) NOT NULL,
  `level_order` int(11) NOT NULL
);

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `learn_typing_levels`
--
ALTER TABLE `learn_typing_levels`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `learn_typing_levels`
--
ALTER TABLE `learn_typing_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

