-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2024 at 03:55 PM
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
-- Database: `petadoption_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_adoption`
--

CREATE TABLE `tbl_adoption` (
  `ADOPTION_ID` int(11) NOT NULL,
  `PET_ID` int(11) NOT NULL,
  `CLIENT_ID` int(11) NOT NULL,
  `CLIENT_FNAME` varchar(255) NOT NULL,
  `CLIENT_MNAME` varchar(255) NOT NULL,
  `CLIENT_LNAME` varchar(255) NOT NULL,
  `ADOPTION_DATE` varchar(255) NOT NULL,
  `ADOPTION_FEE` varchar(255) NOT NULL,
  `MODE_OF_PAYMENT` varchar(255) NOT NULL,
  `ADOPTION_STATUS` varchar(255) NOT NULL,
  `CREATED_BY` varchar(255) NOT NULL,
  `MODIFIED_BY` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_breed`
--

CREATE TABLE `tbl_breed` (
  `BREED_ID` int(11) NOT NULL,
  `BREED_NAME` varchar(255) NOT NULL,
  `SPECIES_ID` int(11) NOT NULL,
  `CREATED_BY` varchar(255) NOT NULL,
  `MODIFIED_BY` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_breed`
--

INSERT INTO `tbl_breed` (`BREED_ID`, `BREED_NAME`, `SPECIES_ID`, `CREATED_BY`, `MODIFIED_BY`) VALUES
(1, 'American Shorthair', 1, 'vidafarala@gmail.com', 'llorenz@gmail.com'),
(2, 'Asian', 1, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(3, 'Australian Mist', 1, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(4, 'Bengal', 1, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(5, 'Bombay', 1, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(6, 'British Shorthair', 1, 'vidafarala08@gmail.com', 'vidafarala08@gmail.com'),
(7, 'Burmese', 1, 'vidafarala08@gmail.com', 'vidafarala08@gmail.com'),
(8, 'Burmilla', 1, 'vidafarala08@gmail.com', 'vidafarala08@gmail.com'),
(9, 'Cornish Rex', 1, 'vidafarala08@gmail.com', 'vidafarala08@gmail.com'),
(10, 'Devon Rex', 1, 'vidafarala08@gmail.com', 'vidafarala08@gmail.com'),
(11, 'Don Sphynx', 1, 'llorenz@gmail.com', 'llorenz@gmail.com'),
(12, 'Egyptian Mau', 1, 'llorenz@gmail.com', 'llorenz@gmail.com'),
(13, 'German Rex', 1, 'llorenz@gmail.com', 'llorenz@gmail.com'),
(14, 'Havana', 1, 'llorenz@gmail.com', 'llorenz@gmail.com'),
(15, 'Korat', 1, 'llorenz@gmail.com', 'llorenz@gmail.com'),
(16, 'Kurilian Bobtail', 1, 'llorenz@gmail.com', 'llorenz@gmail.com'),
(17, 'Manx', 1, 'llorenz@gmail.com', 'llorenz@gmail.com'),
(18, 'Ocicat', 1, 'fred@gmail.com', 'fred@gmail.com'),
(19, 'Oriental', 1, 'fred@gmail.com', 'fred@gmail.com'),
(20, 'Peterbald', 1, 'fred@gmail.com', 'fred@gmail.com'),
(21, 'Pixiebob', 1, 'fred@gmail.com', 'fred@gmail.com'),
(22, 'Russian', 1, 'fred@gmail.com', 'fred@gmail.com'),
(23, 'Siamese', 1, 'fred@gmail.com', 'fred@gmail.com'),
(24, 'Singapura', 1, 'fred@gmail.com', 'fred@gmail.com'),
(25, 'Snowshoe', 1, 'mikaela@gmail.com', 'mikaela@gmail.com'),
(26, 'Sokoke', 1, 'mikaela@gmail.com', 'mikaela@gmail.com'),
(27, 'Sphynx', 1, 'mikaela@gmail.com', 'mikaela@gmail.com'),
(28, 'Thai', 1, 'mikaela@gmail.com', 'mikaela@gmail.com'),
(29, 'Tonkinese', 1, 'mikaela@gmail.com', 'mikaela@gmail.com'),
(30, 'Abyssinian', 1, 'dexter@gmail.com', 'dexter@gmail.com'),
(31, 'Chartreux', 1, 'dexter@gmail.com', 'dexter@gmail.com'),
(32, 'Cymric', 1, 'dexter@gmail.com', 'dexter@gmail.com'),
(33, 'Exotic Shorthair', 1, 'dexter@gmail.com', 'dexter@gmail.com'),
(34, 'Japanese Bobtail', 1, 'dexter@gmail.com', 'dexter@gmail.com'),
(35, 'LaPerm', 1, 'dexter@gmail.com', 'dexter@gmail.com'),
(36, 'Maine Coon', 1, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(37, 'Neva Masquerade', 1, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(38, 'Norwegian Forest Cat', 1, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(39, 'RagaMuffin', 1, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(40, 'Ragdoll', 1, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(41, 'Sacred Birman', 1, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(42, 'Selkirk Rex', 1, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(43, 'Somali', 1, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(44, 'Turkish Angora', 1, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(45, 'Turkish Van', 1, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(46, 'Turkish Vankedisi', 1, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(47, 'Balinese', 1, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(48, 'British Longhair', 1, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(49, 'Persian', 1, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(50, 'Siberian', 1, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(51, 'Australian Silky Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(52, 'Bolognese', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(53, 'Chihuahua', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(54, 'Chihuahua Smooth Coat', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(55, 'Chinese Crested', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(56, 'Continental Toy Spaniel', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(57, 'English Toy Terrier Black & Tan', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(58, 'Japanese Chin', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(59, 'Maltese', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(60, 'Petit Brabancon', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(61, 'Pomeranian', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(62, 'Russian Toy', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(63, 'Yorkshire Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(64, 'Affenpinscher', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(65, 'Australian Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(66, 'Auvergne Pointer', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(67, 'Basset Fauve de Bretagne', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(68, 'Bedlington Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(69, 'Bichon Frise', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(70, 'Border Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(71, 'Boston Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(72, 'Brazilian Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(73, 'Bull Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(74, 'Cairn Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(75, 'Cavalier King Charles Spaniel', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(76, 'Cesky Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(77, 'Coton de Tulear', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(78, 'Dachshund', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(79, 'Dandie Dinmont Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(80, 'Danish-Swedish Farmdog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(81, 'Dutch Smoushond', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(82, 'Fox Terrier Smooth', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(83, 'Fox Terrier Wire', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(84, 'German Hunting Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(85, 'Griffon Belge', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(86, 'Griffon Bruxellois', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(87, 'Havanese', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(88, 'Italian Greyhound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(89, 'Jack Russell Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(90, 'Japanese Spitz', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(91, 'Japanese Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(92, 'King Charles Spaniel', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(93, 'Lakeland Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(94, 'Lhasa Apso', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(95, 'Lowchen (Little Lion Dog)', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(96, 'Manchester Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(97, 'Miniature Pinscher', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(98, 'Miniature Schnauzer', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(99, 'Mudi', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(100, 'Norfolk Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(101, 'Norwegian Lundehund', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(102, 'Norwich Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(103, 'Parson Russell Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(104, 'Pekingese', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(105, 'Pug', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(106, 'Pumi', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(107, 'Pyrenean Sheepdog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(108, 'Schipperke', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(109, 'Scottish Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(110, 'Sealyham Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(111, 'Shetland Sheepdog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(112, 'Shiba Inu', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(113, 'Shih Tzu', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(114, 'Skye Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(115, 'Swedish Vallhund-Vizigothic Spitz', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(116, 'Tibetan Spaniel', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(117, 'Welsh Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(118, 'West Highland White Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(119, 'Whippet', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(120, 'Airedale Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(121, 'Alaskan Malamute', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(122, 'Alpine Dachsbracke', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(123, 'American Cocker Spaniel', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(124, 'American Foxhound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(125, 'American Staffordshire Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(126, 'American Water Spaniel', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(127, 'Appenzell Cattle Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(128, 'Ariege Pointing Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(129, 'Ariegeois', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(130, 'Australian Kelpie', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(131, 'Australian Shepherd', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(132, 'Australian Stumpy Tail Cattle Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(133, 'Austrian Black and Tan Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(134, 'Barbet', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(135, 'Basenji', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(136, 'Basset Artesien Normand', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(137, 'Basset Bleu de Gascogne', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(138, 'Bavarian Mountain Scent Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(139, 'Beagle', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(140, 'Beagle Harrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(141, 'Bearded Collie', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(142, 'Belgian Shepherd Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(143, 'Bergamasco Shepherd Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(144, 'Blue Gascony Griffon', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(145, 'Blue Picardy Spaniel', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(146, 'Border Collie', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(147, 'Bosnian Broken-Haired Hound-called Barak', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(148, 'Bourbonnais Pointing Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(149, 'Bouvier Des Ardennes', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(150, 'Briquet Griffon Vendeen', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(151, 'Britanny Spaniel', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(152, 'Bulldog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(153, 'Canaan Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(154, 'Catalan Sheepdog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(155, 'Chow Chow', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(156, 'Cirneco Dell\'Etna', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(157, 'Coarse-Haired Styrian Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(158, 'Collie Rough', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(159, 'Collie Smooth', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(160, 'Croatian Shepherd Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(161, 'Doberman', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(162, 'Drever', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(163, 'Dutch Schapendoes', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(164, 'East Siberian Laika', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(165, 'English Cocker Spaniel', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(166, 'English Setter', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(167, 'English Springer Spaniel', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(168, 'Entlebuch Cattle Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(169, 'Eurasian', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(170, 'Fawn Britanny Griffon', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(171, 'Field Spaniel', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(172, 'Finnish Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(173, 'Finnish Lapponian Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(174, 'Finnish Spitz', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(175, 'French Bulldog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(176, 'French Pointing Dog - Pyrenean type', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(177, 'French Spaniel', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(178, 'Gascon Saintongeois', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(179, 'German Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(180, 'German Pinscher', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(181, 'German Spaniel', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(182, 'German Spitz', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(183, 'Grand Basset Griffon Vandeen', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(184, 'Griffon Nivernais', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(185, 'Halden Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(186, 'Hanoverian Scent Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(187, 'Harrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(188, 'Hellenic Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(189, 'Hokkaido', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(190, 'Hungarian Short-Haired Pointer (Vizsla)', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(191, 'Hygen Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(192, 'Ibizan Podenco', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(193, 'Icelandic Sheepdog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(194, 'Irish Glen of Imaal Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(195, 'Irish Red and White Setter', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(196, 'Irish Red Setter', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(197, 'Irish Soft Coated Wheaten Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(198, 'Irish Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(199, 'Irish Water Spaniel', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(200, 'Istrian Short-Haired Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(201, 'Istrian Wire-Haired Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(202, 'Italian Coarsehaired Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(203, 'Italian Short-Haired Segugio', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(204, 'Kai', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(205, 'Karelian Bear Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(206, 'Karst Shepherd Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(207, 'Kerry Blue Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(208, 'Kishu', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(209, 'Kleine Münsterländer', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(210, 'Kooikerhondje', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(211, 'Korean Jindo Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(212, 'Kromfohrländer', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(213, 'Lapponian Herder', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(214, 'Montenegrin Mountain Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(215, 'Norrbottenspitz', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(216, 'Norwegian Buhund', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(217, 'Norwegian Elkhound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(218, 'Norwegian Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(219, 'Nova Scotia Duck Tolling Retriever', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(220, 'Peruvian Inca Orchid', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(221, 'Petit Basset Griffon Vendeen', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(222, 'Picardy Shepherd', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(223, 'Polish Hunting Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(224, 'Polish Lowland Sheepdog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(225, 'Pont-Audemer Spaniel', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(226, 'Poodle', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(227, 'Porcelain', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(228, 'Portuguese Pointing Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(229, 'Portuguese Sheepdog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(230, 'Portuguese Water Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(231, 'Posavatz Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(232, 'Puli', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(233, 'Romagna Water Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(234, 'Russian-European Laika', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(235, 'Saint-Germain Pointer', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(236, 'Saluki', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(237, 'Samoyed', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(238, 'Schnauzer', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(239, 'Serbian Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(240, 'Serbian Tricolour Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(241, 'Shar-Pei', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(242, 'Shikoku', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(243, 'Siberian Husky', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(244, 'Sloughi', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(245, 'Slovakian Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(246, 'Small Blue Gascony', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(247, 'Small Swiss Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(248, 'Smålandsstövare', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(249, 'Spanish Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(250, 'Spanish Water Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(251, 'Stabijhoun', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(252, 'Staffordshire Bull Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(253, 'Sussex Spaniel', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(254, 'Swedish Lapphund', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(255, 'Swiss Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(256, 'Taiwan Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(257, 'Thai Ridgeback Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(258, 'Tibetan Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(259, 'Tyrolean Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(260, 'Welsh Corgi Cardigan', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(261, 'Welsh Corgi Pembroke', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(262, 'Welsh Springer Spaniel', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(263, 'West Siberian Laika', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(264, 'Westphalian Dachsbracke', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(265, 'Wire-Haired Pointing Griffon Korthals', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(266, 'Wirehaired Slovakian Pointer', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(267, 'Xoloitzcuintle', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(268, 'Medium-Sized Anglo-French Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(269, 'Afghan Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(270, 'Aidi', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(271, 'Akita', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(272, 'American Akita', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(273, 'Artois Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(274, 'Basset Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(275, 'Beauce Sheep Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(276, 'Billy', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(277, 'Black and Tan Coonhound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(278, 'Bloodhound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(279, 'Bohemian Wire-Haired Pointing Griffon', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(280, 'Borzoi', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(281, 'Bouvier des Flanders', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(282, 'Boxer', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(283, 'Braque Francais Gascogne-type', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(284, 'Briard', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(285, 'Burgos Pointing Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(286, 'Canarian Warren Hound - Podenco Canario', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(287, 'Cane Corso', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(288, 'Castro Laboreiro Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(289, 'Chesapeake Bay Retriever', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(290, 'Cimarrón Uruguayo', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(291, 'Clumber Spaniel', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(292, 'Curly Coated Retriever', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(293, 'Czechoslovakian Wolfdog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(294, 'Dalmatian', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(295, 'Deerhound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(296, 'Deutsch Stichelhaar', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(297, 'Dogo Argentino', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(298, 'Drentsche Partridge Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(299, 'Dutch Shepherd Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(300, 'English Foxhound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(301, 'English Pointer', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(302, 'Flat Coated Retriever', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(303, 'French Tricolour Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(304, 'French White and Black Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(305, 'French White and Orange Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(306, 'Frisian Water Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(307, 'German Long-Haired Pointing Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(308, 'German Shepherd', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(309, 'German Short-Haired Pointing Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(310, 'German Wire-Haired Pointing Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(311, 'Giant Schauzer', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(312, 'Golden Retriever', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(313, 'Gordon Setter', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(314, 'Grand Griffon Vendeen', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(315, 'Great Anglo-French Tricolour Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(316, 'Great Anglo-French White and Orange Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(317, 'Great Gascony Blue', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(318, 'Great Swiss Mountain Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(319, 'Greenland Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(320, 'Greyhound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(321, 'Hamiltonstövare', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(322, 'Hovawart', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(323, 'Hungarian Greyhound (Magyar Agar)', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(324, 'Hungarian Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(325, 'Hungarian Wire-Haired Pointer (Vizsla)', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(326, 'Italian Pointing Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(327, 'Komondor', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(328, 'Kuvasz', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(329, 'Labrador Retriever', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(330, 'Large Munsterlander', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(331, 'Majorca Mastiff', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(332, 'Majorca Shepherd Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(333, 'Maremma and the Abruzzes Sheepdog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(334, 'Old Danish Pointing Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(335, 'Old English Sheepdog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(336, 'Otterhound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(337, 'Pharaoh Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(338, 'Picardy Spaniel', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(339, 'Poitevin', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(340, 'Polish Hound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(341, 'Presa Canario', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(342, 'Pudelpointer', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(343, 'Rafeiro of Alentejo', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(344, 'Rhodesian Ridgeback', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(345, 'Romanian Carpathian Shepherd Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(346, 'Romanian Mioritic Shepherd Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(347, 'Russian Black Terrier', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(348, 'Saarloos Wolfhond', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(349, 'Saint Miguel Cattle Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(350, 'Slovakian Chuvach', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(351, 'Spanish Greyhound', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(352, 'Tatra Shepherd Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(353, 'Weimaraner', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(354, 'White Swiss Shepherd Dog', 2, 'vidafarala@gmail.com', 'vidafarala@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_client`
--

CREATE TABLE `tbl_client` (
  `CLIENT_ID` int(11) NOT NULL,
  `FIRST_NAME` varchar(255) NOT NULL,
  `MIDDLE_NAME` varchar(255) NOT NULL,
  `LAST_NAME` varchar(255) NOT NULL,
  `ROLE` varchar(255) NOT NULL,
  `PHONE_NUMBER` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `STREET` varchar(255) NOT NULL,
  `CITY` varchar(255) NOT NULL,
  `BARANGAY` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `SEX` varchar(255) NOT NULL,
  `AGE` int(11) NOT NULL,
  `DATE_OF_BIRTH` varchar(255) NOT NULL,
  `OCCUPATION` varchar(255) NOT NULL,
  `OWNED_PET` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_client`
--

INSERT INTO `tbl_client` (`CLIENT_ID`, `FIRST_NAME`, `MIDDLE_NAME`, `LAST_NAME`, `ROLE`, `PHONE_NUMBER`, `EMAIL`, `STREET`, `CITY`, `BARANGAY`, `PASSWORD`, `SEX`, `AGE`, `DATE_OF_BIRTH`, `OCCUPATION`, `OWNED_PET`) VALUES
(1, 'Paula Janna', 'Bryant', 'Farala', '2', '+633247293', 'vfarala@gmail.com', 'Pampam', 'SJDM', 'Hijadefrutas', '$2y$10$MsaDT/2id5qSpP7iHXKT5usbSWqdmFjtKVCjk99IGr0XKwD7icbLK', 'Female', 24, '1999-11-08', 'Game Developer', 'No'),
(2, 'JoeJoe', 'Marie', 'Siwa', '2', '+456789123', 'joejoe@gmail.com', 'Yabang', 'SJDM', 'Kapalmuks', '$2y$10$wA6.Ef0Z2jo9C3/wv2rEwuhpf4KkvF8xEDnf2zAiu9rvH5opJ5w.O', 'Male', 18, '2005-08-08', 'Tambay', 'Yes'),
(3, 'Maoi', 'Motunui', 'Madrid', '2', '+98765423456', 'xiaomaoggmon@gmail.com', 'Marlboro', 'Quezon City', 'Puregold', '$2y$10$sM.QAJ8pUu/RMbEl8yPd7OW/oeLvkBR1VHp2eFpp.Tey0GHc9FhWO', 'Female', 23, '2000-08-18', 'Game Designer', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pet`
--

CREATE TABLE `tbl_pet` (
  `PET_ID` int(11) NOT NULL,
  `PET_TYPE` varchar(255) NOT NULL,
  `FIRST_NAME` varchar(255) NOT NULL,
  `LAST_NAME` varchar(255) NOT NULL,
  `NICKNAME` varchar(255) NOT NULL,
  `SPECIES_ID` int(11) NOT NULL,
  `BREED_ID` int(11) NOT NULL,
  `AGE` int(11) NOT NULL,
  `WEIGHT` varchar(255) NOT NULL,
  `SEX` varchar(255) NOT NULL,
  `COLOR` varchar(255) NOT NULL,
  `SIZE` varchar(255) NOT NULL,
  `SHELTER_ID` int(11) NOT NULL,
  `CREATED_BY` varchar(255) NOT NULL,
  `MODIFIED_BY` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pet`
--

INSERT INTO `tbl_pet` (`PET_ID`, `PET_TYPE`, `FIRST_NAME`, `LAST_NAME`, `NICKNAME`, `SPECIES_ID`, `BREED_ID`, `AGE`, `WEIGHT`, `SEX`, `COLOR`, `SIZE`, `SHELTER_ID`, `CREATED_BY`, `MODIFIED_BY`) VALUES
(1, 'Rescue', 'Peanut', 'Farala', 'Pinat', 2, 113, 5, '7', 'Male', 'Brown', 'small', 1, 'vidafarala@gmail.com', 'llorenz@gmail.com'),
(2, 'Surrendered', 'Sebastian', 'Farala', 'Sebi', 2, 105, 5, '10', 'Male', 'Brown', 'small', 1, 'vidafarala@gmail.com', 'llorenz@gmail.com'),
(3, 'Rescue', 'Jake', 'Farala', 'Jake', 1, 2, 8, '25', 'Male', 'White', 'medium', 1, 'vidafarala@gmail.com', 'llorenz@gmail.com'),
(4, 'Surrendered', 'KitKat', 'Flores', 'KitKat', 2, 64, 3, '30', 'Female', 'White', 'medium', 1, 'vidafarala@gmail.com', 'llorenz@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_records`
--

CREATE TABLE `tbl_records` (
  `RECORD_ID` int(11) NOT NULL,
  `PET_ID` int(11) NOT NULL,
  `LAST_MED_EXAM` varchar(255) NOT NULL,
  `VACCINATION_STAT` varchar(255) NOT NULL,
  `MEDICATIONS` varchar(255) NOT NULL,
  `MEDICAL_NOTES` varchar(255) NOT NULL,
  `CREATED_BY` varchar(255) NOT NULL,
  `MODIFIED_BY` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_records`
--

INSERT INTO `tbl_records` (`RECORD_ID`, `PET_ID`, `LAST_MED_EXAM`, `VACCINATION_STAT`, `MEDICATIONS`, `MEDICAL_NOTES`, `CREATED_BY`, `MODIFIED_BY`) VALUES
(1, 1, '2024-02-29', 'Vaccinated', 'Enalapril', 'Has an enlarged heart. Take 1/2 tab of enalapril every night.', 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(2, 2, '2024-02-29', 'Vaccinated', 'None', 'None', 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(3, 3, '2010-12-25', 'Unvaccinated', 'None', 'None', 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(4, 5, '2024-03-05', 'Vaccinated', 'Biogesic', 'Chronic headaches', 'llorenz@gmail.com', 'llorenz@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shelter`
--

CREATE TABLE `tbl_shelter` (
  `SHELTER_ID` int(11) NOT NULL,
  `SHELTER_NAME` varchar(255) NOT NULL,
  `SHELTER_DESCRIPTION` varchar(255) NOT NULL,
  `PHONE_NUMBER` varchar(255) NOT NULL,
  `OPENING_HOUR` varchar(255) NOT NULL,
  `CLOSING_HOUR` varchar(255) NOT NULL,
  `STREET` varchar(255) NOT NULL,
  `CITY` varchar(255) NOT NULL,
  `BARANGAY` varchar(255) NOT NULL,
  `CREATED_BY` varchar(255) NOT NULL,
  `MODIFIED_BY` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_shelter`
--

INSERT INTO `tbl_shelter` (`SHELTER_ID`, `SHELTER_NAME`, `SHELTER_DESCRIPTION`, `PHONE_NUMBER`, `OPENING_HOUR`, `CLOSING_HOUR`, `STREET`, `CITY`, `BARANGAY`, `CREATED_BY`, `MODIFIED_BY`) VALUES
(1, 'Island of Motunui', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque egestas suscipit augue, eu blandit turpis ultricies ut. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed pulvinar accumsan purus, nec ornare diam egestas in. Proin rhon', '+12739126731', '07:19', '19:19', 'Silco Valley', 'Undercity', 'Piltover Arcane', 'vidafarala08@gmail.com', 'vidafarala@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_species`
--

CREATE TABLE `tbl_species` (
  `SPECIES_ID` int(11) NOT NULL,
  `SPECIES_NAME` varchar(255) NOT NULL,
  `CREATED_BY` varchar(255) NOT NULL,
  `MODIFIED_BY` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_species`
--

INSERT INTO `tbl_species` (`SPECIES_ID`, `SPECIES_NAME`, `CREATED_BY`, `MODIFIED_BY`) VALUES
(1, 'Cat', 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(2, 'Dog', 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(3, 'Bird', 'vidafarala@gmail.com', 'vidafarala@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

CREATE TABLE `tbl_staff` (
  `STAFF_ID` int(11) NOT NULL,
  `FIRST_NAME` varchar(255) NOT NULL,
  `MIDDLE_NAME` varchar(255) NOT NULL,
  `LAST_NAME` varchar(255) NOT NULL,
  `ROLE` varchar(255) NOT NULL,
  `PHONE_NUMBER` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `STREET` varchar(255) NOT NULL,
  `CITY` varchar(255) NOT NULL,
  `BARANGAY` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `SEX` varchar(255) NOT NULL,
  `AGE` int(11) NOT NULL,
  `DATE_OF_BIRTH` varchar(255) NOT NULL,
  `OCCUPATION` varchar(255) NOT NULL,
  `OWNED_PET` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_staff`
--

INSERT INTO `tbl_staff` (`STAFF_ID`, `FIRST_NAME`, `MIDDLE_NAME`, `LAST_NAME`, `ROLE`, `PHONE_NUMBER`, `EMAIL`, `STREET`, `CITY`, `BARANGAY`, `PASSWORD`, `SEX`, `AGE`, `DATE_OF_BIRTH`, `OCCUPATION`, `OWNED_PET`) VALUES
(1, 'Vida Moira', 'Robles', 'Farala', '1', '+63999999999', 'vidafarala@gmail.com', 'Yakal Street', 'Quezon City', 'North Fairview', '$2y$10$UuYeh4sFILDomrVOnNIin.jNOMGZvbBZtqeOZ.C4Ep5X/XUvZ6PMq', 'Female', 24, '1999-11-08', 'Student', 'Yes'),
(2, 'Llorenz', 'Pogi', 'Lazaro', '1', '+186472861', 'llorenz@gmail.com', 'Blumentritt', 'Manila', 'Diliman', '$2y$10$XnNk2./vekP0dOI6l4ToA.jTxHr6B0MPJ/x1oeI6IINlK886hSzbq', 'Male', 19, '2004-07-23', 'Student', 'Yes'),
(3, 'Frederick', 'Pogi', 'Colaja', '1', '+749861124', 'fred@gmail.com', 'Himala', 'Quezon City', 'Commonwealth', '$2y$10$Otc3MyTpYtKLhXldaR96.e/zVL1/GK.77zl9SpeOr0P15xldKoQPS', 'Male', 18, '2005-07-05', 'Student', 'No'),
(4, 'Mikaela', 'Maganda', 'Somera', '1', '+758974835', 'mikaela@gmail.com', 'Rosemary', 'Clark', 'Pampanga', '$2y$10$gTZ7uMeNEueHNdWrkPP13uZDSdWrayhn1Cpz7IxO1lTmc.89qhuvO', 'Female', 18, '2005-05-16', 'Student', 'Yes'),
(5, 'Dexter', 'Pogi', 'Cabubas', '1', '+73423463', 'dexter@gmail.com', 'Rizal', 'Quezon City', 'Eniwei', '$2y$10$IHq2ktM35FWXIPOcTyBE6.8e3C0YjYSnxT.mQL.ZBUd1M/eousEIO', 'Male', 18, '2005-04-01', 'Student', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction`
--

CREATE TABLE `tbl_transaction` (
  `TRANSACTION_ID` int(11) NOT NULL,
  `PET_ID` int(11) NOT NULL,
  `CLIENT_ID` int(11) NOT NULL,
  `CLIENT_FNAME` varchar(255) NOT NULL,
  `CLIENT_MNAME` varchar(255) NOT NULL,
  `CLIENT_LNAME` varchar(255) NOT NULL,
  `ADOPTION_DATE` varchar(255) NOT NULL,
  `ADOPTION_FEE` varchar(255) NOT NULL,
  `MODE_OF_PAYMENT` varchar(255) NOT NULL,
  `ADOPTION_STATUS` varchar(255) NOT NULL,
  `CREATED_BY` varchar(255) NOT NULL,
  `MODIFIED_BY` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_transaction`
--

INSERT INTO `tbl_transaction` (`TRANSACTION_ID`, `PET_ID`, `CLIENT_ID`, `CLIENT_FNAME`, `CLIENT_MNAME`, `CLIENT_LNAME`, `ADOPTION_DATE`, `ADOPTION_FEE`, `MODE_OF_PAYMENT`, `ADOPTION_STATUS`, `CREATED_BY`, `MODIFIED_BY`) VALUES
(1, 1, 1, 'Paula Janna', 'Bryant', 'Farala', '2024-03-04', '500', 'Cash', 'Rejected', 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(2, 2, 2, 'JoeJoe', 'Marie', 'Siwa', '2024-02-06', '1,000', 'Credit Card', 'Approved', 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(3, 1, 1, 'Paula Janna', 'Bryant', 'Farala', '2024-03-04', '1,000', 'Cash', 'Rejected', 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(4, 1, 1, 'Paula Janna', 'Bryant', 'Farala', '2024-03-04', '2,000', 'Debit Card', 'Approved', 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(5, 5, 3, 'Maoi', 'Motunui', 'Madrid', '2024-03-05', '20', 'Debit Card', 'Approved', 'llorenz@gmail.com', 'llorenz@gmail.com'),
(6, 3, 1, 'Paula Janna', 'Bryant', 'Batumbakal', '2024-03-11', '2,000', 'Credit Card', 'Approved', 'vidafarala@gmail.com', 'vidafarala@gmail.com'),
(7, 4, 3, 'Maoi', 'Motunui', 'Madrid', '2024-03-05', '500', 'Cash', 'Approved', 'vidafarala@gmail.com', 'vidafarala@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_volunteer`
--

CREATE TABLE `tbl_volunteer` (
  `VOLUNTEER_ID` int(11) NOT NULL,
  `FIRST_NAME` varchar(255) NOT NULL,
  `MIDDLE_NAME` varchar(255) NOT NULL,
  `LAST_NAME` varchar(255) NOT NULL,
  `ROLE` varchar(255) NOT NULL,
  `PHONE_NUMBER` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `STREET` varchar(255) NOT NULL,
  `CITY` varchar(255) NOT NULL,
  `BARANGAY` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `SEX` varchar(255) NOT NULL,
  `AGE` int(11) NOT NULL,
  `DATE_OF_BIRTH` varchar(255) NOT NULL,
  `OCCUPATION` varchar(255) NOT NULL,
  `OWNED_PET` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_volunteer`
--

INSERT INTO `tbl_volunteer` (`VOLUNTEER_ID`, `FIRST_NAME`, `MIDDLE_NAME`, `LAST_NAME`, `ROLE`, `PHONE_NUMBER`, `EMAIL`, `STREET`, `CITY`, `BARANGAY`, `PASSWORD`, `SEX`, `AGE`, `DATE_OF_BIRTH`, `OCCUPATION`, `OWNED_PET`) VALUES
(1, 'Moira', 'Dela Torre', 'Batumbakal', '3', '+5965723562', 'vidafarala08@gmail.com', 'Dao', 'Quezon City', 'Pasong Putik', '$2y$10$I9NY3zuDgKLqY1cat5upX.3iRg9b36irnhg5ZvWm.ozaVrEh9jptS', 'Female', 24, '1999-11-08', 'Software Engineer', 'Yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_adoption`
--
ALTER TABLE `tbl_adoption`
  ADD PRIMARY KEY (`ADOPTION_ID`);

--
-- Indexes for table `tbl_breed`
--
ALTER TABLE `tbl_breed`
  ADD PRIMARY KEY (`BREED_ID`);

--
-- Indexes for table `tbl_client`
--
ALTER TABLE `tbl_client`
  ADD PRIMARY KEY (`CLIENT_ID`);

--
-- Indexes for table `tbl_pet`
--
ALTER TABLE `tbl_pet`
  ADD PRIMARY KEY (`PET_ID`);

--
-- Indexes for table `tbl_records`
--
ALTER TABLE `tbl_records`
  ADD PRIMARY KEY (`RECORD_ID`);

--
-- Indexes for table `tbl_shelter`
--
ALTER TABLE `tbl_shelter`
  ADD PRIMARY KEY (`SHELTER_ID`);

--
-- Indexes for table `tbl_species`
--
ALTER TABLE `tbl_species`
  ADD PRIMARY KEY (`SPECIES_ID`);

--
-- Indexes for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD PRIMARY KEY (`STAFF_ID`);

--
-- Indexes for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD PRIMARY KEY (`TRANSACTION_ID`);

--
-- Indexes for table `tbl_volunteer`
--
ALTER TABLE `tbl_volunteer`
  ADD PRIMARY KEY (`VOLUNTEER_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_adoption`
--
ALTER TABLE `tbl_adoption`
  MODIFY `ADOPTION_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_breed`
--
ALTER TABLE `tbl_breed`
  MODIFY `BREED_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=356;

--
-- AUTO_INCREMENT for table `tbl_client`
--
ALTER TABLE `tbl_client`
  MODIFY `CLIENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_pet`
--
ALTER TABLE `tbl_pet`
  MODIFY `PET_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_records`
--
ALTER TABLE `tbl_records`
  MODIFY `RECORD_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_shelter`
--
ALTER TABLE `tbl_shelter`
  MODIFY `SHELTER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_species`
--
ALTER TABLE `tbl_species`
  MODIFY `SPECIES_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  MODIFY `STAFF_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  MODIFY `TRANSACTION_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_volunteer`
--
ALTER TABLE `tbl_volunteer`
  MODIFY `VOLUNTEER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
