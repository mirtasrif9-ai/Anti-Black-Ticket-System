-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2025 at 11:59 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `railway`
--

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `from_station` varchar(255) NOT NULL,
  `to_station` varchar(255) NOT NULL,
  `class` varchar(50) NOT NULL,
  `travel_date` date NOT NULL,
  `passengers_count` int(11) NOT NULL,
  `passenger_names` text DEFAULT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `total_fare` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `booking_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `ticket_status` enum('pending','confirmed','canceled','expired') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `user_id`, `from_station`, `to_station`, `class`, `travel_date`, `passengers_count`, `passenger_names`, `phone_number`, `email`, `total_fare`, `payment_method`, `booking_time`, `ticket_status`) VALUES
(16, 1, 'New Delhi (NDLS)', 'Ajmer Junction (AII)', 'Chair', '2025-07-13', 1, '[\"tasrif\"]', '013665', 'mirtarif9@gmail.com', 0.00, 'Wallet', '2025-07-12 05:05:50', 'pending'),
(31, 8, 'New Delhi (NDLS)', 'Ghaziabad (GZB)', 'Sleeper', '2025-07-19', 1, '[\"tasrif\"]', '013665', 'mirtasrif9@gmail.com', 40.00, 'Wallet', '2025-07-14 05:31:35', 'confirmed'),
(37, 11, 'Dhaka', 'Mymensingh', 'S_Chair', '2025-07-22', 2, '[\"Abu Turaf\",\"Alfa\"]', '01521111040', 'abuturaf.mec2019@gmail.com', 320.00, 'Bkash', '2025-07-20 17:58:22', 'pending'),
(38, 11, 'Dhaka', 'Biman_Bandar', 'Snigda', '2025-07-22', 2, '[\"Abu Turaf\",\"Rafin\"]', '01521111040', 'abuturaf.mec2019@gmail.com', 160.00, 'Bkash', '2025-07-20 18:07:05', 'confirmed'),
(39, 12, 'Dhaka', 'Chattogram', 'Snigda', '2025-07-24', 1, '[\"Tasrif\"]', '01968251125', 'mirtasrif9@gmail.com', 960.00, 'Wallet', '2025-07-21 05:15:28', 'confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `trains`
--

CREATE TABLE `trains` (
  `id` int(11) NOT NULL,
  `train_name` varchar(255) NOT NULL,
  `train_number` varchar(50) NOT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trains`
--

INSERT INTO `trains` (`id`, `train_name`, `train_number`, `category`) VALUES
(21, 'Suborno Express', '701', 'Intercity'),
(22, 'Cox\'s Bazar Express', '814', 'Intercity'),
(36, 'Mahanagar Provati', '704', 'Intercity'),
(39, 'Upaban Express', '739', 'Intercity'),
(44, 'Upakul Express', '712', 'Intercity'),
(45, 'Mohanganj Express', '789', 'Intercity'),
(46, 'Chitra Express', '764', 'Intercity'),
(47, 'Aghnibina Express', '735', 'Intercity'),
(48, 'Tisha Express', '707', 'Intercity'),
(49, 'Padma Express', '759', 'Intercity'),
(50, 'Bijoy Express', '786', 'Intercity'),
(51, 'Kapotaksha Express', '715', 'Intercity'),
(52, 'Maitree Express', '13107', 'International'),
(53, 'Mitali Express', '13131', 'International'),
(54, 'Dewanganj Commuter', '43', 'Commuter'),
(55, 'Titas Commuter', '34', 'Commuter'),
(57, 'Chattogram Mail', '716', 'Mail'),
(58, 'Banglabanda Express', '803', 'Mail');

-- --------------------------------------------------------

--
-- Table structure for table `train_stations`
--

