-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 29. Feb 2024 um 12:15
-- Server-Version: 10.4.27-MariaDB
-- PHP-Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `guitarworld`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20231102171404', '2023-11-02 18:14:14', 19),
('DoctrineMigrations\\Version20231102172732', '2023-11-02 18:27:40', 39),
('DoctrineMigrations\\Version20231102173651', '2023-11-02 18:36:56', 9),
('DoctrineMigrations\\Version20231102174030', '2023-11-02 18:40:35', 17),
('DoctrineMigrations\\Version20231102174746', '2023-11-02 18:47:54', 15),
('DoctrineMigrations\\Version20231102181337', '2023-11-02 19:13:45', 29),
('DoctrineMigrations\\Version20231102185813', '2023-11-02 19:58:24', 56),
('DoctrineMigrations\\Version20231102190159', '2023-11-02 20:02:03', 19),
('DoctrineMigrations\\Version20231102191050', '2023-11-02 20:10:54', 39),
('DoctrineMigrations\\Version20231102191300', '2023-11-02 20:13:04', 16),
('DoctrineMigrations\\Version20231102191812', '2023-11-02 20:18:19', 305),
('DoctrineMigrations\\Version20231103173655', '2023-11-03 18:37:04', 34),
('DoctrineMigrations\\Version20231106171449', '2023-11-06 18:15:22', 7),
('DoctrineMigrations\\Version20231108182006', '2023-11-08 19:20:16', 16),
('DoctrineMigrations\\Version20240102133052', '2024-01-02 14:31:01', 31),
('DoctrineMigrations\\Version20240103080113', '2024-01-03 09:01:21', 24),
('DoctrineMigrations\\Version20240127085348', '2024-01-27 09:53:59', 32),
('DoctrineMigrations\\Version20240127092138', '2024-01-27 10:21:41', 17);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `guitar`
--

