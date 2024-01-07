DROP TABLE IF EXISTS `topics_subtopics`;

CREATE TABLE `topics_subtopics` (
  `id` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `class_id` bigint(20) DEFAULT NULL,
  `subject_id` bigint(20) DEFAULT NULL,
  `topic` varchar(250) DEFAULT NULL,
  `subtopic` varchar(250) DEFAULT NULL,
  `slug` varchar(250) DEFAULT NULL,
  `parent` bigint(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `topics_subtopics` (`id`, `userid`, `class_id`, `subject_id`, `topic`, `subtopic`, `slug`, `parent`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 8, 'Counting and Numbers upto 10', NULL, 'counting-and-numbers-upto-10', 0, 1, '2023-04-26 22:48:06', '2023-04-26 22:48:06'),
(2, 1, 1, 8, 'Measurement', NULL, 'measurement', 0, 1, '2023-04-26 22:48:56', '2023-04-26 22:48:56'),
(3, 1, 1, 8, 'Money', NULL, 'money', 0, 1, '2023-04-26 22:49:07', '2023-04-26 23:27:54'),
(4, 1, 1, 8, 'Patterns', NULL, 'patterns', 0, 0, '2023-04-26 22:49:32', '2023-04-26 22:49:32'),
(5, 1, 1, 8, NULL, 'Count forward and backward upto 10', 'count-forward-and-backward-upto-10', 1, 1, '2023-04-26 22:49:52', '2023-04-26 23:27:48'),
(6, 1, 1, 8, NULL, 'Before, after and between upto 10', 'before-after-and-between-upto-10', 1, 1, '2023-04-26 22:50:16', '2023-04-26 22:50:16'),
(7, 1, 1, 8, NULL, 'Compare 3 numbers upto 10 ascending descending', 'compare-3-numbers-upto-10-ascending-descending', 1, 1, '2023-04-28 15:43:08', '2023-04-28 21:32:42'),
(8, 1, 2, 8, 'Counting and Numbers upto 20', NULL, 'counting-and-numbers-upto-20', 0, 1, '2023-04-28 20:44:18', '2023-04-28 20:44:18'),
(9, 1, 2, 8, 'Measurement', NULL, 'measurement', 0, 1, '2023-04-28 20:45:17', '2023-04-28 20:49:41'),
(10, 1, 2, 8, NULL, 'Count forward and backward upto 20', 'count-forward-and-backward-upto-20', 8, 1, '2023-04-28 20:50:28', '2023-04-28 20:50:28'),
(11, 1, 2, 8, NULL, 'Before, after and between upto 20', 'before-after-and-between-upto-20', 8, 1, '2023-04-28 20:57:58', '2023-04-28 20:57:58'),
(12, 1, 2, 8, NULL, 'Compare 3 numbers upto 20 ascending descending', 'compare-3-numbers-upto-20-ascending-descending', 8, 1, '2023-04-28 21:30:49', '2023-04-28 21:32:49'),
(13, 1, 1, 8, NULL, 'Fewer more or same number vs objects', 'fewer-more-or-same-number-vs-objects', 1, 1, '2023-04-28 21:46:12', '2023-04-28 21:46:12'),
(14, 1, 1, 8, NULL, 'Long and Short', 'long-and-short', 2, 1, '2023-04-29 16:53:46', '2023-04-29 16:53:46'),
(15, 1, 1, 8, NULL, 'Tall and Short', 'tall-and-short', 2, 1, '2023-04-29 16:54:01', '2023-04-29 16:54:01'),
(16, 1, 1, 8, NULL, 'Wide and Narrow', 'wide-and-narrow', 2, 1, '2023-04-29 16:54:13', '2023-04-29 16:54:13'),
(17, 1, 1, 8, NULL, 'Light and Heavy', 'light-and-heavy', 2, 1, '2023-04-29 16:54:22', '2023-04-29 16:54:22'),
(18, 1, 2, 8, NULL, 'Long and Short', 'long-and-short', 9, 1, '2023-04-30 16:19:53', '2023-04-30 16:19:53'),
(19, 1, 2, 8, NULL, 'Tall and Short', 'tall-and-short', 9, 1, '2023-04-30 16:20:18', '2023-04-30 16:20:18'),
(20, 1, 2, 8, NULL, 'Wide and Narrow', 'wide-and-narrow', 9, 1, '2023-04-30 16:20:33', '2023-04-30 16:20:33'),
(21, 1, 2, 8, NULL, 'Light and Heavy', 'light-and-heavy', 9, 1, '2023-04-30 16:20:45', '2023-04-30 16:20:45'),
(22, 1, 2, 8, NULL, 'Name of numbers upto 20', 'name-of-numbers-upto-20', 8, 1, '2023-04-30 19:59:15', '2023-04-30 19:59:15'),
(23, 1, 1, 8, '2D Shapes', NULL, '2d-shapes', 0, 1, '2023-04-30 21:27:40', '2023-04-30 21:27:40'),
(24, 1, 1, 8, NULL, 'Name the shape', 'name-the-shape', 23, 1, '2023-04-30 21:30:26', '2023-04-30 21:30:26'),
(25, 1, 1, 8, NULL, 'Count the shape', 'count-the-shape', 23, 1, '2023-05-02 19:44:03', '2023-05-02 19:44:03'),
(26, 1, 1, 8, NULL, 'Count the same color shape', 'count-the-same-color-shape', 23, 1, '2023-05-02 19:44:18', '2023-05-02 19:44:18'),
(27, 1, 2, 8, NULL, 'Name the shape', 'name-the-shape', 28, 1, '2023-05-03 12:35:48', '2023-05-03 12:54:57'),
(28, 1, 2, 8, '2D Shapes', NULL, '2d-shapes', 0, 1, '2023-05-03 12:53:26', '2023-05-03 12:53:26'),
(29, 1, 2, 8, NULL, 'Count the shape', 'count-the-shape', 28, 1, '2023-05-03 12:55:23', '2023-05-03 12:55:23'),
(30, 1, 2, 8, NULL, 'Count the same color shape', 'count-the-same-color-shape', 28, 1, '2023-05-03 12:55:38', '2023-05-03 12:55:38'),
(31, 1, 1, 8, NULL, 'Value of Coins/Notes', 'value-of-coins-notes', 3, 1, '2023-05-03 19:57:40', '2023-05-03 19:57:40'),
(32, 1, 2, 8, 'Money', NULL, 'money', 0, 1, '2023-05-03 20:46:39', '2023-05-03 20:46:39'),
(33, 1, 2, 8, NULL, 'Value of Coins/Notes', 'value-of-coins-notes', 32, 1, '2023-05-03 20:49:11', '2023-05-03 20:49:11'),
(34, 1, 1, 8, NULL, 'Sum of money', 'sum-of-money', 3, 1, '2023-05-07 07:50:27', '2023-05-07 07:50:27'),
(35, 1, 2, 8, NULL, 'Sum of money', 'sum-of-money', 32, 1, '2023-05-07 07:50:36', '2023-05-07 07:50:36'),
(36, 1, 1, 8, NULL, 'More/Less money given group', 'more-less-money-given-group', 3, 1, '2023-05-07 10:17:01', '2023-05-07 10:17:01'),
(37, 1, 2, 8, NULL, 'More/Less money given group', 'more-less-money-given-group', 32, 1, '2023-05-07 10:17:07', '2023-05-07 10:17:07'),
(38, 1, 2, 8, NULL, 'Fewer more or same number vs objects', 'fewer-more-or-same-number-vs-objects', 8, 1, '2023-05-07 21:29:55', '2023-05-07 21:29:55'),
(39, 1, 3, 8, 'Number Sense', NULL, 'number-sense', 0, 1, '2023-07-11 13:25:55', '2023-07-11 13:25:55'),
(40, 1, 3, 8, NULL, 'What comes before, after, and in between the numbers', 'what-comes-before-after-and-in-between-the-numbers', 39, 1, '2023-07-11 13:26:15', '2023-07-11 13:26:15'),
(41, 1, 3, 8, NULL, 'Skip counting by 2,3,5 and 10', 'skip-counting-by-2-3-5-and-10', 39, 1, '2023-07-11 14:43:45', '2023-07-13 10:52:23'),
(42, 1, 2, 8, NULL, 'Skip counting by 2', 'skip-counting-by-2', 8, 1, '2023-07-12 12:20:23', '2023-07-12 12:20:23'),
(43, 1, 3, 8, NULL, 'Standard and Expanded form number upto 2 digits', 'standard-and-expanded-form-number-upto-2-digits', 39, 1, '2023-07-12 18:50:08', '2023-10-31 19:38:21'),
(44, 1, 4, 8, 'Number Sense', NULL, 'number-sense', 0, 1, '2023-07-13 00:52:00', '2023-07-13 00:52:00'),
(45, 1, 4, 8, NULL, 'Standard and Expanded form number upto 3 digits', 'standard-and-expanded-form-number-upto-3-digits', 44, 1, '2023-07-13 00:52:49', '2023-10-31 19:38:33'),
(46, 1, 5, 8, 'Number Sense', NULL, 'number-sense', 0, 1, '2023-07-13 00:56:03', '2023-07-13 00:56:03'),
(47, 1, 6, 8, 'Number Sense', NULL, 'number-sense', 0, 1, '2023-07-13 00:56:09', '2023-07-13 00:56:09'),
(48, 1, 7, 8, 'Number Sense', NULL, 'number-sense', 0, 1, '2023-07-13 00:56:14', '2023-07-13 00:56:14'),
(49, 1, 5, 8, NULL, 'Standard and Expanded form number upto 4 digits', 'standard-and-expanded-form-number-upto-4-digits', 46, 1, '2023-07-13 00:56:38', '2023-10-31 19:38:45'),
(50, 1, 6, 8, NULL, 'Standard and Expanded form number upto 6 digits', 'standard-and-expanded-form-number-upto-6-digits', 47, 1, '2023-07-13 00:56:50', '2023-07-13 00:56:50'),
(51, 1, 7, 8, NULL, 'Standard and Expanded form number upto 7 digits', 'standard-and-expanded-form-number-upto-7-digits', 48, 1, '2023-07-13 00:57:02', '2023-07-13 00:57:02'),
(52, 1, 3, 8, NULL, 'Comparing Numbers (Ascending and Descending)', 'comparing-numbers-ascending-and-descending', 39, 1, '2023-07-19 22:24:41', '2023-07-19 22:24:41'),
(53, 1, 4, 8, NULL, 'Comparing Numbers (Ascending and Descending)', 'comparing-numbers-ascending-and-descending', 44, 1, '2023-07-19 22:24:49', '2023-07-19 22:24:49'),
(54, 1, 5, 8, NULL, 'Comparing Numbers (Ascending and Descending)', 'comparing-numbers-ascending-and-descending', 46, 1, '2023-07-19 22:24:54', '2023-07-19 22:24:54'),
(55, 1, 6, 8, NULL, 'Comparing Numbers (Ascending and Descending)', 'comparing-numbers-ascending-and-descending', 47, 1, '2023-07-19 22:25:00', '2023-07-19 22:25:00'),
(56, 1, 7, 8, NULL, 'Comparing Numbers (Ascending and Descending)', 'comparing-numbers-ascending-and-descending', 48, 1, '2023-07-19 22:25:05', '2023-07-19 22:25:05'),
(57, 1, 3, 8, NULL, 'Abacus and Place Value', 'abacus-and-place-value', 39, 0, '2023-07-19 23:49:58', '2023-07-19 23:49:58'),
(58, 1, 4, 8, NULL, 'Abacus and Place Value', 'abacus-and-place-value', 44, 0, '2023-07-19 23:50:09', '2023-07-19 23:50:09'),
(59, 1, 5, 8, NULL, 'Abacus and Place Value', 'abacus-and-place-value', 46, 0, '2023-07-19 23:50:16', '2023-07-19 23:50:16'),
(60, 1, 6, 8, NULL, 'Abacus and Place Value', 'abacus-and-place-value', 47, 0, '2023-07-19 23:50:20', '2023-07-19 23:50:20'),
(61, 1, 7, 8, NULL, 'Abacus and Place Value', 'abacus-and-place-value', 48, 0, '2023-07-19 23:50:25', '2023-07-19 23:50:25'),
(62, 1, 4, 8, NULL, 'Abacus Recognize Numbers', 'abacus-recognize-numbers', 44, 1, '2023-07-28 12:15:05', '2023-07-28 16:57:56'),
(63, 1, 5, 8, NULL, 'Abacus Recognize Numbers', 'abacus-recognize-numbers', 46, 1, '2023-07-28 16:43:48', '2023-07-28 16:43:48'),
(64, 1, 6, 8, NULL, 'Abacus Recognize Numbers', 'abacus-recognize-numbers', 47, 1, '2023-07-28 16:44:11', '2023-07-28 16:44:11'),
(65, 1, 7, 8, NULL, 'Abacus Recognize Numbers', 'abacus-recognize-numbers', 48, 1, '2023-07-28 16:44:21', '2023-07-28 16:44:21'),
(66, 1, 4, 8, NULL, 'Abacus Recognize Numbers Level 2', 'abacus-recognize-numbers-level-2', 44, 1, '2023-07-28 19:28:49', '2023-07-28 19:28:49'),
(67, 1, 5, 8, NULL, 'Abacus Recognize Numbers Level 2', 'abacus-recognize-numbers-level-2', 46, 1, '2023-07-28 19:29:20', '2023-07-28 19:29:20'),
(68, 1, 6, 8, NULL, 'Abacus Recognize Numbers Level 2', 'abacus-recognize-numbers-level-2', 47, 1, '2023-07-28 19:29:37', '2023-07-28 19:29:37'),
(69, 1, 7, 8, NULL, 'Abacus Recognize Numbers Level 2', 'abacus-recognize-numbers-level-2', 48, 1, '2023-07-28 19:30:39', '2023-07-28 19:30:39'),
(70, 1, 4, 8, NULL, 'Formation of Numbers', 'formation-of-numbers', 44, 1, '2023-07-28 20:28:00', '2023-07-28 20:28:00'),
(71, 1, 5, 8, NULL, 'Formation of Numbers', 'formation-of-numbers', 46, 1, '2023-07-28 20:28:16', '2023-07-28 20:28:16'),
(72, 1, 6, 8, NULL, 'Formation of Numbers', 'formation-of-numbers', 47, 1, '2023-07-28 20:28:27', '2023-07-28 20:28:27'),
(73, 1, 7, 8, NULL, 'Formation of Numbers', 'formation-of-numbers', 48, 1, '2023-07-28 20:28:41', '2023-07-28 20:28:41'),
(74, 1, 4, 8, 'Time', NULL, 'time', 0, 1, '2023-07-28 23:36:47', '2023-07-28 23:36:47'),
(75, 1, 4, 8, NULL, 'Read The Time Using Clock', 'read-the-time-using-clock', 74, 1, '2023-07-28 23:37:28', '2023-07-28 23:37:28'),
(76, 1, 4, 8, NULL, 'Time Slower And Faster', 'time-slower-and-faster', 74, 1, '2023-07-29 13:26:35', '2023-07-29 13:26:35'),
(77, 1, 4, 8, NULL, 'Time Addition Substraction', 'time-addition-substraction', 74, 1, '2023-07-29 13:49:34', '2023-07-29 13:49:34'),
(78, 1, 5, 8, 'Fractions', NULL, 'fractions', 0, 1, '2023-07-29 15:29:04', '2023-07-29 15:29:04'),
(79, 1, 6, 8, 'Fractions', NULL, 'fractions', 0, 1, '2023-07-29 15:29:35', '2023-07-29 15:29:35'),
(80, 1, 6, 8, 'Geometry', NULL, 'geometry', 0, 1, '2023-07-29 15:30:02', '2023-07-29 15:30:02'),
(81, 1, 7, 8, 'Fractions And Decimals', NULL, 'fractions-and-decimals', 0, 1, '2023-07-29 15:30:47', '2023-08-04 13:27:10'),
(82, 1, 7, 8, 'Area and Perimeter', NULL, 'area-and-perimeter', 0, 1, '2023-07-29 15:31:15', '2023-07-29 15:31:15'),
(83, 1, 5, 8, NULL, 'Fraction of shaded/unshaded parts', 'fraction-of-shaded-unshaded-parts', 78, 1, '2023-07-29 15:31:59', '2023-07-29 15:31:59'),
(84, 1, 6, 8, NULL, 'Fraction of shaded/unshaded parts (1 colour / 2 colour)', 'fraction-of-shaded-unshaded-parts-1-colour-2-colour', 79, 1, '2023-07-29 15:32:33', '2023-07-29 15:32:33'),
(85, 1, 6, 8, NULL, 'Perimeter of Squares and Rectangles', 'perimeter-of-squares-and-rectangles', 80, 1, '2023-07-29 15:32:55', '2023-07-29 15:32:55'),
(86, 1, 7, 8, NULL, 'Fractional or Decimal form of shaded/unshaded parts (1 colour / 2 colour)', 'fractional-or-decimal-form-of-shaded-unshaded-parts-1-colour-2-colour', 81, 1, '2023-07-29 15:33:25', '2023-07-29 15:33:25'),
(87, 1, 7, 8, NULL, 'Finding Area by counting', 'finding-area-by-counting', 82, 1, '2023-07-29 15:34:05', '2023-07-29 15:34:05'),
(88, 1, 7, 8, NULL, 'Finding Perimeter by counting', 'finding-perimeter-by-counting', 82, 1, '2023-07-29 15:34:35', '2023-07-29 15:34:35'),
(89, 1, 7, 8, NULL, 'Area of Square and Rectangles', 'area-of-square-and-rectangles', 82, 1, '2023-07-29 15:34:49', '2023-07-29 15:34:49'),
(90, 1, 7, 8, NULL, 'Percentage Changed Area Perimeter', 'percentage-changed-area-perimeter', 82, 1, '2023-07-29 23:02:32', '2023-07-29 23:02:47'),
(91, 1, 5, 8, 'Data Handling Graphs', NULL, 'data-handling-graphs', 0, 1, '2023-07-31 18:39:34', '2023-07-31 18:39:54'),
(92, 1, 6, 8, 'Data Handling Graphs', NULL, 'data-handling-graphs', 0, 1, '2023-07-31 18:40:02', '2023-07-31 18:40:02'),
(93, 1, 7, 8, 'Data Handling Graphs', NULL, 'data-handling-graphs', 0, 1, '2023-07-31 18:40:11', '2023-07-31 18:40:11'),
(94, 1, 5, 8, 'Logical Reasoning', NULL, 'logical-reasoning', 0, 1, '2023-07-31 18:40:36', '2023-07-31 18:40:36'),
(95, 1, 6, 9, 'Logical Reasoning', NULL, 'logical-reasoning', 0, 0, '2023-07-31 18:40:46', '2023-07-31 18:40:46'),
(96, 1, 7, 8, 'Logical Reasoning', NULL, 'logical-reasoning', 0, 1, '2023-07-31 18:40:55', '2023-07-31 18:40:55'),
(97, 1, 6, 8, 'Logical Reasoning', NULL, 'logical-reasoning', 0, 1, '2023-07-31 18:41:26', '2023-07-31 18:41:26'),
(98, 1, 5, 8, NULL, 'Charts (Easy Questions) (horizontal and vertical bar graphs)', 'charts-easy-questions-horizontal-and-vertical-bar-graphs', 91, 1, '2023-07-31 18:46:32', '2023-07-31 18:46:32'),
(99, 1, 6, 8, NULL, 'Charts (all chart types)', 'charts-all-chart-types', 92, 1, '2023-07-31 18:47:01', '2023-07-31 18:47:01'),
(100, 1, 7, 8, NULL, 'Charts (all chart types)', 'charts-all-chart-types', 93, 1, '2023-07-31 18:47:18', '2023-07-31 18:47:18'),
(101, 1, 5, 8, NULL, 'Direction Sense Easy angles', 'direction-sense-easy-angles', 94, 1, '2023-07-31 18:47:35', '2023-07-31 18:47:35'),
(102, 1, 6, 8, NULL, 'Direction Sense Normal', 'direction-sense-normal', 97, 1, '2023-07-31 18:47:50', '2023-07-31 18:47:50'),
(103, 1, 7, 8, NULL, 'Direction Sense Normal', 'direction-sense-normal', 96, 1, '2023-07-31 18:48:00', '2023-07-31 18:48:00'),
(104, 1, 3, 8, 'Addition', NULL, 'addition', 0, 1, '2023-08-01 06:11:25', '2023-08-01 06:11:25'),
(105, 1, 3, 8, 'Subtraction', NULL, 'subtraction', 0, 1, '2023-08-01 06:11:48', '2023-08-06 09:46:02'),
(106, 1, 3, 8, NULL, 'Find Missing Digits', 'find-missing-digits', 104, 1, '2023-08-01 06:14:01', '2023-08-01 06:14:01'),
(107, 1, 3, 8, NULL, 'Find Missing Digits For Subtraction', 'find-missing-digits-for-subtraction', 105, 1, '2023-08-01 06:14:34', '2023-08-25 16:22:13'),
(108, 1, 4, 8, 'Computation Operations', NULL, 'computation-operations', 0, 1, '2023-08-01 06:15:11', '2023-08-01 06:15:11'),
(109, 1, 5, 8, 'Computation Operations', NULL, 'computation-operations', 0, 1, '2023-08-01 06:15:41', '2023-08-01 06:15:41'),
(110, 1, 6, 8, 'Computation Operations', NULL, 'computation-operations', 0, 1, '2023-08-01 06:16:23', '2023-08-01 06:16:23'),
(111, 1, 7, 8, 'Computation Operations', NULL, 'computation-operations', 0, 1, '2023-08-01 06:16:43', '2023-08-01 06:16:43'),
(112, 1, 4, 8, NULL, 'Find Missing Digits', 'find-missing-digits', 108, 1, '2023-08-01 06:18:35', '2023-08-01 06:18:35'),
(113, 1, 5, 8, NULL, 'Find Missing Digits (Addition / Subtraction)', 'find-missing-digits-addition-subtraction', 109, 1, '2023-08-01 06:21:40', '2023-08-01 06:21:40'),
(114, 1, 5, 8, NULL, 'Find Missing Digits (Multiplication / Division)', 'find-missing-digits-multiplication-division', 109, 1, '2023-08-01 06:22:08', '2023-08-01 06:22:08'),
(115, 1, 6, 8, NULL, 'Find Missing Digits (Addition / Subtraction)', 'find-missing-digits-addition-subtraction', 110, 1, '2023-08-01 06:22:57', '2023-08-01 06:22:57'),
(116, 1, 6, 8, NULL, 'Find Missing Digits (Multiplication / Division)', 'find-missing-digits-multiplication-division', 110, 1, '2023-08-01 06:23:20', '2023-08-01 06:23:20'),
(117, 1, 7, 8, NULL, 'Find Missing Digits', 'find-missing-digits', 111, 1, '2023-08-01 06:23:39', '2023-08-01 06:23:39'),
(118, 1, 4, 8, 'Time and Money', NULL, 'time-and-money', 0, 1, '2023-08-01 09:31:30', '2023-08-01 09:31:30'),
(119, 1, 5, 8, 'Measurements', NULL, 'measurements', 0, 1, '2023-08-01 09:31:58', '2023-08-01 09:31:58'),
(120, 1, 6, 8, 'Measurements', NULL, 'measurements', 0, 1, '2023-08-01 09:32:37', '2023-08-01 09:32:37'),
(121, 1, 7, 8, 'Measurements', NULL, 'measurements', 0, 1, '2023-08-01 09:32:49', '2023-08-01 09:32:49'),
(122, 1, 4, 8, NULL, 'Word Problems - Time Calculations', 'word-problems---time-calculations', 118, 1, '2023-08-01 09:33:27', '2023-08-01 09:33:27'),
(123, 1, 5, 8, NULL, 'Word Problems - Time Calculations', 'word-problems---time-calculations', 119, 1, '2023-08-01 09:33:43', '2023-08-01 09:33:43'),
(124, 1, 6, 8, NULL, 'Word Problems - Time Calculations', 'word-problems---time-calculations', 120, 1, '2023-08-01 09:34:00', '2023-08-01 09:34:00'),
(125, 1, 7, 8, NULL, 'Word Problems - Time Calculations', 'word-problems---time-calculations', 121, 1, '2023-08-01 09:34:07', '2023-08-01 09:34:07'),
(126, 1, 4, 8, 'Measurements', NULL, 'measurements', 0, 1, '2023-08-02 17:48:19', '2023-08-02 17:48:19'),
(127, 1, 4, 8, NULL, 'Conversion of units', 'conversion-of-units', 126, 1, '2023-08-02 17:48:41', '2023-08-02 17:48:41'),
(128, 1, 5, 8, NULL, 'Conversion of Units', 'conversion-of-units', 119, 1, '2023-08-02 17:48:55', '2023-08-02 17:48:55'),
(129, 1, 6, 8, NULL, 'Conversion of Units', 'conversion-of-units', 120, 1, '2023-08-02 17:49:07', '2023-08-02 17:49:07'),
(130, 1, 7, 8, NULL, 'Conversion of Units', 'conversion-of-units', 121, 1, '2023-08-02 17:49:19', '2023-08-02 17:49:19'),
(131, 1, 4, 8, NULL, 'Formation of Numbers (Advanced)', 'formation-of-numbers-advanced', 44, 1, '2023-08-02 17:50:13', '2023-08-02 17:50:13'),
(132, 1, 5, 8, NULL, 'Formation of Numbers (Advanced)', 'formation-of-numbers-advanced', 46, 1, '2023-08-02 17:50:27', '2023-08-02 17:50:27'),
(133, 1, 6, 8, NULL, 'Formation of Numbers (Advanced)', 'formation-of-numbers-advanced', 47, 1, '2023-08-02 17:50:35', '2023-08-02 17:50:35'),
(134, 1, 7, 8, NULL, 'Formation of Numbers (Advanced)', 'formation-of-numbers-advanced', 48, 1, '2023-08-02 17:50:45', '2023-08-02 17:50:45'),
(135, 1, 5, 8, NULL, 'Arranging Fractions', 'arranging-fractions', 78, 1, '2023-08-03 09:35:39', '2023-08-03 09:35:39'),
(136, 1, 6, 8, NULL, 'Arranging Fractions', 'arranging-fractions', 79, 1, '2023-08-03 09:35:47', '2023-08-03 09:35:47'),
(137, 1, 7, 8, NULL, 'Arranging Fractions', 'arranging-fractions', 81, 1, '2023-08-03 09:35:55', '2023-08-03 09:35:55'),
(138, 1, 5, 8, NULL, 'Addition / Subtraction', 'addition-subtraction', 78, 1, '2023-08-03 17:14:02', '2023-08-03 17:14:02'),
(139, 1, 6, 8, NULL, 'Addition / Subtraction', 'addition-subtraction', 79, 1, '2023-08-03 17:14:09', '2023-08-03 17:14:09'),
(140, 1, 7, 8, NULL, 'Addition / Subtraction', 'addition-subtraction', 81, 1, '2023-08-03 17:14:23', '2023-08-03 17:14:23'),
(141, 1, 6, 8, NULL, 'Simplifying Fractions', 'simplifying-fractions', 79, 1, '2023-08-03 22:37:33', '2023-08-03 22:37:33'),
(142, 1, 7, 8, NULL, 'Simplifying Fractions', 'simplifying-fractions', 81, 1, '2023-08-03 22:37:48', '2023-08-03 22:37:48'),
(143, 1, 6, 8, NULL, 'Multiplication and Division', 'multiplication-and-division', 79, 0, '2023-08-04 07:43:11', '2023-08-04 07:43:11'),
(144, 1, 6, 8, NULL, 'Multiplication / Division', 'multiplication-division', 79, 1, '2023-08-04 07:43:12', '2023-08-04 07:44:16'),
(145, 1, 7, 8, NULL, 'Multiplication / Division', 'multiplication-division', 81, 1, '2023-08-04 07:43:27', '2023-08-04 07:44:30'),
(146, 1, 6, 8, NULL, 'Equivalent Fractions', 'equivalent-fractions', 79, 1, '2023-08-04 08:19:49', '2023-08-04 08:19:49'),
(147, 1, 7, 8, NULL, 'Equivalent Fractions', 'equivalent-fractions', 81, 1, '2023-08-04 08:20:28', '2023-08-04 08:20:28'),
(148, 1, 7, 8, NULL, 'Rounding off Numbers', 'rounding-off-numbers', 81, 1, '2023-08-04 13:27:40', '2023-08-04 13:27:40'),
(149, 1, 6, 8, NULL, 'Convert improper fraction into mixed fraction and vice-versa', 'convert-improper-fraction-into-mixed-fraction-and-vice-versa', 79, 1, '2023-08-05 00:00:18', '2023-08-05 00:00:18'),
(150, 1, 7, 8, NULL, 'Convert improper fraction into mixed fraction and vice-versa', 'convert-improper-fraction-into-mixed-fraction-and-vice-versa', 81, 1, '2023-08-05 00:00:32', '2023-08-05 00:00:32'),
(151, 1, 6, 8, NULL, 'Highest Common Factor (HCF) and Least Common Multiple (LCM)', 'highest-common-factor-hcf-and-least-common-multiple-lcm', 110, 1, '2023-08-05 01:14:44', '2023-08-05 01:14:44'),
(152, 1, 7, 8, NULL, 'Highest Common Factor (HCF) and Least Common Multiple (LCM)', 'highest-common-factor-hcf-and-least-common-multiple-lcm', 111, 1, '2023-08-05 01:15:04', '2023-08-05 01:15:04'),
(153, 1, 7, 8, NULL, 'Sum, difference, multiplication and division  of Roman Numbers', 'sum-difference-multiplication-and-division-of-roman-numbers', 111, 1, '2023-08-05 02:34:45', '2023-08-05 02:34:45'),
(154, 1, 3, 8, NULL, 'Adding one digit and two digit numbers', 'adding-one-digit-and-two-digit-numbers', 104, 1, '2023-08-06 09:45:32', '2023-08-06 09:45:32'),
(155, 1, 3, 8, NULL, 'Subtract one digit and two digit numbers', 'subtract-one-digit-and-two-digit-numbers', 105, 1, '2023-08-06 09:45:52', '2023-08-06 09:45:52'),
(156, 1, 4, 8, NULL, 'Addition/subtraction of 2 and 3-digit numbers with/without regrouping (carry)', 'addition-subtraction-of-2-and-3-digit-numbers-with-without-regrouping-carry', 108, 1, '2023-08-06 10:03:22', '2023-08-06 10:03:22'),
(157, 1, 5, 8, NULL, 'Addition and Subtraction of 4 diigit numbers', 'addition-and-subtraction-of-4-diigit-numbers', 109, 1, '2023-08-06 10:03:41', '2023-08-06 10:03:41'),
(158, 1, 6, 8, NULL, 'Addition and Subtraction upto 5 digit numbers', 'addition-and-subtraction-upto-5-digit-numbers', 110, 1, '2023-08-06 10:04:09', '2023-08-06 10:04:09'),
(159, 1, 7, 8, NULL, 'Addition and Subtraction upto 7 digit numbers', 'addition-and-subtraction-upto-7-digit-numbers', 111, 1, '2023-08-06 10:04:40', '2023-08-06 10:04:40'),
(160, 1, 5, 8, NULL, 'Addition and Subtraction of 4 digit numbers', 'addition-and-subtraction-of-4-digit-numbers', 109, 0, '2023-08-06 10:09:26', '2023-08-06 10:09:26'),
(161, 1, 6, 8, NULL, 'Multiplication of 3 digit numbers with 1,2,3-digit numbers', 'multiplication-of-3-digit-numbers-with-1-2-3-digit-numbers', 110, 1, '2023-08-06 10:13:42', '2023-08-06 10:13:42'),
(162, 1, 6, 8, NULL, 'Division of upto 5-digit numbers with 1,2-digit numbers', 'division-of-upto-5-digit-numbers-with-1-2-digit-numbers', 110, 1, '2023-08-06 10:14:04', '2023-08-06 10:14:04'),
(163, 1, 7, 8, NULL, 'Multiplication of 5 digit numbers with 1,2,3-digit numbers', 'multiplication-of-5-digit-numbers-with-1-2-3-digit-numbers', 111, 1, '2023-08-06 10:14:30', '2023-08-06 10:14:30'),
(164, 1, 7, 8, NULL, 'Division of upto 5-digit numbers with 1,2-digit numbers', 'division-of-upto-5-digit-numbers-with-1-2-digit-numbers', 111, 1, '2023-08-06 10:14:42', '2023-08-06 10:14:42'),
(165, 1, 6, 8, NULL, 'Estimated sum and difference by rounding off', 'estimated-sum-and-difference-by-rounding-off', 110, 1, '2023-08-06 11:52:23', '2023-08-06 11:52:23'),
(166, 1, 6, 8, NULL, 'Estimated sum and difference by rounding off', 'estimated-sum-and-difference-by-rounding-off', 110, 0, '2023-08-06 11:52:23', '2023-08-06 11:52:23'),
(167, 1, 6, 8, NULL, 'Estimated multiplication by rounding off', 'estimated-multiplication-by-rounding-off', 110, 1, '2023-08-06 11:56:22', '2023-08-06 11:56:53'),
(168, 1, 7, 8, NULL, 'Estimated sum, difference, multiplication and division by rounding off', 'estimated-sum-difference-multiplication-and-division-by-rounding-off', 111, 1, '2023-08-06 11:57:17', '2023-08-06 11:57:17'),
(169, 1, 6, 8, NULL, 'Estimated division by rounding off', 'estimated-division-by-rounding-off', 110, 1, '2023-08-06 12:05:12', '2023-08-06 12:05:12'),
(170, 1, 6, 8, NULL, 'Factors and multiples', 'factors-and-multiples', 110, 1, '2023-08-06 15:34:28', '2023-08-06 15:34:28'),
(171, 1, 7, 8, NULL, 'Factors and multiples', 'factors-and-multiples', 111, 1, '2023-08-06 15:34:37', '2023-08-06 15:34:37'),
(172, 1, 4, 8, NULL, 'Identification of correct addition and subtraction sentences based on given pictures', 'identification-of-correct-addition-and-subtraction-sentences-based-on-given-pictures', 44, 1, '2023-08-08 00:09:59', '2023-08-08 00:09:59'),
(173, 1, 4, 8, NULL, 'Calendar Reading', 'calendar-reading', 74, 1, '2023-08-09 01:20:48', '2023-08-09 01:20:48'),
(174, 1, 3, 8, 'Time', NULL, 'time', 0, 1, '2023-08-09 01:21:22', '2023-08-09 01:21:22'),
(175, 1, 3, 8, NULL, 'Calendar Reading', 'calendar-reading', 174, 1, '2023-08-09 01:21:35', '2023-08-09 01:21:35'),
(176, 1, 5, 8, NULL, 'Calendar Reading', 'calendar-reading', 119, 1, '2023-08-09 01:23:30', '2023-08-09 01:23:30'),
(177, 1, 6, 8, NULL, 'Calendar Reading', 'calendar-reading', 120, 1, '2023-08-09 01:23:48', '2023-08-09 01:23:48'),
(178, 1, 7, 8, NULL, 'Calendar Reading', 'calendar-reading', 121, 1, '2023-08-09 01:24:03', '2023-08-09 01:24:03'),
(179, 1, 4, 8, NULL, 'Measuring the length using ruler', 'measuring-the-length-using-ruler', 126, 1, '2023-08-09 22:57:39', '2023-08-09 22:57:39'),
(180, 1, 5, 8, NULL, 'Reading temperature on thermometer in degree C or degree F', 'reading-temperature-on-thermometer-in-degree-c-or-degree-f', 119, 1, '2023-08-10 08:37:49', '2023-08-10 08:37:49'),
(181, 1, 4, 8, NULL, 'Compare the lengths and weights', 'compare-the-lengths-and-weights', 126, 1, '2023-08-10 23:09:23', '2023-08-10 23:09:23'),
(182, 1, 5, 8, NULL, 'Compare the lengths and weights', 'compare-the-lengths-and-weights', 119, 1, '2023-08-10 23:09:36', '2023-08-10 23:09:36'),
(183, 1, 6, 8, NULL, 'Compare the lengths and weights', 'compare-the-lengths-and-weights', 120, 1, '2023-08-10 23:09:45', '2023-08-10 23:09:45'),
(184, 1, 7, 8, NULL, 'Compare the lengths and weights', 'compare-the-lengths-and-weights', 121, 1, '2023-08-10 23:09:54', '2023-08-10 23:09:54'),
(185, 1, 3, 8, 'Money', NULL, 'money', 0, 1, '2023-08-10 23:45:28', '2023-08-10 23:45:28'),
(186, 1, 3, 8, NULL, 'Use of money in simple shopping activities', 'use-of-money-in-simple-shopping-activities', 185, 1, '2023-08-10 23:47:13', '2023-08-10 23:47:13'),
(187, 1, 4, 8, NULL, 'Calculating money in simple shopping', 'calculating-money-in-simple-shopping', 118, 1, '2023-08-10 23:48:03', '2023-08-10 23:48:03'),
(188, 1, 5, 8, 'Money', NULL, 'money', 0, 1, '2023-08-10 23:48:47', '2023-08-10 23:48:47'),
(189, 1, 5, 8, NULL, 'Money needed/left after shopping activities', 'money-needed-left-after-shopping-activities', 188, 1, '2023-08-10 23:48:54', '2023-08-10 23:48:54'),
(190, 1, 6, 8, NULL, 'Calculating money in shopping activities', 'calculating-money-in-shopping-activities', 120, 1, '2023-08-10 23:49:26', '2023-08-10 23:49:26'),
(191, 1, 7, 8, NULL, 'Calculating money in shopping activities', 'calculating-money-in-shopping-activities', 121, 1, '2023-08-10 23:49:42', '2023-08-10 23:49:42'),
(192, 1, 3, 8, NULL, 'Value of Coins/Notes', 'value-of-coins-notes', 185, 1, '2023-08-11 23:19:06', '2023-08-11 23:19:06'),
(193, 1, 4, 8, NULL, 'Value of Coins/Notes', 'value-of-coins-notes', 118, 1, '2023-08-11 23:19:15', '2023-08-11 23:19:15'),
(194, 1, 5, 8, NULL, 'Value of Coins/Notes', 'value-of-coins-notes', 188, 1, '2023-08-11 23:19:23', '2023-08-11 23:19:23'),
(195, 1, 6, 8, NULL, 'Value of Coins/Notes', 'value-of-coins-notes', 120, 1, '2023-08-11 23:19:34', '2023-08-11 23:19:34'),
(196, 1, 7, 8, NULL, 'Value of Coins/Notes', 'value-of-coins-notes', 121, 1, '2023-08-11 23:19:42', '2023-08-11 23:19:42'),
(197, 1, 3, 8, NULL, 'Sum of money', 'sum-of-money', 185, 1, '2023-08-12 23:50:30', '2023-08-12 23:50:30'),
(198, 1, 4, 8, NULL, 'Sum of money', 'sum-of-money', 118, 1, '2023-08-12 23:50:43', '2023-08-12 23:50:43'),
(199, 1, 5, 8, NULL, 'Sum of money', 'sum-of-money', 188, 1, '2023-08-12 23:50:52', '2023-08-12 23:50:52'),
(200, 1, 6, 8, NULL, 'Sum of money', 'sum-of-money', 120, 1, '2023-08-12 23:51:12', '2023-08-12 23:51:12'),
(201, 1, 7, 8, NULL, 'Sum of money', 'sum-of-money', 121, 1, '2023-08-12 23:51:20', '2023-08-12 23:51:20'),
(202, 1, 3, 8, NULL, 'More/Less money given group', 'more-less-money-given-group', 185, 1, '2023-08-12 23:57:43', '2023-08-12 23:57:43'),
(203, 1, 4, 8, NULL, 'More/Less money given group', 'more-less-money-given-group', 118, 1, '2023-08-12 23:57:59', '2023-08-12 23:57:59'),
(204, 1, 5, 8, NULL, 'More/Less money given group', 'more-less-money-given-group', 188, 1, '2023-08-12 23:58:14', '2023-08-12 23:58:14'),
(205, 1, 6, 8, NULL, 'More/Less money given group', 'more-less-money-given-group', 120, 1, '2023-08-12 23:58:21', '2023-08-12 23:58:21'),
(206, 1, 7, 8, NULL, 'More/Less money given group', 'more-less-money-given-group', 121, 1, '2023-08-12 23:58:28', '2023-08-12 23:58:28'),
(207, 1, 3, 8, 'Logical Reasoning', NULL, 'logical-reasoning', 0, 1, '2023-08-15 08:40:31', '2023-08-15 08:40:31'),
(208, 1, 4, 8, 'Logical Reasoning', NULL, 'logical-reasoning', 0, 1, '2023-08-15 08:40:38', '2023-08-15 08:40:38'),
(209, 1, 3, 8, NULL, 'Number pattern', 'number-pattern', 207, 1, '2023-08-15 08:41:04', '2023-08-15 08:41:04'),
(210, 1, 4, 8, NULL, 'Number/Figure Pattern', 'number-figure-pattern', 208, 1, '2023-08-15 08:41:25', '2023-08-15 08:41:59'),
(211, 1, 5, 8, NULL, 'Number/Figure Pattern', 'number-figure-pattern', 94, 1, '2023-08-15 08:41:44', '2023-08-15 08:41:44'),
(212, 1, 6, 8, NULL, 'Number/Figure Pattern', 'number-figure-pattern', 97, 1, '2023-08-15 08:42:28', '2023-08-15 08:42:28'),
(213, 1, 7, 8, NULL, 'Number/Figure Pattern', 'number-figure-pattern', 96, 1, '2023-08-15 08:42:47', '2023-08-15 08:42:47'),
(214, 1, 5, 8, NULL, 'Mirror Images', 'mirror-images', 94, 1, '2023-08-15 19:43:40', '2023-08-15 19:43:40'),
(215, 1, 6, 8, NULL, 'Mirror Images', 'mirror-images', 97, 1, '2023-08-15 19:43:49', '2023-08-15 19:43:49'),
(216, 1, 7, 8, NULL, 'Mirror Images', 'mirror-images', 96, 1, '2023-08-15 19:43:57', '2023-08-15 19:43:57'),
(217, 1, 4, 8, NULL, 'Coding And Decoding', 'coding-and-decoding', 208, 1, '2023-08-17 19:25:47', '2023-08-17 19:25:47'),
(218, 1, 4, 8, NULL, 'Coding And Decoding', 'coding-and-decoding', 208, 0, '2023-08-17 19:25:55', '2023-08-17 19:25:55'),
(219, 1, 5, 8, NULL, 'Coding And Decoding', 'coding-and-decoding', 94, 1, '2023-08-17 19:26:05', '2023-08-17 19:26:05'),
(220, 1, 6, 8, NULL, 'Coding And Decoding', 'coding-and-decoding', 97, 1, '2023-08-17 19:26:13', '2023-08-17 19:26:13'),
(221, 1, 7, 8, NULL, 'Coding And Decoding', 'coding-and-decoding', 96, 1, '2023-08-17 19:26:22', '2023-08-17 19:26:22'),
(222, 1, 5, 8, NULL, 'Comparison Calculations', 'comparison-calculations', 46, 1, '2023-10-04 23:48:39', '2023-10-04 23:48:39'),
(223, 1, 6, 8, NULL, 'Comparison Calculations', 'comparison-calculations', 47, 1, '2023-10-04 23:48:52', '2023-10-04 23:48:52'),
(224, 1, 7, 8, NULL, 'Comparison Calculations', 'comparison-calculations', 48, 1, '2023-10-04 23:49:04', '2023-10-04 23:49:04'),
(225, 1, 1, 8, 'Test Topic', NULL, 'test-topic', 0, 0, '2023-10-05 19:46:48', '2023-10-05 19:46:48'),
(226, 1, 2, 8, 'Test Topic', NULL, 'test-topic', 0, 0, '2023-10-05 19:46:58', '2023-10-05 19:46:58'),
(227, 1, 3, 8, 'Test Topic', NULL, 'test-topic', 0, 0, '2023-10-05 19:47:08', '2023-10-05 19:47:08'),
(228, 1, 4, 8, 'Test Topic', NULL, 'test-topic', 0, 0, '2023-10-05 19:47:17', '2023-10-05 19:47:17'),
(229, 1, 5, 8, 'Test Topic', NULL, 'test-topic', 0, 0, '2023-10-05 19:47:26', '2023-10-05 19:47:26'),
(230, 1, 6, 8, 'Test Topic', NULL, 'test-topic', 0, 0, '2023-10-05 19:47:33', '2023-10-05 19:47:33'),
(231, 1, 7, 8, 'Test Topic', NULL, 'test-topic', 0, 0, '2023-10-05 19:47:39', '2023-10-05 19:47:39'),
(232, 1, 7, 8, NULL, 'Test Graphs', 'test-graphs', 231, 0, '2023-10-05 19:48:13', '2023-10-05 19:48:13'),
(233, 1, 6, 8, NULL, 'Test Graphs', 'test-graphs', 230, 0, '2023-10-05 19:48:38', '2023-10-05 19:48:38'),
(234, 1, 7, 8, NULL, 'Test Factors and Multiples', 'test-factors-and-multiples', 231, 0, '2023-10-05 19:49:11', '2023-10-05 19:49:11'),
(235, 1, 6, 8, NULL, 'Test Factors and Multiples', 'test-factors-and-multiples', 230, 0, '2023-10-05 19:49:24', '2023-10-05 19:49:24'),
(236, 1, 7, 8, 'Angles', NULL, 'angles', 0, 1, '2023-10-06 23:28:33', '2023-10-06 23:28:33'),
(237, 1, 7, 8, NULL, 'Determining Angles', 'determining-angles', 236, 1, '2023-10-06 23:29:08', '2023-10-06 23:29:08'),
(238, 1, 7, 8, NULL, 'Determining Position', 'determining-position', 96, 1, '2023-10-07 16:34:21', '2023-10-07 16:34:21'),
(239, 1, 6, 8, 'Symmetry', NULL, 'symmetry', 0, 0, '2023-10-10 18:20:29', '2023-10-10 18:20:29'),
(240, 1, 7, 8, 'Symmetry', NULL, 'symmetry', 0, 0, '2023-10-10 18:20:46', '2023-10-10 18:20:46'),
(241, 1, 7, 8, NULL, 'Symmetry In Letters', 'symmetry-in-letters', 240, 0, '2023-10-10 18:21:14', '2023-10-10 18:21:14'),
(242, 1, 6, 8, NULL, 'Symmetry in Letters', 'symmetry-in-letters', 239, 0, '2023-10-10 18:21:35', '2023-10-10 18:21:35'),
(243, 1, 7, 8, NULL, 'Numerals and Number Names', 'numerals-and-number-names', 48, 1, '2023-10-26 19:32:51', '2023-10-26 19:32:51'),
(244, 1, 5, 8, NULL, 'Roman Numbers', 'roman-numbers', 46, 1, '2023-10-26 21:56:24', '2023-10-26 21:56:24'),
(245, 1, 6, 8, NULL, 'Roman Numbers', 'roman-numbers', 47, 1, '2023-10-26 21:56:36', '2023-10-26 21:56:36'),
(246, 1, 7, 8, NULL, 'Roman Numbers', 'roman-numbers', 48, 1, '2023-10-26 21:56:47', '2023-10-26 21:56:47'),
(247, 1, 7, 8, NULL, 'Place Value in Indian and International Number System', 'place-value-in-indian-and-international-number-system', 48, 1, '2023-10-26 23:01:11', '2023-10-26 23:01:11'),
(248, 1, 5, 8, NULL, 'Numerals and Number Names', 'numerals-and-number-names', 46, 1, '2023-10-27 16:18:48', '2023-10-27 16:18:48'),
(249, 1, 6, 8, NULL, 'Numerals and Number Names', 'numerals-and-number-names', 47, 1, '2023-10-27 16:18:59', '2023-10-27 16:18:59'),
(250, 1, 5, 8, NULL, 'Place Value in Indian and International Number System', 'place-value-in-indian-and-international-number-system', 46, 1, '2023-10-27 16:22:06', '2023-10-27 16:22:06'),
(251, 1, 6, 8, NULL, 'Place Value in Indian and International Number System', 'place-value-in-indian-and-international-number-system', 47, 1, '2023-10-27 16:22:15', '2023-10-27 16:22:15'),
(252, 1, 3, 8, NULL, 'Abacus Recognize Numbers', 'abacus-recognize-numbers', 39, 1, '2023-10-31 19:40:14', '2023-10-31 19:40:14'),
(253, 1, 3, 8, NULL, 'Number System', 'number-system', 39, 1, '2023-10-31 19:47:33', '2023-10-31 19:47:33'),
(254, 1, 4, 8, NULL, 'Number System', 'number-system', 44, 1, '2023-10-31 19:47:43', '2023-10-31 19:47:43');

ALTER TABLE `topics_subtopics`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `topics_subtopics`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;
COMMIT;