CREATE TABLE `train_stations` (
  `id` int(11) NOT NULL,
  `train_id` int(11) NOT NULL,
  `station_name` varchar(255) NOT NULL,
  `arrival_time` time DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  `stop_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `train_stations`
--

INSERT INTO `train_stations` (`id`, `train_id`, `station_name`, `arrival_time`, `departure_time`, `stop_order`) VALUES
(642, 21, 'Dhaka', NULL, '16:30:00', 1),
(643, 21, 'Biman Bandar', '16:58:00', '17:00:00', 2),
(644, 21, 'Chattogram', '21:25:00', NULL, 13),
(645, 22, 'Dhaka', NULL, '23:00:00', 1),
(646, 22, 'Biman_Bandar', '23:28:00', '23:30:00', 2),
(647, 22, 'Chattogram', NULL, '04:20:01', 14),
(648, 22, 'Cox\'s Bazar', '07:20:00', NULL, 18),
(683, 36, 'Dhaka', NULL, '07:45:00', 1),
(684, 36, 'Biman_Bandar', '08:12:00', '08:14:00', 2),
(685, 36, 'Narsingdi', '08:53:00', '08:55:00', 3),
(686, 36, 'Bhairab_Bazar', '09:22:00', '09:24:00', 4),
(687, 36, 'Brahmanbaria', '09:44:00', '09:46:00', 5),
(688, 36, 'Akhaura', '10:08:00', '10:10:00', 6),
(689, 36, 'Cumilla', '10:53:00', '10:55:00', 7),
(690, 36, 'Laksam', '11:17:00', '11:19:00', 8),
(691, 36, 'Gunabati', '11:45:00', '11:47:00', 9),
(692, 36, 'Feni', '12:02:00', '12:04:00', 10),
(693, 36, 'Chattogram', '13:35:00', NULL, 11),
(701, 39, 'Dhaka', NULL, '22:00:00', 1),
(702, 39, 'Biman_Bandar', '22:28:00', '22:30:00', 2),
(703, 39, 'Narsingdi', '23:11:00', '23:13:00', 3),
(704, 39, 'Bhairab_Bazar', '23:43:00', '23:45:00', 4),
(706, 39, 'Shaistaganj', '01:25:00', '01:27:00', 6),
(707, 39, 'Sreemangal', '02:11:00', '02:13:00', 7),
(708, 39, 'Bhanugach', '02:32:00', '02:34:00', 8),
(709, 39, 'Shamshernagar', '02:43:00', '02:45:00', 9),
(710, 39, 'Kulara ', '03:11:00', '03:15:00', 10),
(711, 39, 'Baramchal', '03:27:00', '03:30:00', 11),
(712, 39, 'Maijgaon', '03:45:00', '03:47:00', 12),
(713, 39, 'Sylhet', '05:00:00', NULL, 13),
(735, 44, 'Dhaka', NULL, '15:10:00', 1),
(736, 44, 'Biman_Bandar', '15:38:00', '15:40:00', 2),
(737, 44, 'Narsingdi', '16:20:00', '16:22:00', 3),
(738, 44, 'Bhairab_Bazar', '16:53:00', '16:55:00', 4),
(739, 44, 'Ashuganj', '17:03:00', '17:05:00', 5),
(740, 44, 'Brahmanbaria', '17:21:00', '17:23:00', 6),
(741, 44, 'Akhaura', '17:50:00', '17:52:00', 7),
(742, 44, 'Quasba', '18:08:00', '18:10:00', 8),
(743, 44, 'Cumilla', '18:40:00', '18:42:00', 9),
(744, 44, 'Laksam', '19:06:00', '19:08:00', 10),
(745, 44, 'Natherpetaa', '19:28:00', '19:30:00', 11),
(746, 44, 'Sonaimuri', '19:42:00', '19:44:00', 12),
(747, 44, 'Bajra', '19:53:00', '19:55:00', 13),
(748, 44, 'Choumuhani', '20:06:00', '20:08:00', 14),
(749, 44, 'Maijdi', '20:20:00', '20:22:00', 15),
(751, 44, 'Noakhali', '20:40:00', NULL, 17),
(752, 45, 'Dhaka', NULL, '13:15:00', 1),
(753, 45, 'Biman_Bandar', '13:42:00', '13:44:00', 2),
(754, 45, 'Gaforgaon', '15:24:00', '15:26:00', 3),
(755, 45, 'Mymensingh', '16:30:00', '16:40:00', 4),
(756, 45, 'Gouripur_Myn', '16:57:00', '16:59:00', 5),
(757, 45, 'Shyamgonj', '17:14:00', '17:16:00', 6),
(758, 45, 'Netrokona', '17:36:00', '17:38:00', 7),
(759, 45, 'Thakrokona', '17:50:00', '17:52:00', 8),
(760, 45, 'Barhatta', '18:04:00', '18:06:00', 9),
(761, 45, 'Mohanganj', '18:40:00', NULL, 10),
(762, 46, 'Dhaka', NULL, '19:30:00', 1),
(763, 46, 'Biman_Bandar', '19:58:00', '20:00:00', 2),
(764, 46, 'Joydebpur', '20:23:00', '20:25:00', 3),
(765, 46, 'Tangail', '21:28:00', '21:30:00', 4),
(766, 46, 'Ibrahimabad', '21:50:00', '21:52:00', 5),
(767, 46, 'SH M Monsur Ali', '22:09:00', '22:11:00', 6),
(768, 46, 'Ullapara', '22:27:00', '22:29:00', 7),
(769, 46, 'Boral_Bridge', '22:50:00', '22:52:00', 8),
(770, 46, 'Chatmohar', '23:07:00', '23:09:00', 9),
(771, 46, 'Ishwardi', '23:55:00', '23:57:00', 10),
(772, 46, 'Bheramara', '00:28:00', '00:30:00', 11),
(773, 46, 'Poradaha', '00:50:00', '00:52:00', 12),
(774, 46, 'Alamdanga', '01:07:00', '01:09:00', 13),
(775, 46, 'Chuadanga', '01:28:00', '01:29:00', 14),
(776, 46, 'Kotchandpur', '02:18:00', '02:20:00', 15),
(777, 46, 'Mubarakganj', '02:32:00', '02:34:00', 16),
(778, 46, 'Jashore', '03:12:00', '03:14:00', 17),
(779, 46, 'Noapara', '03:42:00', '03:45:00', 18),
(780, 46, 'Khulna', '04:40:00', NULL, 19),
(781, 47, 'Dhaka', NULL, '11:30:00', 1),
(782, 47, 'Biman_Bandar', '11:57:00', '12:00:00', 2),
(783, 47, 'Gaforgaon', '13:48:00', '13:50:00', 3),
(784, 47, 'Mymensingh', '14:38:00', '14:40:00', 4),
(785, 47, 'Narundi', '15:18:00', '15:20:00', 5),
(786, 47, 'Jamalpur_Town', '15:42:00', '15:44:00', 6),
(787, 47, 'Kendua_Bazar', '16:02:00', '16:04:00', 7),
(788, 47, 'Sarishabari', '16:35:00', '16:37:00', 8),
(789, 47, 'Tarakandi', '17:00:00', NULL, 9),
(793, 48, 'Dhaka', NULL, '07:30:00', 1),
(794, 48, 'Biman_Bandar', '07:58:00', '08:00:00', 2),
(795, 48, 'Joydebpur', '08:27:00', '08:28:00', 3),
(796, 48, 'Gaforgaon', '09:47:00', '09:50:00', 4),
(797, 48, 'Mymensingh', '10:35:00', '10:40:00', 5),
(798, 48, 'Piyarpur', '11:06:00', '11:07:00', 6),
(799, 48, 'Jamalpur_Town', '11:40:00', '11:42:00', 7),
(800, 48, 'Melandah_Bazar', '11:58:00', '12:00:00', 8),
(801, 48, 'Islampur_Bazar', '12:18:00', '12:20:00', 9),
(802, 48, 'Dewanganj_Bazar', '12:50:00', NULL, 10),
(803, 49, 'Dhaka', NULL, '22:45:00', 1),
(804, 49, 'Biman_Bandar', '23:13:00', '23:15:00', 2),
(805, 49, 'Joydebpur', '23:38:00', '23:40:00', 3),
(806, 49, 'Tangail', '00:34:00', '00:36:00', 4),
(807, 49, 'Ibrahimabad', '00:54:00', '00:58:00', 5),
(808, 49, 'SH M Monsur Ali', '01:13:00', '01:16:00', 6),
(809, 49, 'Ullapara', '01:33:00', '01:35:00', 7),
(810, 49, 'Boral_Bridge', '01:53:00', '01:55:00', 8),
(811, 49, 'Chatmohar', '02:09:00', '02:12:00', 9),
(812, 49, 'Ishwardi_Bypass', '02:32:00', '02:35:00', 10),
(813, 49, 'Abdulpur', '02:50:00', '02:52:00', 11),
(814, 49, 'Sardah_Road', '03:18:00', '03:20:00', 12),
(815, 49, 'Rajshahi', '04:02:00', NULL, 13),
(816, 50, 'Jamalpur_Town', NULL, '20:00:00', 1),
(817, 50, 'Piyarpur', '20:32:00', '20:34:00', 2),
(818, 50, 'Mymensingh', '21:35:00', '21:37:00', 3),
(819, 50, 'Gouripur_Myn', '22:20:00', '22:22:00', 4),
(820, 50, 'Atharabari', '22:46:00', '22:49:00', 5),
(821, 50, 'Kishorganj', '23:26:00', '23:28:00', 6),
(822, 50, 'Sararchar', '00:01:00', '00:03:00', 7),
(823, 50, 'Bhairab_Bazar', '00:35:00', '00:37:00', 8),
(824, 50, 'Akhaura', '01:25:00', '01:27:00', 9),
(825, 50, 'Cumilla', '02:10:00', '02:12:00', 10),
(826, 50, 'Laksam', '02:35:00', '02:37:00', 11),
(827, 50, 'Feni', '03:17:00', '03:19:00', 12),
(828, 50, 'Bhatiary', '04:28:00', '04:30:00', 13),
(829, 50, 'Chattogram', '05:02:00', NULL, 14),
(830, 51, 'Khulna', NULL, '06:45:00', 1),
(831, 51, 'Noapara', '07:21:00', '07:22:00', 2),
(832, 51, 'Jashore', '07:50:00', '07:53:00', 3),
(833, 51, 'Mubarakganj', '08:20:00', '08:22:00', 4),
(834, 51, 'Kotchandpur', '08:32:00', '08:35:00', 5),
(835, 51, 'Safdarpur', '08:42:00', '08:44:00', 6),
(836, 51, 'Darshana_Halt', '09:05:00', '09:07:00', 7),
(837, 51, 'Chuadanga', '09:28:00', '09:30:00', 8),
(838, 51, 'Alamdanga', '09:43:00', '09:46:00', 9),
(839, 51, 'Poradaha', '10:03:00', '10:05:00', 10),
(840, 51, 'Mirpur', '10:15:00', '10:17:00', 11),
(841, 51, 'Bheramara', '10:27:00', '10:29:00', 12),
(842, 51, 'Paksey', '10:40:00', '10:43:00', 13),
(843, 51, 'Iswardi', '11:10:00', '11:12:00', 14),
(844, 51, 'Azim Nagar', '11:25:00', '11:26:00', 15),
(845, 51, 'Abdulpur', '11:45:00', '11:47:00', 16),
(846, 51, 'Rajshahi', '12:20:00', NULL, 17),
(847, 52, 'Dhaka_Cant', NULL, '08:00:00', 1),
(848, 52, 'Gede', '13:30:00', '14:00:00', 15),
(849, 52, 'Kolkata', '16:32:00', NULL, 20),
(850, 53, 'Dhaka_Cant', NULL, '21:50:00', 1),
(851, 53, 'Chilahati', '05:45:00', '06:15:00', 10),
(852, 53, 'Haldibari', '06:30:00', '06:32:00', 20),
(853, 53, 'New Jalpaiguri', '07:15:00', NULL, 24),
(854, 54, 'Dhaka', NULL, '05:40:00', 1),
(855, 54, 'Tejgaon', '05:54:00', '05:56:00', 2),
(856, 54, 'Biman_Bandar', '06:12:00', '06:14:00', 3),
(857, 54, 'Tongi', '06:22:00', '06:24:00', 4),
(858, 54, 'Joydebpur', '06:47:00', '06:48:00', 5),
(859, 54, 'Shreepur', '07:18:00', '07:19:00', 6),
(860, 54, 'kauraid', '07:39:00', '07:40:00', 7),
(861, 54, 'Moshakhali', '07:52:00', '07:53:00', 8),
(862, 54, 'Gaforgaon', '08:06:00', '08:09:00', 9),
(863, 54, 'Mymensingh', '09:02:00', '09:05:00', 10),
(864, 54, 'Bidyaganj', '09:25:00', '09:26:00', 11),
(865, 54, 'Piyarpur', '09:37:00', '09:38:00', 12),
(866, 54, 'Narundi', '09:52:00', '09:54:00', 13),
(867, 54, 'Nandina', '10:06:00', '10:08:00', 14),
(868, 54, 'Jamalpur_Town', '10:25:00', '10:28:00', 15),
(869, 54, 'Melandah_Bazar', '10:42:00', '10:45:00', 16),
(870, 54, 'Durmuth', '10:57:00', '10:58:00', 17),
(871, 54, 'Islampur_Bypass', '11:07:00', '11:10:00', 18),
(872, 54, 'Dewanganj_Bazar', '11:40:00', NULL, 19),
(873, 55, 'Dhaka', NULL, '09:30:00', 1),
(874, 55, 'Biman_Bandar', '10:02:00', '10:04:00', 2),
(875, 55, 'Tongi', '10:12:00', '10:14:00', 3),
(876, 55, 'Narsingdi', '10:53:00', '10:54:00', 4),
(877, 55, 'Amirganj', '11:04:00', '11:05:00', 5),
(878, 55, 'Methikanda', '11:20:00', '11:21:00', 6),
(879, 55, 'Bhairab_Bazar', '11:40:00', '11:42:00', 7),
(880, 55, 'Ashuganj', '11:50:00', '11:51:00', 8),
(881, 55, 'Brahmanbaria', '12:10:00', NULL, 9),
(884, 57, 'Dhaka', NULL, '22:30:00', 1),
(885, 57, 'Dhaka_Cant', '22:52:00', '22:54:00', 2),
(886, 57, 'Biman_Bandar', '23:05:00', '23:07:00', 3),
(887, 57, 'Tongi', '23:18:00', '23:19:00', 4),
(888, 57, 'Narsingdi', '00:05:00', '00:07:00', 5),
(889, 57, 'Bhairab_Bazar', '00:57:00', '01:00:00', 6),
(890, 57, 'Ashuganj', '01:08:00', '01:09:00', 7),
(891, 57, 'Brahmanbaria', '01:28:00', '01:30:00', 8),
(892, 57, 'Akhaura', '02:43:00', '02:44:00', 9),
(893, 57, 'Cumilla', '04:07:00', '04:09:00', 10),
(894, 57, 'Laksam', '04:36:00', '04:38:00', 11),
(895, 57, 'Hasanpur', '05:00:00', '05:01:00', 12),
(896, 57, 'Feni', '05:28:00', '05:31:00', 13),
(897, 57, 'Shitakundu', '06:28:00', '06:30:00', 14),
(898, 57, 'Bhatiary', '06:57:00', '06:58:00', 15),
(899, 57, 'Pahartali', '07:10:00', '07:12:00', 16),
(900, 57, 'Chattogram', '07:25:00', NULL, 17),
(901, 58, 'Rajshahi', NULL, '21:00:00', 1),
(902, 58, 'Abdulpur', '21:40:00', '21:42:00', 2),
(903, 58, 'Natore', '22:17:00', '22:20:00', 3),
(904, 58, 'Madhnagar', '22:46:00', '22:48:00', 4),
(905, 58, 'Ahsanganj', '22:58:00', '23:00:00', 5),
(906, 58, 'Santahar', '23:21:00', '23:25:00', 6),
(907, 58, 'Akkelpur', '23:45:00', '23:47:00', 7),
(908, 58, 'Joypurhat', '00:02:00', '00:04:00', 8),
(909, 58, 'Panchbibi', '00:15:00', '00:17:00', 9),
(910, 58, 'Birampur', '00:38:00', '00:40:00', 10),
(911, 58, 'Fulbari', '00:58:00', '01:01:00', 11),
(912, 58, 'Parbatipur', '01:43:00', '01:45:00', 12),
(913, 58, 'Chirirbandar', '02:05:00', '02:07:00', 13),
(914, 58, 'Dinajpur', '02:28:00', '02:30:00', 14),
(915, 58, 'Setabaganj', '03:01:00', '03:03:00', 15),
(916, 58, 'Pirganj', '03:17:00', '03:19:00', 16),
(917, 58, 'Shibganj', '03:33:00', '03:36:00', 17),
(918, 58, 'Thakurgaon_Road', '03:43:00', '03:47:00', 18),
(919, 58, 'Ruhia', '04:02:00', '04:04:00', 19),
(920, 58, 'Kismat', '04:15:00', '04:17:00', 20),
(921, 58, 'Panchagarh', '04:40:00', NULL, 21);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `nid_number` varchar(20) DEFAULT NULL,
  `nid_image` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 0,
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `phone_number`, `nid_number`, `nid_image`, `email`, `password`, `role`, `balance`) VALUES
(1, 'admin', '69695654', NULL, NULL, 'admin@gmail.com', '$2y$10$TkM/Rt7AUv80ugS3A/RP/u3l8G/wPr.pOiRqD2zxvalMdgycH.lNC', 1, 0.00),
(2, 'user', '56454', NULL, NULL, 'user@gmail.com', '$2y$10$iL5XLSTlp75Z9cwWoAQflOfRjhEDc39xBeXXY5igZ3leAKGJRNxbS', 0, 0.00),
(4, 'Mir Tasrif', '0156+554', NULL, NULL, 'tasrif1@gmail.com', '$2y$10$huXEFNIh2KLUTabT5W7BCeTq2/eha72BnKS.F7I9pzoLbP6jxYCDi', 0, 0.00),
(5, 'Mir Tasrif', 'tasrif1@gmail.c', NULL, NULL, 'tasrif2@gmail.com', '$2y$10$AOtY4P1WzKWGC6fCyHBfG.5EdeHS5uZHpCyXe1yxOSJ7PcxKqk1I.', 0, 0.00),
(6, 'Mir Tasrif', 'tasrif2@gmail.c', NULL, NULL, 'tasrif3@gmail.com', '$2y$10$.TpmcHeclDzqR9qdYBkZ4.bdgJrCeFIDPywTa5.UJuqyIQmuoo35C', 0, 0.00),
(7, 'Mir Tasrif', '+8801968251126', NULL, NULL, 'tasrif5@gmail.com', '$2y$10$pqoKUZPAlFZkIBw54ksdiunK.l3qf3/bw53IHfV8qJdFq49OilGga', 0, 0.00),
(8, 'Mir Tasrif', '+8801968251129', '9116200248', 'nid_1752470939_2441.jpg', 'tasrif6@gmail.com', '$2y$10$gAVQcZglNRYerfGyaGIIOOLuIrXnasrG7R2GwVogM6RkcwxceXMKy', 0, 960.00),
(11, 'Abu Turaf', '01521111040', '3761440076', 'nid_1753034221_9511.jpg', 'abuturaf.mec2019@gmail.com', '$2y$10$VD3ILGqW6mR9LdjeHHNYOeCeExHn2FZZpxwehGlDsl/n8RIGDaudm', 0, 0.00),
(12, 'Mir Tasrif Ahmed', '01968251125', '2862911530', 'nid_1753074788_7216.png', 'mirtasrif9@gmail.com', '$2y$10$XyG9SVLEtdsbwX/8I2MFc.muIlFnRl1shQI.ytGIvxQ1uj34a2bHO', 0, 40.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `trains`
--
ALTER TABLE `trains`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `train_number` (`train_number`);

--
-- Indexes for table `train_stations`
--
ALTER TABLE `train_stations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `train_id` (`train_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nid_number` (`nid_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `trains`
--
ALTER TABLE `trains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `train_stations`
--
ALTER TABLE `train_stations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=922;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `train_stations`
--
ALTER TABLE `train_stations`
  ADD CONSTRAINT `train_stations_ibfk_1` FOREIGN KEY (`train_id`) REFERENCES `trains` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
