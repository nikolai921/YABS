-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 12, 2019 at 05:30 PM
-- Server version: 5.7.25-0ubuntu0.18.04.2
-- PHP Version: 7.2.15-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `YABS`
--

-- --------------------------------------------------------

--
-- Table structure for table `bonus_rules`
--

CREATE TABLE `bonus_rules` (
  `id` int(11) NOT NULL,
  `turnover_level` decimal(10,2) NOT NULL,
  `bonus_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bonus_rules`
--

INSERT INTO `bonus_rules` (`id`, `turnover_level`, `bonus_amount`) VALUES
(1, '5000.00', '3.00'),
(2, '10000.00', '5.00'),
(3, '20000.00', '10.00'),
(4, '50000.00', '15.00'),
(5, '100000.00', '20.00');

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `telephone` varchar(11) NOT NULL,
  `human_sex` varchar(7) NOT NULL,
  `birthday` date DEFAULT NULL,
  `operators_id` int(11) NOT NULL,
  `number` varchar(20) NOT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `turnover` decimal(10,2) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `issue` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `owner`, `telephone`, humanSex, `birthday`, `operators_id`, `number`, `balance`, `discount`, `turnover`, `status`, `issue`) VALUES
(1, 'Шубин Родион Олегович', '78051293346', 'male', '1979-05-09', 4, '9331994724086618', NULL, '0.00', NULL, 1, NULL),
(2, 'Малышевa Милана Артуровна', '74915791817', 'female', '1966-05-15', 3, '2779267069452360', NULL, '0.00', NULL, 1, NULL),
(3, 'Елисеев Глеб Сергеевич', '77985513789', 'male', '1965-06-03', 4, '1566310828168043', NULL, '0.00', NULL, 0, NULL),
(4, 'Панов Дамир Дмитриевич', '78331405642', 'male', '1972-07-11', 4, '4968830878254691', NULL, '0.00', NULL, 0, NULL),
(5, 'Киселев Эдуард Даниилович', '74957196139', 'male', '1982-10-20', 1, '5815398558405300', NULL, '0.00', NULL, 0, NULL),
(6, 'Нефедов Арсений Ярославович', '78335501152', 'male', '1953-11-17', 4, '2527779924327176', NULL, '0.00', NULL, 1, NULL),
(7, 'Щукинa Лидия Дамировна', '78053103125', 'female', '1953-03-13', 5, '5807474293123606', NULL, '0.00', NULL, 1, NULL),
(8, 'Громов Денис Данилеевич', '74937499697', 'male', '1992-05-13', 7, '2862147958593153', NULL, '0.00', NULL, 1, NULL),
(9, 'Борисов Даниэль Викторович', '74951787794', 'male', '1953-10-17', 5, '8409383172244688', NULL, '0.00', NULL, 1, NULL),
(10, 'Шубин Родион Олегович', '78051293346', 'male', '1979-05-09', 1, '6170236151407264', '22934.39', '20.00', '832752.78', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `date_holidays`
--

CREATE TABLE `date_holidays` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `discount_rate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `date_holidays`
--

INSERT INTO `date_holidays` (`id`, `date`, `name`, `discount_rate`) VALUES
(1, NULL, 'День рождения', 2),
(2, '2019-03-08', '8 марта', 2),
(3, '2019-02-23', '23 февраля', 3),
(4, '2019-02-10', 'День рождения магазина', 2);

-- --------------------------------------------------------

--
-- Table structure for table `operators`
--

CREATE TABLE `operators` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `unique_key` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `operators`
--

INSERT INTO `operators` (`id`, `name`, `unique_key`) VALUES
(1, 'магазин Москва', 11115555),
(2, 'магазин Краснодар', 11115556),
(3, 'магазин Волгоград', 11115557),
(4, 'магазин Саратов', 11115558),
(5, 'магазин Барнаул', 11115559),
(6, 'магазин Воронеж', 11115551),
(7, 'магазин Санкт-Петербург', 11115552);

-- --------------------------------------------------------

--
-- Table structure for table `percentage_changes`
--

CREATE TABLE `percentage_changes` (
  `id` int(11) NOT NULL,
  `operators_id` int(11) NOT NULL,
  `cards_id` int(11) NOT NULL,
  `percentage_changes` decimal(10,2) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `percentage_changes`
--

INSERT INTO `percentage_changes` (`id`, `operators_id`, `cards_id`, `percentage_changes`, `date`) VALUES
(1, 1, 10, '4.00', '2017-09-26 02:09:03'),
(2, 1, 10, '4.00', '2017-09-26 02:09:03'),
(3, 1, 10, '4.00', '2017-09-26 02:09:03'),
(4, 1, 10, '2.00', '2017-09-26 02:09:03'),
(5, 1, 10, '3.00', '2017-09-26 02:09:03'),
(6, 1, 10, '1.00', '2017-09-26 02:09:03'),
(7, 1, 10, '2.00', '2017-09-26 02:09:03'),
(8, 1, 10, '1.00', '2017-09-26 02:09:03'),
(9, 1, 10, '2.00', '2017-09-26 02:09:03'),
(10, 1, 10, '3.00', '2017-09-26 02:09:03'),
(11, 1, 10, '5.00', '2017-09-26 02:09:03'),
(12, 1, 10, '3.00', '2017-09-26 02:09:03'),
(13, 1, 10, '5.00', '2017-09-26 02:09:03'),
(14, 1, 10, '3.00', '2017-09-26 02:09:03'),
(15, 1, 10, '15.00', '2017-09-26 02:09:03'),
(16, 1, 10, '20.00', '2017-09-26 02:09:03');

-- --------------------------------------------------------

--
-- Table structure for table `status_changes`
--

CREATE TABLE `status_changes` (
  `id` int(11) NOT NULL,
  `operators_id` int(11) NOT NULL,
  `cards_id` int(11) NOT NULL,
  `status_changes` tinyint(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `turnover_operations`
--

CREATE TABLE `turnover_operations` (
  `id` int(11) NOT NULL,
  `operators_id` int(11) NOT NULL,
  `cards_id` int(11) NOT NULL,
  `scope_operation` decimal(11,2) NOT NULL,
  `actual_receipt` decimal(10,2) DEFAULT NULL,
  `bonus_amount` decimal(10,2) NOT NULL,
  `bonus_accrual` decimal(10,2) NOT NULL,
  `written_of` decimal(10,2) NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `turnover_operations`
--

INSERT INTO `turnover_operations` (`id`, `operators_id`, `cards_id`, `scope_operation`, `actual_receipt`, `bonus_amount`, `bonus_accrual`, `written_of`, `date`) VALUES
(1, 1, 10, '7231.56', '7231.56', '0.00', '0.00', '0.00', '2017-09-26 05:09:03'),
(2, 1, 10, '71000.56', '71000.56', '0.00', '2130.02', '2130.02', '2017-09-26 05:09:03'),
(3, 1, 10, '91000.56', '89000.56', '2000.00', '4450.03', '4550.03', '2017-09-26 05:09:03'),
(4, 1, 10, '7000.56', '7000.56', '0.00', '0.00', '0.00', '2017-09-26 05:09:03'),
(5, 1, 10, '65012.56', '65012.56', '0.00', '1950.38', '1950.38', '2017-09-26 05:09:03'),
(6, 1, 10, '75012.56', '73112.56', '1900.00', '10966.88', '11251.88', '2017-09-26 05:09:03'),
(7, 1, 10, '75012.56', '73112.56', '1900.00', '14622.51', '15002.51', '2017-09-26 05:09:03'),
(8, 1, 10, '75555.56', '73655.56', '1900.00', '14731.11', '15111.11', '2017-09-26 05:09:03'),
(9, 1, 10, '75555.56', '73655.56', '1900.00', '14731.11', '15111.11', '2017-09-26 05:09:03'),
(10, 1, 10, '75555.56', '73655.56', '1900.00', '14731.11', '15111.11', '2017-09-26 05:09:03'),
(11, 1, 10, '75555.56', '73655.56', '1900.00', '14731.11', '15111.11', '2017-09-26 05:09:03'),
(12, 1, 10, '85555.56', '83655.56', '1900.00', '16731.11', '17111.11', '2017-09-26 05:09:03'),
(13, 1, 10, '85555.56', '83655.56', '1900.00', '16731.11', '17111.11', '2017-09-26 05:09:03'),
(14, 1, 10, '6555.56', '4655.56', '1900.00', '931.11', '1311.11', '2017-09-26 05:09:03'),
(15, 1, 10, '3555.56', '1655.56', '1900.00', '331.11', '711.11', '2019-04-12 09:48:39'),
(16, 1, 10, '3555.56', '1655.56', '1900.00', '331.11', '711.11', '2019-04-12 09:48:53'),
(17, 1, 10, '3555.56', '1778.56', '1777.00', '355.71', '711.11', '2019-04-12 10:11:40'),
(18, 1, 10, '3555.56', '1778.56', '1777.00', '355.71', '711.11', '2019-04-12 10:12:12'),
(19, 1, 10, '233555.56', '135778.38', '97777.18', '27155.68', '46711.11', '2019-04-12 10:13:09'),
(20, 1, 10, '10555.56', '5278.56', '5277.00', '1055.71', '2111.11', '2019-04-12 10:57:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bonus_rules`
--
ALTER TABLE `bonus_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `number` (`number`);

--
-- Indexes for table `date_holidays`
--
ALTER TABLE `date_holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operators`
--
ALTER TABLE `operators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `percentage_changes`
--
ALTER TABLE `percentage_changes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_changes`
--
ALTER TABLE `status_changes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `turnover_operations`
--
ALTER TABLE `turnover_operations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bonus_rules`
--
ALTER TABLE `bonus_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `date_holidays`
--
ALTER TABLE `date_holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `operators`
--
ALTER TABLE `operators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `percentage_changes`
--
ALTER TABLE `percentage_changes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `status_changes`
--
ALTER TABLE `status_changes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `turnover_operations`
--
ALTER TABLE `turnover_operations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