CREATE TABLE `guitar` (
  `id` int(11) NOT NULL,
  `guitar_type_id` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL,
  `price` int(11) NOT NULL,
  `used` tinyint(1) DEFAULT NULL,
  `guitar_order_id` int(11) DEFAULT NULL,
  `body` varchar(255) NOT NULL,
  `pickup` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `guitar`
--

INSERT INTO `guitar` (`id`, `guitar_type_id`, `model`, `color`, `deleted`, `price`, `used`, `guitar_order_id`, `body`, `pickup`) VALUES
(9, 3, 'plaplapla', 'dfghdfghd', 0, 6667, 0, 58, 'required', 'required'),
(12, 2, 'Lorem ipsum dolor ', 'schwarz', 0, 123, 0, NULL, 'Fichte', 'Humbucker'),
(14, 2, ' consetetur sadipscing', 'braun', 0, 233, 0, NULL, 'Mahagoni', 'Piezo'),
(16, 2, 'sed diam', 'blau', 0, 222, 0, NULL, 'Fichte', 'Single Coil'),
(62, 9, 'dolor sit amet', 'braun', 0, 109, 0, NULL, 'FIchte', '-'),
(63, 10, 'Error', 'Rem', 1, 109, 0, NULL, 'Qui', 'Laborum'),
(64, 9, 'Voluptates aut molli', 'blau', 0, 743, 0, NULL, 'Mahagoni', 'Piezo'),
(65, 2, 'Et iusto aute volupt', 'Totam quis eos a ve', 0, 132, 0, 61, 'Nobis laborum Neces', 'Rerum sint proident'),
(93, 9, 'Qui in repudiandae a', 'rot', 0, 815, 0, NULL, 'Mahagoni', 'Humbucker'),
(94, 7, 'Quos vel praesentium', 'braun', 0, 229, 0, NULL, 'Fichte', 'Piezo'),
(95, 5, 'In alias ad nihil qu', 'gold', 0, 659, 0, NULL, 'Fichte', 'Single Coil'),
(96, 16, 'Pariatur Incididunt', 'blau', 0, 874, 0, NULL, 'Mahagoni', 'Humbucker'),
(97, 13, 'Tenetur sequi perfer', 'Ullamco velit autem', 1, 807, 0, NULL, 'Pariatur Voluptas e', 'Quibusdam asperiores'),
(98, 14, 'Elit dolores ut sim', 'Sunburst', 0, 680, 0, NULL, 'Mahagoni', 'Humbucker'),
(99, 15, 'Velit blanditiis ess', 'blau', 0, 827, 0, NULL, 'Fichte', 'Single Coil'),
(100, 9, 'Illum aliquam asper', 'Quia reiciendis ut e', 1, 571, 0, NULL, 'Commodi est accusam', 'Maiores quod enim op'),
(101, 12, 'Dolor maxime digniss', 'Numquam dolore dolor', 1, 470, 0, NULL, 'Voluptas non ut ut d', 'Maxime commodo ad qu'),
(102, 10, 'Minim ea esse vel iu', 'Amet sunt officia e', 1, 701, 0, NULL, 'Aliquam id fuga Ea ', 'Soluta voluptate aut'),
(103, 11, 'Id eos itaque elit', 'Consectetur ut inci', 1, 655, 0, NULL, 'Recusandae Ipsum q', 'Necessitatibus modi '),
(104, 1, 'Pariatur Rem do qua', 'Similique perferendi', 1, 38, 0, NULL, 'Non aut accusamus ma', 'Et et harum dolore p'),
(105, 2, 'Ratione possimus au', 'Praesentium nostrud ', 1, 963, 0, NULL, 'Sunt necessitatibus ', 'Esse cillum veniam '),
(106, 1, 'Omnis placeat volup', 'Autem et commodi fug', 1, 246, 0, NULL, 'Velit provident ut', 'Aperiam sunt illo co'),
(107, 13, 'Amet ad magni perfe', 'Dolore atque consequ', 1, 346, 0, NULL, 'Perferendis possimus', 'Illo maxime obcaecat'),
(108, 6, 'At voluptas est bla', 'Est accusantium mol', 1, 395, 0, NULL, 'Voluptatum tempore ', 'Magna similique veli'),
(109, 17, 'Exercitation optio ', 'Qui esse eu quas vel', 1, 522, 0, NULL, 'Necessitatibus offic', 'Hic proident unde a'),
(110, 13, 'Quisquam sit enim co', 'Corrupti tempor min', 1, 857, 0, NULL, 'Quasi enim qui paria', 'Labore quidem blandi'),
(111, 17, 'Dignissimos laborum ', 'Esse esse esse labo', 1, 886, 0, NULL, 'Porro iste magna arc', 'Est nulla dolor labo'),
(112, 15, 'Illo quibusdam Nam e', 'Nihil tempore iusto', 1, 397, 0, NULL, 'Cumque in ipsum eaq', 'Vel qui neque dolor '),
(113, 13, 'Consequatur Autem c', 'Excepteur ut invento', 1, 297, 0, NULL, 'Est est iure minim ', 'Sit culpa cum qui pe'),
(114, 6, 'Nesciunt eos culpa ', 'Tempore occaecat qu', 1, 480, 0, NULL, 'Nam sint quo commod', 'Aperiam dolore odio '),
(115, 11, 'Inventore dolores de', 'Illo fugit culpa ha', 1, 208, 0, NULL, 'Rerum voluptatem Er', 'Vitae quam non porro'),
(116, 16, 'Quis ipsam officiis ', 'Ex nisi architecto e', 1, 179, 0, NULL, 'Nobis laboris evenie', 'In fugit provident'),
(117, 1, 'Doloremque saepe exe', 'Quia voluptates repu', 1, 734, 0, NULL, 'Possimus in vel aut', 'Amet vitae sed quos'),
(118, 1, 'Pariatur Minim mini', 'Assumenda voluptatem', 1, 82, 0, NULL, 'Et velit quia conse', 'Inventore aut minima'),
(119, 16, 'Recusandae Quod qui', 'Maiores ut quod sint', 1, 198, 0, NULL, 'Pariatur Sint ea q', 'Pariatur Ullamco un'),
(120, 12, 'Sit eu enim reprehe', 'Dicta blanditiis min', 1, 586, 0, NULL, 'Sit iusto vel iure ', 'Autem ut temporibus '),
(121, 6, 'Nihil molestiae est ', 'Quis dolorum harum l', 0, 513, 0, 68, 'Culpa facilis tempo', 'Expedita aliquip qui'),
(122, 13, 'Beatae sed ut evenie', 'Sint placeat vero c', 0, 243, 0, NULL, 'Labore sunt aliqua', 'Tenetur id enim qui '),
(123, 7, 'Unde fugit modi et ', 'Obcaecati aut except', 0, 174, 0, 69, 'Inventore voluptates', 'Ut ut iusto tempor n'),
(124, 11, 'Repudiandae blanditi', 'Eos deserunt incidid', 0, 184, 0, 68, 'Atque et et reprehen', 'Omnis officia culpa '),
(125, 4, 'Do quis et quia labo', 'Sint corrupti moll', 1, 621, 0, NULL, 'Aliquip quo ut dolor', 'Perspiciatis molest'),
(126, 13, 'Nemo consequatur cul', 'Laudantium et est ', 0, 380, 0, 67, 'Dolores architecto p', 'Expedita explicabo '),
(127, 16, 'Do occaecat blanditi', 'Illum rerum commodi', 0, 27, 0, 66, 'Sit voluptate quaera', 'Voluptatum excepturi'),
(128, 7, 'Earum dolorum illo s', 'In qui est ipsam qu', 0, 496, 0, NULL, 'Exercitation corrupt', 'Esse ut earum distin'),
(129, 1, 'finaler test', 'test', 1, 123, 0, NULL, 'test', 'test'),
(130, 18, 'Gitarre blabla bla', 'd', 1, 1234, 0, NULL, 'sdfg', 'sdfg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `guitar_type`
--

CREATE TABLE `guitar_type` (
  `id` int(11) NOT NULL,
  `version` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `saddlewidth` int(11) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL,
  `neck` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `fretboard` varchar(255) DEFAULT NULL,
  `scale` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `guitar_type`
--

INSERT INTO `guitar_type` (`id`, `version`, `brand`, `type`, `saddlewidth`, `deleted`, `neck`, `size`, `fretboard`, `scale`) VALUES
(1, 'electri', 'Ibanez ', 'Elektrisch', 22, 0, 's', 'small', 'Palisander', 22),
(2, 'acoustic', 'Ortega', 'Elektrisch', 112, 0, '113', 'OOO', 'Pao Ferro', 114),
(3, 'tzk-34 ', 'Gibson', 'Elektrisch', 999, 0, 'Mahagoni', 'medium', 'Mahagoni', 888),
(4, 'version 23', 'Harley Benton', 'Elektrisch', 1234, 0, 'Fichte', 'small', 'Mahagoni', 1234),
(5, 'tkl', 'Squier', 'Akustisch', 47, 0, 'Fichte', 'O', 'Pao Ferro', 13),
(6, 'Esse', 'Fender', 'Elektrisch', 5, 0, 'Mahagoni', 'OO', 'Fichte', 12),
(7, 'acoustics version ETL', 'Ortega', 'Elektrisch', 9, 0, 'Mahagoni', 'OO', 'Fichte', 83),
(8, 'verion 8', 'Ortega', 'Elektrisch', 9, 0, 'Mahagoni', 'small', 'Fichte', 83),
(9, 'Non laboris ', 'G&L', 'Elektrisch', 49, 0, 'Mahagoni', 'OO', 'Mahagoni', 82),
(10, 'Id minima nisi nostr', 'A ipsa et id mollit', 'Elektrisch', 12, 1, 'Commodo aliquam quae', 'Deserunt enim quidem', 'Sit consequatur nec', 14),
(11, 'Maxime ', 'ESP', 'Elektrisch', 4, 0, 'Fichte', 'XL', 'Mahagoni', 14),
(12, 'version 33', 'Harley Benton', 'Elektrisch', 95, 0, 'Mahagoni', 'OO', 'Palisander', 75),
(13, 'testversion', 'Ibanez', 'Elektrisch', 26, 0, 'Mahagoni', 'o', 'Palisander', 55),
(14, 'Quia ', 'Gibson', 'Akustisch', 75, 0, 'Mahagoni', 'Concert', 'Fichte', 98),
(15, 'version expensive', 'PRS', 'Akustisch', 23, 0, 'Mahagoni', 'OO', 'Mahagoni', 23),
(16, 'Quas ', 'Cort', 'Akustisch', 12, 0, 'Mahagoni', 'small', 'Mahagoni', 62),
(17, 'expanded', 'Maybach', 'Akustisch', 66, 0, 'Pao Ferro', 'XL', 'Pao Ferro', 57),
(18, '123', 'blabla', 'Elektrisch', 123, 1, '123', '123', '123', 123);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `image`
--

INSERT INTO `image` (`id`, `name`) VALUES
(91, 'assets/uploads/237-536x354.jpg'),
(92, 'assets/uploads/866-536x354.jpg'),
(93, 'assets/uploads/1084-536x354-grayscale.jpg'),
(94, 'assets/uploads/1060-536x354-blur_2.jpg'),
(95, 'assets/uploads/870-536x354-blur_2-grayscale.jpg'),
(96, 'assets/uploads/237-536x354 - Kopie.jpg'),
(97, 'assets/uploads/237-536x354 - Kopie - Kopie.jpg'),
(98, 'assets/uploads/866-536x354 - Kopie.jpg'),
(99, 'assets/uploads/237-536x354 - Kopie - Kopie - Kopie.jpg'),
(100, 'assets/uploads/1060-536x354-blur_2 - Kopie.jpg'),
(101, 'assets/uploads/13546961_800.jpg'),
(102, 'assets/uploads/14595663_800.jpg'),
(103, 'assets/uploads/14952000_800.jpg'),
(104, 'assets/uploads/14703496_800.jpg'),
(105, 'assets/uploads/13869331_800.jpg'),
(106, 'assets/uploads/17309766_800.jpg'),
(107, 'assets/uploads/18377293_800.jpg'),
(108, 'assets/uploads/16636236_800.jpg'),
(109, 'assets/uploads/14381893_800.jpg'),
(110, 'assets/uploads/16834186_800.jpg'),
(111, 'assets/uploads/16927820_800.jpg'),
(112, 'assets/uploads/16265526_800.jpg'),
(113, 'assets/uploads/16415116_800.jpg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `image_guitar`
--

CREATE TABLE `image_guitar` (
  `id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `guitar_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `image_guitar`
--

INSERT INTO `image_guitar` (`id`, `image_id`, `guitar_id`) VALUES
(130, 101, 9),
(131, 102, 12),
(132, 103, 98),
(133, 104, 99),
(134, 105, 14),
(138, 106, 64),
(139, 102, 16),
(140, 109, 62),
(141, 102, 65),
(142, 110, 93),
(143, 111, 94),
(144, 112, 95),
(145, 106, 96);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `pay_date` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `paid` date DEFAULT NULL,
  `canceled` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `order`
--

INSERT INTO `order` (`id`, `date`, `pay_date`, `user_id`, `paid`, `canceled`) VALUES
(45, '2024-02-03', '2024-02-17', 84, NULL, '2024-02-03'),
(46, '2024-02-03', '2024-02-17', 85, NULL, '2024-02-03'),
(47, '2024-02-03', '2024-02-17', 86, NULL, '2024-02-03'),
(48, '2024-02-03', '2024-02-17', 87, NULL, '2024-02-12'),
(49, '2024-02-12', '2024-02-26', 88, NULL, '2024-02-12'),
(50, '2024-02-12', '2024-02-26', 89, NULL, '2024-02-12'),
(51, '2024-02-12', '2024-02-26', 90, NULL, '2024-02-12'),
(52, '2024-02-27', '2024-03-12', 92, NULL, '2024-02-27'),
(53, '2024-02-27', '2024-03-12', 93, NULL, '2024-02-27'),
(54, '2024-02-27', '2024-03-12', 94, NULL, '2024-02-27'),
(55, '2024-02-28', '2024-03-13', 95, NULL, '2024-02-28'),
(56, '2024-02-28', '2024-03-13', 96, NULL, '2024-02-28'),
(57, '2024-02-28', '2024-03-13', 97, NULL, '2024-02-28'),
(58, '2024-02-28', '2024-03-13', 98, '2024-02-29', NULL),
(59, '2024-02-28', '2024-03-13', 99, NULL, '2024-02-28'),
(60, '2024-02-28', '2024-03-13', 100, NULL, '2024-02-28'),
(61, '2024-02-28', '2024-03-13', 101, '2024-02-28', NULL),
(62, '2024-02-28', '2024-03-13', 102, NULL, '2024-02-28'),
(63, '2024-02-28', '2024-03-13', 103, NULL, '2024-02-28'),
(64, '2024-02-29', '2024-03-14', 104, NULL, '2024-02-29'),
(65, '2024-02-29', '2024-03-14', 105, NULL, '2024-02-29'),
(66, '2024-02-29', '2024-03-14', 106, '2024-02-29', NULL),
(67, '2024-02-29', '2024-03-14', 107, NULL, NULL),
(68, '2024-02-29', '2024-03-14', 109, NULL, NULL),
(69, '2024-02-29', '2024-03-14', 111, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) DEFAULT NULL,
  `street` varchar(255) NOT NULL,
  `housenumber` int(11) NOT NULL,
  `zipcode` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `begin` date DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `street`, `housenumber`, `zipcode`, `firstname`, `lastname`, `city`, `deleted`, `begin`, `phone`, `birthday`) VALUES
(1, 'admin@email.de', '[\"ROLE_ADMIN\"]', 'f6fdffe48c908deb0f4c3bd36c032e72', 'Teststraße', 11, 52432, 'Flynn', 'Tester', 'Berlin', 0, NULL, NULL, NULL),
(3, 'wedycy@mailinator.com', '[\"ROLE_USER\"]', 'Pa$$w0rd!', 'Ex ut architecto ull', 519, 70211, 'Kai', 'Madden', 'Illum ipsa volupta', 0, '2023-11-08', '+1 (222) 397-5617', '2023-11-08'),
(35, 'test@ingo.de', '[\"ROLE_USER\"]', '098f6bcd4621d373cade4e832627b4f6', 'Sunt sit cumque qui ', 317, 82953, 'Vielka', 'Kelley', 'Beatae autem nulla c', 0, '2023-11-10', '+1 (342) 784-1233', '2023-11-10'),
(36, 'test@test.de', '[\"ROLE_USER\"]', 'f6fdffe48c908deb0f4c3bd36c032e72', 'Quia eius animi quo', 224, 74525, 'Christine', 'Hardin', 'Ut occaecat sit nos', 0, '2024-01-02', '+1 (875) 384-6534', '2024-01-02'),
(37, 'user@email.de', '[\"ROLE_USER\"]', '5cc32e366c87c4cb49e4309b75f57d64', 'Fugiat laboriosam ', 654, 81150, 'Remedios', 'Pena', 'Officia eiusmod quas', 0, '2024-01-02', '+1 (694) 104-9216', '2024-01-02'),
(38, 'dutapyf@mailinator.com', '[\"ROLE_USER\"]', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', 'Maxime dolores Nam v', 969, 86440, 'Cherokee', 'Morse', 'Sequi ea maiores dol', 0, '2024-01-02', '+1 (284) 807-6636', '2024-01-02'),
(39, 'vaxa@mailinator.com', '[\"ROLE_USER\"]', NULL, 'bacy@mailinator.com', 981, 51816, 'Latifah', 'Chase', 'qofijalux@mailinator.com', 0, '2024-01-27', 'qamamiqej@mailinator.com', '2024-01-27'),
(41, 'soquj@mailinator.com', '[\"ROLE_USER\"]', NULL, 'lulerava@mailinator.com', 525, 52359, 'Ali', 'Barnes', 'symed@mailinator.com', 0, '2024-01-27', 'peha@mailinator.com', '2024-01-27'),
(42, 'xedefin@mailinator.com', '[\"ROLE_USER\"]', NULL, 'momakat@mailinator.com', 394, 39864, 'Charde', 'Pollard', 'daxyfemizy@mailinator.com', 0, '2024-01-27', 'kyzylovuh@mailinator.com', '2024-01-27'),
(43, 'testorder1@mailinator.com', '[\"ROLE_USER\"]', NULL, 'sadum@mailinator.com', 695, 82791, 'Madaline', 'Snider', 'jedatino@mailinator.com', 0, '2024-01-27', 'vegozeh@mailinator.com', '2024-01-27'),
(44, '111@mailinator.com', '[\"ROLE_USER\"]', NULL, 'ridurirob@mailinator.com', 74, 26177, 'Bernard', 'Rose', 'seroc@mailinator.com', 0, '2024-01-27', 'govuza@mailinator.com', '2024-01-27'),
(45, 'zulawiv@mailinator.com', '[\"ROLE_USER\"]', NULL, 'tida@mailinator.com', 180, 35360, 'Ross', 'Warner', 'wyfaky@mailinator.com', 0, '2024-01-27', 'jewewo@mailinator.com', '2024-01-27'),
(46, 'hajobi@mailinator.com', '[\"ROLE_USER\"]', NULL, 'rahib@mailinator.com', 118, 27628, 'Mary', 'Charles', 'nezel@mailinator.com', 0, '2024-01-27', 'naqidotyv@mailinator.com', '2024-01-27'),
(48, 'fyhygu@mailinator.com', '[\"ROLE_USER\"]', NULL, 'riba@mailinator.com', 493, 87263, 'Eric', 'Zamora', 'gotiteceh@mailinator.com', 0, '2024-01-27', 'pixanyvux@mailinator.com', '2024-01-27'),
(50, 'pura@mailinator.com', '[\"ROLE_USER\"]', NULL, 'doridah@mailinator.com', 947, 90639, 'Gabriel', 'Knight', 'gepuqereta@mailinator.com', 0, '2024-01-27', 'tawab@mailinator.com', '2024-01-27'),
(52, 'test222@mailinator.com', '[\"ROLE_USER\"]', NULL, 'boza@mailinator.com', 43, 49483, 'Ruby', 'Mccarty', 'rojob@mailinator.com', 0, '2024-01-27', 'xisutogubo@mailinator.com', '2024-01-27'),
(53, 'hund@mailinator.com', '[\"ROLE_USER\"]', NULL, 'qyjoq@mailinator.com', 157, 25676, 'Kirby', 'Durham', 'syreketumy@mailinator.com', 0, '2024-01-27', 'moxoxan@mailinator.com', '2024-01-27'),
(54, 'zydumyze@mailinator.com', '[\"ROLE_USER\"]', NULL, 'sobu@mailinator.com', 778, 80144, 'Scarlet', 'Pratt', 'kozoxyvi@mailinator.com', 0, '2024-01-27', 'lolymohoq@mailinator.com', '2024-01-27'),
(55, 'letzterBesteller@mailinator.com', '[\"ROLE_USER\"]', NULL, 'fyqyxomym@mailinator.com', 405, 11918, 'Angelica', 'Kelly', 'wakuqy@mailinator.com', 0, '2024-01-27', 'jubyhuviwe@mailinator.com', '2024-01-27'),
(56, 'tigufamyv@mailinator.com', '[\"ROLE_USER\"]', NULL, 'fumydyjuqi@mailinator.com', 916, 45530, 'Burton', 'Bonner', 'resany@mailinator.com', 0, '2024-01-27', 'ragyf@mailinator.com', '2024-01-27'),
(57, 'nirazony@mailinator.com', '[\"ROLE_USER\"]', NULL, 'gorabat@mailinator.com', 972, 15900, 'Tanya', 'Pitts', 'myhyx@mailinator.com', 0, '2024-01-27', 'wumyc@mailinator.com', '2024-01-27'),
(59, 'nihacinim@mailinator.com', '[\"ROLE_USER\"]', NULL, 'viroc@mailinator.com', 674, 83889, 'Fitzgerald', 'Sampson', 'rahuz@mailinator.com', 0, '2024-01-27', 'vohepipid@mailinator.com', '2024-01-27'),
(61, 'bonafo@mailinator.com', '[\"ROLE_USER\"]', NULL, 'zyvezy@mailinator.com', 648, 93834, 'Kaseem', 'Morrow', 'hodahiced@mailinator.com', 0, '2024-01-27', 'licocuq@mailinator.com', '2024-01-27'),
(62, 'rykykukava@mailinator.com', '[\"ROLE_USER\"]', NULL, 'gyzita@mailinator.com', 226, 13542, 'Nehru', 'Velasquez', 'nana@mailinator.com', 0, '2024-01-27', 'ruxup@mailinator.com', '2024-01-27'),
(63, 'fifut@mailinator.com', '[\"ROLE_USER\"]', NULL, 'vydecomut@mailinator.com', 880, 83138, 'Ulysses', 'Ward', 'xanowi@mailinator.com', 0, '2024-01-27', 'xupufin@mailinator.com', '2024-01-27'),
(64, 'kogusixaw@mailinator.com', '[\"ROLE_USER\"]', NULL, 'pibah@mailinator.com', 799, 56726, 'Ignacia', 'Hatfield', 'qahe@mailinator.com', 0, '2024-01-27', 'tuhav@mailinator.com', '2024-01-27'),
(65, 'negatop@mailinator.com', '[\"ROLE_USER\"]', NULL, 'xiwitof@mailinator.com', 392, 35997, 'Giacomo', 'Middleton', 'kiqysozaq@mailinator.com', 0, '2024-01-27', 'jaho@mailinator.com', '2024-01-27'),
(66, 'bypecac@mailinator.com', '[\"ROLE_USER\"]', NULL, 'degysa@mailinator.com', 436, 26911, 'Logan', 'Boone', 'fatakunod@mailinator.com', 0, '2024-01-27', 'koxe@mailinator.com', '2024-01-27'),
(67, 'dabydune@mailinator.com', '[\"ROLE_USER\"]', NULL, 'syfejytat@mailinator.com', 134, 14891, 'Slade', 'Stanley', 'nejecyw@mailinator.com', 0, '2024-01-27', 'biwijysi@mailinator.com', '2024-01-27'),
(69, 'zuqo@mailinator.com', '[\"ROLE_USER\"]', NULL, 'cytu@mailinator.com', 650, 12408, 'Sacha', 'Mcguire', 'xabi@mailinator.com', 0, '2024-01-27', 'faheximyfe@mailinator.com', '2024-01-27'),
(70, 'gufev@mailinator.com', '[\"ROLE_USER\"]', NULL, 'tagufe@mailinator.com', 994, 82130, 'Glenna', 'Franks', 'bixawaki@mailinator.com', 0, '2024-01-27', 'ryku@mailinator.com', '2024-01-27'),
(72, 'kuhupywes@mailinator.com', '[\"ROLE_USER\"]', NULL, 'wygu@mailinator.com', 399, 51413, 'Chandler', 'Morales', 'ciwap@mailinator.com', 0, '2024-01-27', 'qodil@mailinator.com', '2024-01-27'),
(73, 'pogyqudaru@mailinator.com', '[\"ROLE_USER\"]', NULL, 'fihihu@mailinator.com', 426, 72671, 'Iris', 'Mcdonald', 'sudol@mailinator.com', 0, '2024-01-27', 'luforiju@mailinator.com', '2024-01-27'),
(74, 'qykulod@mailinator.com', '[\"ROLE_USER\"]', NULL, 'jivuwumu@mailinator.com', 203, 32413, 'Lyle', 'Rivas', 'hajyquj@mailinator.com', 0, '2024-01-27', 'jata@mailinator.com', '2024-01-27'),
(75, 'bexaguliz@mailinator.com', '[\"ROLE_USER\"]', NULL, 'fijo@mailinator.com', 109, 23611, 'Montana', 'Gilmore', 'zodinyjema@mailinator.com', 0, '2024-01-27', 'kehi@mailinator.com', '2024-01-27'),
(76, 'pidiqeny@mailinator.com', '[\"ROLE_USER\"]', NULL, 'viqabiqiga@mailinator.com', 311, 70835, 'Martena', 'Gill', 'fukevizu@mailinator.com', 0, '2024-01-27', 'pusu@mailinator.com', '2024-01-27'),
(77, 'nyti@mailinator.com', '[\"ROLE_USER\"]', NULL, 'ratykycaca@mailinator.com', 319, 97571, 'Tate', 'Stuart', 'zufu@mailinator.com', 0, '2024-01-27', 'zisaxog@mailinator.com', '2024-01-27'),
(78, 'jysubinysa@mailinator.com', '[\"ROLE_USER\"]', NULL, 'nexe@mailinator.com', 393, 71013, 'Ursula', 'Herrera', 'dunexapy@mailinator.com', 0, '2024-01-31', 'lodygukizy@mailinator.com', '2024-01-31'),
(79, 'vuzoxasuze@mailinator.com', '[\"ROLE_USER\"]', NULL, 'gudalofib@mailinator.com', 248, 66160, 'Oren', 'Hayes', 'nebewuhoqy@mailinator.com', 0, '2024-01-31', 'raguqiwy@mailinator.com', '2024-01-31'),
(80, 'roqid@mailinator.com', '[\"ROLE_USER\"]', NULL, 'jupu@mailinator.com', 423, 94182, 'Yoshio', 'Watson', 'gysu@mailinator.com', 0, '2024-01-31', 'kipafa@mailinator.com', '2024-01-31'),
(81, 'wyjyki@mailinator.com', '[\"ROLE_USER\"]', NULL, 'zuruhud@mailinator.com', 233, 20034, 'Serena', 'Levy', 'jigaxiby@mailinator.com', 0, '2024-02-03', 'hiqaqo@mailinator.com', '2024-02-03'),
(82, 'galonataj@mailinator.com', '[\"ROLE_USER\"]', NULL, 'gedodi@mailinator.com', 95, 96516, 'Aristotle', 'Romero', 'jynugynopo@mailinator.com', 0, '2024-02-03', 'qiby@mailinator.com', '2024-02-03'),
(83, 'hulolida@mailinator.com', '[\"ROLE_USER\"]', NULL, 'sicymi@mailinator.com', 118, 66586, 'Herrod', 'Byers', 'qexyfyc@mailinator.com', 0, '2024-02-03', 'muzyvedyqe@mailinator.com', '2024-02-03'),
(84, 'dedyvuq@mailinator.com', '[\"ROLE_USER\"]', NULL, 'pokuciky@mailinator.com', 655, 38918, 'Rhonda', 'Douglas', 'tydolaboxa@mailinator.com', 0, '2024-02-03', 'zyho@mailinator.com', '2024-02-03'),
(85, 'qasixi@mailinator.com', '[\"ROLE_USER\"]', NULL, 'zypunofagu@mailinator.com', 390, 34660, 'Naida', 'Evans', 'byzojekyr@mailinator.com', 0, '2024-02-03', 'kevuco@mailinator.com', '2024-02-03'),
(86, 'fahu@mailinator.com', '[\"ROLE_USER\"]', NULL, 'qusyho@mailinator.com', 203, 68012, 'Madonna', 'Evans', 'hozefos@mailinator.com', 0, '2024-02-03', 'nagobimyv@mailinator.com', '2024-02-03'),
(87, 'gatuzaq@mailinator.com', '[\"ROLE_USER\"]', NULL, 'qezajoro@mailinator.com', 108, 19063, 'Kathleen', 'Frederick', 'basamy@mailinator.com', 0, '2024-02-03', 'lyqywugiv@mailinator.com', '2024-02-03'),
(88, 'newixaw@mailinator.com', '[\"ROLE_USER\"]', NULL, 'miduqubo@mailinator.com', 243, 79787, 'Damon', 'Norton', 'losi@mailinator.com', 0, '2024-02-12', 'bujimusa@mailinator.com', '2024-02-12'),
(89, 'golalubota@mailinator.com', '[\"ROLE_USER\"]', NULL, 'xoxip@mailinator.com', 302, 13106, 'Stuart', 'Mathis', 'qonyqi@mailinator.com', 0, '2024-02-12', 'xamum@mailinator.com', '2024-02-12'),
(90, 'vuwegew@mailinator.com', '[\"ROLE_USER\"]', NULL, 'jiwafuvyq@mailinator.com', 553, 68975, 'Beck', 'Barlow', 'vipavuhez@mailinator.com', 0, '2024-02-12', 'moheqiqave@mailinator.com', '2024-02-12'),
(91, 'syvujy@mailinator.com', '[\"ROLE_USER\"]', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', 'Sit quas optio vita', 742, 28745, 'Anthony', 'Whitney', 'Vero aut dignissimos', 0, '2024-02-20', '+1 (125) 812-5368', '2024-02-20'),
(92, 'cavyvosoj@mailinator.com', '[\"ROLE_USER\"]', NULL, 'boqehineb@mailinator.com', 36, 33829, 'Jarrod', 'Stanley', 'tygigukuse@mailinator.com', 0, '2024-02-27', 'pekuvivewy@mailinator.com', '2024-02-27'),
(93, 'zagyda@mailinator.com', '[\"ROLE_USER\"]', NULL, 'qopibujyk@mailinator.com', 36, 74335, 'Nathaniel', 'Wilder', 'jiryzafyqo@mailinator.com', 0, '2024-02-27', 'lovomi@mailinator.com', '2024-02-27'),
(94, 'magikiruq@mailinator.com', '[\"ROLE_USER\"]', NULL, 'verejywo@mailinator.com', 345, 19271, 'Honorato', 'Horne', 'bulu@mailinator.com', 0, '2024-02-27', 'labybizy@mailinator.com', '2024-02-27'),
(95, 'laryweb@mailinator.com', '[\"ROLE_USER\"]', NULL, 'hujolyjab@mailinator.com', 102, 50483, 'Jemima', 'Brown', 'sigegir@mailinator.com', 0, '2024-02-28', 'tylera@mailinator.com', '2024-02-28'),
(96, 'zykus@mailinator.com', '[\"ROLE_USER\"]', NULL, 'pakifafequ@mailinator.com', 400, 84473, 'Yuli', 'Casey', 'tagivev@mailinator.com', 0, '2024-02-28', 'loqopeqa@mailinator.com', '2024-02-28'),
(97, 'samugajes@mailinator.com', '[\"ROLE_USER\"]', NULL, 'xexu@mailinator.com', 803, 80694, 'Kitra', 'Wheeler', 'tafasa@mailinator.com', 0, '2024-02-28', 'vybokamovu@mailinator.com', '2024-02-28'),
(98, 'lora@mailinator.com', '[\"ROLE_USER\"]', NULL, 'duvapi@mailinator.com', 975, 80574, 'Jorden', 'Cortez', 'repujozym@mailinator.com', 0, '2024-02-28', 'wykydiz@mailinator.com', '2024-02-28'),
(99, 'xynehiraxo@mailinator.com', '[\"ROLE_USER\"]', NULL, 'colo@mailinator.com', 794, 87144, 'Briar', 'Parks', 'japisi@mailinator.com', 0, '2024-02-28', 'rarumihy@mailinator.com', '2024-02-28'),
(100, 'hoqefufafo@mailinator.com', '[\"ROLE_USER\"]', NULL, 'daxylah@mailinator.com', 259, 59639, 'Meredith', 'Prince', 'qysivub@mailinator.com', 0, '2024-02-28', 'kabugiq@mailinator.com', '2024-02-28'),
(101, 'degajupyzo@mailinator.com', '[\"ROLE_USER\"]', NULL, 'teststraße', 760, 95721, 'Margaret', 'Dixon', 'testort', 0, '2024-02-28', '1234', '2024-02-28'),
(102, 'mixy@mailinator.com', '[\"ROLE_USER\"]', NULL, 'potyhybek@mailinator.com', 702, 54233, 'Chaney', 'Mcleod', 'gyxefedeb@mailinator.com', 0, '2024-02-28', 'vugofyqiv@mailinator.com', '2024-02-28'),
(103, 'vujacef@mailinator.com', '[\"ROLE_USER\"]', NULL, 'pibulufyzy@mailinator.com', 373, 94524, 'Oprah', 'Williams', 'fyxi@mailinator.com', 0, '2024-02-28', 'rotanet@mailinator.com', '2024-02-28'),
(104, 'cyhu@mailinator.com', '[\"ROLE_USER\"]', NULL, 'stra0ße', 33, 97911, 'Jason', 'Kline', 'ort', 0, '2024-02-29', '1234', '2024-02-29'),
(105, 'kasu@mailinator.com', '[\"ROLE_USER\"]', NULL, 'vonywuwijo@mailinator.com', 833, 19056, 'Ivy', 'Burgess', 'pybefina@mailinator.com', 0, '2024-02-29', 'pivysiqesy@mailinator.com', '2024-02-29'),
(106, 'cygypaza@mailinator.com', '[\"ROLE_USER\"]', NULL, 'desupafyz@mailinator.com', 955, 65086, 'Stephen', 'Bernard', 'mojyvijore@mailinator.com', 0, '2024-02-29', 'kepug@mailinator.com', '2024-02-29'),
(107, 'gopuwel@mailinator.com', '[\"ROLE_USER\"]', NULL, 'tyxabevyri@mailinator.com', 466, 10666, 'Quemby', 'Sargent', 'lycifo@mailinator.com', 0, '2024-02-29', 'hosohawoh@mailinator.com', '2024-02-29'),
(109, 'test@test1.de', '[\"ROLE_USER\"]', NULL, 'testsraße', 123, 345, 'test', 'test', 'TestOrt', 0, '2024-02-29', '536543', '2024-02-29'),
(111, 'test@test2.de', '[\"ROLE_USER\"]', NULL, '1234', 1234, 4321, 'asdf', 'asdf', 'ort', 0, '2024-02-29', '3456', '2024-02-29');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indizes für die Tabelle `guitar`
--
ALTER TABLE `guitar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_423AC30D5026D2CB` (`guitar_type_id`),
  ADD KEY `IDX_423AC30DE8BADEA0` (`guitar_order_id`);

--
-- Indizes für die Tabelle `guitar_type`
--
ALTER TABLE `guitar_type`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `image_guitar`
--
ALTER TABLE `image_guitar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_ED279DC53DA5256D` (`image_id`),
  ADD KEY `IDX_ED279DC548420B1E` (`guitar_id`);

--
-- Indizes für die Tabelle `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indizes für die Tabelle `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F5299398A76ED395` (`user_id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `guitar`
--
ALTER TABLE `guitar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT für Tabelle `guitar_type`
--
ALTER TABLE `guitar_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT für Tabelle `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT für Tabelle `image_guitar`
--
ALTER TABLE `image_guitar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT für Tabelle `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `guitar`
--
ALTER TABLE `guitar`
  ADD CONSTRAINT `FK_423AC30D5026D2CB` FOREIGN KEY (`guitar_type_id`) REFERENCES `guitar_type` (`id`),
  ADD CONSTRAINT `FK_423AC30DE8BADEA0` FOREIGN KEY (`guitar_order_id`) REFERENCES `order` (`id`);

--
-- Constraints der Tabelle `image_guitar`
--
ALTER TABLE `image_guitar`
  ADD CONSTRAINT `FK_ED279DC53DA5256D` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`),
  ADD CONSTRAINT `FK_ED279DC548420B1E` FOREIGN KEY (`guitar_id`) REFERENCES `guitar` (`id`);

--
-- Constraints der Tabelle `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F5299398A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
