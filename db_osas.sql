-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2025 at 09:03 AM
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
-- Database: `db_osas`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin_exam`
--

CREATE TABLE `tb_admin_exam` (
  `exam_Date` varchar(256) NOT NULL,
  `exam_DateCalendar` date NOT NULL,
  `exam_DateMeridiem` varchar(32) NOT NULL,
  `exam_Capacity` int(11) NOT NULL,
  `exam_Occupied` int(11) NOT NULL DEFAULT 0,
  `exam_Status` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin_exam`
--

INSERT INTO `tb_admin_exam` (`exam_Date`, `exam_DateCalendar`, `exam_DateMeridiem`, `exam_Capacity`, `exam_Occupied`, `exam_Status`) VALUES
('May 24, 2025 AM', '2025-05-24', 'AM', 5, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin_user`
--

CREATE TABLE `tb_admin_user` (
  `admin_ID` int(11) NOT NULL,
  `admin_Email` varchar(256) NOT NULL,
  `admin_Password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin_user`
--

INSERT INTO `tb_admin_user` (`admin_ID`, `admin_Email`, `admin_Password`) VALUES
(1, 'johnpatrick.skidmore@gmail.com', '$2y$10$P4AJu5B.LasWhRkvDnw86uB5tO9dQiI5Ncznhxc7MtbPhTVOkJAWq'),
(2, 'cj@gmail.com', '$2y$10$8IkwzjpqWGZZwuL3w/0MU.h2aIdDBRus6wtEIvpvW4uGv21uJ.XvO'),
(3, 'seb@gmail.com', '$2y$10$YHZqlqqDPvgfmAIvX.u/J.wlCP2HJpLIRlyxlyHW.ugGOYm9PNBsG');

-- --------------------------------------------------------

--
-- Table structure for table `tb_admission_control`
--

CREATE TABLE `tb_admission_control` (
  `admission_ControlNumber` int(5) NOT NULL,
  `admission_ID` int(11) NOT NULL,
  `admission_Appointment` varchar(128) DEFAULT NULL,
  `admission_Picture` varchar(64) DEFAULT NULL,
  `admission_Folder` varchar(64) DEFAULT NULL,
  `admission_Certificate` varchar(64) DEFAULT NULL,
  `admission_Exam` varchar(256) DEFAULT NULL,
  `admission_Result` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admission_control`
--

INSERT INTO `tb_admission_control` (`admission_ControlNumber`, `admission_ID`, `admission_Appointment`, `admission_Picture`, `admission_Folder`, `admission_Certificate`, `admission_Exam`, `admission_Result`) VALUES
(1, 36, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 9, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_admission_education`
--

CREATE TABLE `tb_admission_education` (
  `admission_ID` int(11) NOT NULL,
  `admission_ElementaryName` varchar(256) NOT NULL,
  `admission_ElementaryAddress` varchar(256) NOT NULL,
  `admission_ElementaryYear` smallint(4) NOT NULL,
  `admission_ElementaryType` enum('Public','Private') NOT NULL,
  `admission_HighschoolName` varchar(256) NOT NULL,
  `admission_HighschoolAddress` varchar(256) NOT NULL,
  `admission_HighschoolYear` smallint(4) NOT NULL,
  `admission_HighschoolType` enum('Public','Private') NOT NULL,
  `admission_SeniorName` varchar(256) DEFAULT NULL,
  `admission_SeniorAddress` varchar(256) DEFAULT NULL,
  `admission_SeniorYear` smallint(4) DEFAULT NULL,
  `admission_SeniorType` enum('Public','Private') DEFAULT NULL,
  `admission_VocationalName` varchar(256) DEFAULT NULL,
  `admission_VocationalAddress` varchar(256) DEFAULT NULL,
  `admission_VocationalYear` smallint(4) DEFAULT NULL,
  `admission_VocationalType` enum('Public','Private') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admission_education`
--

INSERT INTO `tb_admission_education` (`admission_ID`, `admission_ElementaryName`, `admission_ElementaryAddress`, `admission_ElementaryYear`, `admission_ElementaryType`, `admission_HighschoolName`, `admission_HighschoolAddress`, `admission_HighschoolYear`, `admission_HighschoolType`, `admission_SeniorName`, `admission_SeniorAddress`, `admission_SeniorYear`, `admission_SeniorType`, `admission_VocationalName`, `admission_VocationalAddress`, `admission_VocationalYear`, `admission_VocationalType`) VALUES
(1, 'Elementary', 'Address', 2017, 'Public', 'Highschool', 'Address', 2021, 'Public', 'Senior', 'Address', 2023, NULL, NULL, NULL, NULL, NULL),
(5, 'Elementary', 'Address', 2017, 'Public', 'Highschool', 'Address', 2021, 'Public', 'Senior', 'Address', 2023, NULL, NULL, NULL, NULL, NULL),
(9, 'Parklane Elementary School', '8WR9+798, San Francisco, General Trias, Cavite', 2017, 'Public', 'Francisco E. Barzaga Integrated High School', '8WJM+MJ6, Dasmarinas City, Cavite', 2021, 'Public', 'Emilio Aguinaldo College - Cavite', '8WGW+J9M, Congressional East Ave, Burol Main, Dasmarinas City, Cavite', 2023, 'Private', NULL, NULL, NULL, NULL),
(10, 'Elementary', 'Address', 2017, 'Public', 'Highschool', 'Address', 2021, 'Public', 'Senior', 'Address', 2023, NULL, NULL, NULL, NULL, NULL),
(14, 'Elementary', 'Address', 2017, 'Public', 'Highschool', 'Address', 2021, 'Public', 'Senior', 'Address', 2023, NULL, NULL, NULL, NULL, NULL),
(24, 'Elementary', 'Address', 2017, 'Public', 'Highschool', 'Address', 2021, 'Public', 'Senior', 'Address', 2023, NULL, NULL, NULL, NULL, NULL),
(31, 'Elementary', 'Address', 2017, 'Public', 'Highschool', 'Address', 2021, 'Public', 'Senior', 'Address', 2023, NULL, NULL, NULL, NULL, NULL),
(36, 'Pintong Gubat Elementary School', '8XCM+RQ4, Paliparan Rd, Dasmariñas, Cavite', 2017, 'Public', 'Paliparan II Integrated High School', '8X3V+686, Paliparan 2, Dasmariñas, 4114 Cavite', 2021, 'Public', 'Philippine Christian University - Dasmarinas', '7XV6+3X2, Aguinaldo Hwy, Dasmariñas, 4114 Cavite', 2023, 'Private', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_admission_family`
--

CREATE TABLE `tb_admission_family` (
  `admission_ID` int(11) NOT NULL,
  `admission_FatherName` varchar(256) DEFAULT NULL,
  `admission_FatherNumber` bigint(16) DEFAULT NULL,
  `admission_FatherOccupation` varchar(256) DEFAULT NULL,
  `admission_MotherName` varchar(256) DEFAULT NULL,
  `admission_MotherNumber` bigint(16) DEFAULT NULL,
  `admission_MotherOccupation` varchar(256) DEFAULT NULL,
  `admission_Income` varchar(256) NOT NULL,
  `admission_Siblings` int(11) DEFAULT NULL,
  `admission_BirthOrder` varchar(64) DEFAULT NULL,
  `admission_GuardianName` varchar(256) NOT NULL,
  `admission_GuardianNumber` bigint(16) NOT NULL,
  `admission_GuardianOccupation` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admission_family`
--

INSERT INTO `tb_admission_family` (`admission_ID`, `admission_FatherName`, `admission_FatherNumber`, `admission_FatherOccupation`, `admission_MotherName`, `admission_MotherNumber`, `admission_MotherOccupation`, `admission_Income`, `admission_Siblings`, `admission_BirthOrder`, `admission_GuardianName`, `admission_GuardianNumber`, `admission_GuardianOccupation`) VALUES
(1, 'Father', 9932022572, NULL, 'Mother', 9911285549, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9960360032, ''),
(2, 'Father', 9967943518, NULL, 'Mother', 9958637497, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9989356933, ''),
(3, 'Father', 9970872178, NULL, 'Mother', 9986290093, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9918833937, ''),
(4, 'Father', 9935299410, NULL, 'Mother', 9919995241, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9994077978, ''),
(5, 'Father', 9910404170, NULL, 'Mother', 9969786921, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9917722096, ''),
(6, 'Father', 9979249723, NULL, 'Mother', 9943082330, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9977662483, ''),
(7, 'Father', 9959065430, NULL, 'Mother', 9962339703, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9934502228, ''),
(8, 'Father', 9985492036, NULL, 'Mother', 9923953497, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9963291383, ''),
(9, 'Symon De Jesus', 9958723566, 'Rider', 'Rosalyn De Jesus', 9958723566, NULL, '21,000-30,000', 1, 'Eldest', 'Jose De Jesus', 9958723566, 'Driver'),
(10, 'Father', 9944596427, NULL, 'Mother', 9933107991, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9931750678, ''),
(11, 'Father', 9959429420, NULL, 'Mother', 9901895067, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9931187081, ''),
(12, 'Father', 9950250208, NULL, 'Mother', 9957689800, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9937698379, ''),
(13, 'Father', 9915422500, NULL, 'Mother', 9964017366, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9973819333, ''),
(14, 'Father', 9977044569, NULL, 'Mother', 9963764852, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9987690554, ''),
(15, 'Father', 9947158220, NULL, 'Mother', 9972719442, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9922122552, ''),
(16, 'Father', 9992454437, NULL, 'Mother', 9995904532, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9902159353, ''),
(17, 'Father', 9923083172, NULL, 'Mother', 9908937806, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9975439518, ''),
(18, 'Father', 9950384177, NULL, 'Mother', 9925602332, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9976859135, ''),
(19, 'Father', 9907488680, NULL, 'Mother', 9906865999, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9911863960, ''),
(20, 'Father', 9938721808, NULL, 'Mother', 9958017162, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9973920389, ''),
(21, 'Father', 9995550463, NULL, 'Mother', 9955991154, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9993304382, ''),
(22, 'Father', 9998548451, NULL, 'Mother', 9912829112, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9968500213, ''),
(23, 'Father', 9904013731, NULL, 'Mother', 9914568022, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9960798919, ''),
(24, 'Father', 9960290534, NULL, 'Mother', 9919055918, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9914407988, ''),
(25, 'Father', 9914872191, NULL, 'Mother', 9931136995, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9911068406, ''),
(26, 'Father', 9961931050, NULL, 'Mother', 9976450033, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9996457020, ''),
(27, 'Father', 9952935004, NULL, 'Mother', 9975303966, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9917714818, ''),
(28, 'Father', 9962662197, NULL, 'Mother', 9960166536, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9912846091, ''),
(29, 'Father', 9983730850, NULL, 'Mother', 9980115982, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9949387362, ''),
(30, 'Father', 9906588869, NULL, 'Mother', 9984782263, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9904144713, ''),
(31, 'Father', 9966376778, NULL, 'Mother', 9919449756, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9998118451, ''),
(32, 'Father', 9932242987, NULL, 'Mother', 9966859589, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9937568984, ''),
(33, 'Father', 9987266160, NULL, 'Mother', 9923623850, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9956320775, ''),
(34, 'Father', 9910732329, NULL, 'Mother', 9984699323, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9991299631, ''),
(35, 'Father', 9902400189, NULL, 'Mother', 9938102057, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9983309720, ''),
(36, 'Joseph Bosul Skidmore', 9178354163, 'Sales Agent', 'Erly Enraca Skidmore', 9472902443, 'Housewife', '11,000-20,000', 1, 'Eldest', 'Erly Enraca Skidmore', 9472902443, 'Housewife'),
(37, 'Father', 9902242433, NULL, 'Mother', 9961283007, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9999687741, ''),
(38, 'Father', 9914589687, NULL, 'Mother', 9973885214, NULL, '11,000-20,000', 1, 'Eldest', 'Guardian', 9925657016, '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_admission_info`
--

CREATE TABLE `tb_admission_info` (
  `admission_ID` int(11) NOT NULL,
  `admission_Branch` varchar(32) DEFAULT NULL,
  `admission_Entry` varchar(32) DEFAULT NULL,
  `admission_TypeApplicant` varchar(32) DEFAULT NULL,
  `admission_Strand` varchar(16) DEFAULT NULL,
  `admission_TypeStudent` varchar(32) DEFAULT NULL,
  `admission_LRN` bigint(16) DEFAULT NULL,
  `admission_Program` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admission_info`
--

INSERT INTO `tb_admission_info` (`admission_ID`, `admission_Branch`, `admission_Entry`, `admission_TypeApplicant`, `admission_Strand`, `admission_TypeStudent`, `admission_LRN`, `admission_Program`) VALUES
(1, 'Silang', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'Silang', 'New', 'Filipino', 'TVL-ICT', 'SHS', 107963100122, 'BSCS'),
(36, 'Silang', 'New', 'Filipino', 'STEM', 'GR12', 107923130246, 'BSCS');

-- --------------------------------------------------------

--
-- Table structure for table `tb_admission_medical`
--

CREATE TABLE `tb_admission_medical` (
  `admission_ID` int(11) NOT NULL,
  `admission_Medication` varchar(512) DEFAULT NULL,
  `admission_Allergy` varchar(64) DEFAULT NULL,
  `admission_Scoliosis` varchar(64) DEFAULT NULL,
  `admission_Asthma` varchar(64) DEFAULT NULL,
  `admission_Hypertension` varchar(64) DEFAULT NULL,
  `admission_Diabetes` varchar(64) DEFAULT NULL,
  `admission_Insomnia` varchar(64) DEFAULT NULL,
  `admission_Vertigo` varchar(64) DEFAULT NULL,
  `admission_Others` varchar(2048) DEFAULT NULL,
  `admission_PWD` enum('Yes','No') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admission_medical`
--

INSERT INTO `tb_admission_medical` (`admission_ID`, `admission_Medication`, `admission_Allergy`, `admission_Scoliosis`, `admission_Asthma`, `admission_Hypertension`, `admission_Diabetes`, `admission_Insomnia`, `admission_Vertigo`, `admission_Others`, `admission_PWD`) VALUES
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes'),
(4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes'),
(7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes'),
(9, NULL, 'Yes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No'),
(11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes'),
(13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes'),
(17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes'),
(19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes'),
(22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes'),
(27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes'),
(30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes'),
(34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes'),
(36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No'),
(38, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tb_admission_personal`
--

CREATE TABLE `tb_admission_personal` (
  `admission_ID` int(11) NOT NULL,
  `admission_FirstName` varchar(256) NOT NULL,
  `admission_MiddleName` varchar(256) DEFAULT NULL,
  `admission_LastName` varchar(256) NOT NULL,
  `admission_Suffix` varchar(16) DEFAULT NULL,
  `admission_Region` varchar(64) DEFAULT NULL,
  `admission_Province` varchar(64) DEFAULT NULL,
  `admission_ContactNumber` bigint(16) NOT NULL,
  `admission_LandlineNumber` bigint(16) DEFAULT NULL,
  `admission_CivilStatus` enum('Single','Married','Divorced','Separated','Widowed') NOT NULL,
  `admission_Sex` enum('Male','Female') NOT NULL,
  `admission_BirthDate` date NOT NULL,
  `admission_BirthPlace` varchar(64) NOT NULL,
  `admission_Religion` varchar(64) DEFAULT NULL,
  `admission_Indigenous` enum('Yes','No') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admission_personal`
--

INSERT INTO `tb_admission_personal` (`admission_ID`, `admission_FirstName`, `admission_MiddleName`, `admission_LastName`, `admission_Suffix`, `admission_Region`, `admission_Province`, `admission_ContactNumber`, `admission_LandlineNumber`, `admission_CivilStatus`, `admission_Sex`, `admission_BirthDate`, `admission_BirthPlace`, `admission_Religion`, `admission_Indigenous`) VALUES
(1, '', NULL, '', NULL, 'IV_A', 'Cavite', 9965733045, NULL, 'Single', 'Male', '2004-07-25', '', NULL, 'No'),
(2, '', NULL, '', NULL, 'IV_A', 'Cavite', 9996697222, NULL, 'Single', 'Male', '2003-11-25', '', NULL, 'No'),
(3, '', NULL, '', NULL, 'IV_A', 'Cavite', 9986286981, NULL, 'Single', 'Male', '2005-10-17', '', NULL, 'No'),
(4, '', NULL, '', NULL, 'IV_A', 'Cavite', 9941343241, NULL, 'Single', 'Male', '2005-04-11', '', NULL, 'No'),
(5, '', NULL, '', NULL, 'IV_A', 'Cavite', 9947855266, NULL, 'Single', 'Male', '2005-12-30', '', NULL, 'No'),
(6, '', NULL, '', NULL, 'IV_A', 'Cavite', 9915246609, NULL, 'Single', 'Male', '2005-03-02', '', NULL, 'No'),
(7, '', NULL, '', NULL, 'IV_A', 'Cavite', 9932667254, NULL, 'Single', 'Male', '2004-11-02', '', NULL, 'No'),
(8, '', NULL, '', NULL, 'IV_A', 'Cavite', 9917596444, NULL, 'Single', 'Male', '2005-09-09', '', NULL, 'No'),
(9, 'Sebastiene Rhodney', 'Silva', 'De Jesus', NULL, 'IV_A', 'Cavite', 9958723566, NULL, 'Single', 'Male', '2004-12-04', 'Pasay, Manila', 'Roman Catholic', 'No'),
(10, '', NULL, '', NULL, 'IV_A', 'Cavite', 9989980463, NULL, 'Single', 'Male', '2004-12-09', '', NULL, 'No'),
(11, '', NULL, '', NULL, 'IV_A', 'Cavite', 9997112986, NULL, 'Single', 'Male', '2004-08-16', '', NULL, 'No'),
(12, '', NULL, '', NULL, 'IV_A', 'Cavite', 9915623546, NULL, 'Single', 'Male', '2005-04-24', '', NULL, 'No'),
(13, '', NULL, '', NULL, 'IV_A', 'Cavite', 9986778776, NULL, 'Single', 'Male', '2003-09-10', '', NULL, 'No'),
(14, '', NULL, '', NULL, 'IV_A', 'Cavite', 9987023245, NULL, 'Single', 'Male', '2005-07-07', '', NULL, 'No'),
(15, '', NULL, '', NULL, 'IV_A', 'Cavite', 9974779902, NULL, 'Single', 'Male', '2004-07-03', '', NULL, 'No'),
(16, '', NULL, '', NULL, 'IV_A', 'Cavite', 9912829779, NULL, 'Single', 'Male', '2005-12-22', '', NULL, 'No'),
(17, '', NULL, '', NULL, 'IV_A', 'Cavite', 9939809193, NULL, 'Single', 'Male', '2004-05-14', '', NULL, 'No'),
(18, '', NULL, '', NULL, 'IV_A', 'Cavite', 9960556628, NULL, 'Single', 'Male', '2003-12-01', '', NULL, 'No'),
(19, '', NULL, '', NULL, 'IV_A', 'Cavite', 9983355568, NULL, 'Single', 'Male', '2003-06-24', '', NULL, 'No'),
(20, '', NULL, '', NULL, 'IV_A', 'Cavite', 9935107960, NULL, 'Single', 'Male', '2005-08-22', '', NULL, 'No'),
(21, '', NULL, '', NULL, 'IV_A', 'Cavite', 9925473099, NULL, 'Single', 'Male', '2005-10-09', '', NULL, 'No'),
(22, '', NULL, '', NULL, 'IV_A', 'Cavite', 9922041617, NULL, 'Single', 'Male', '2005-12-11', '', NULL, 'No'),
(23, '', NULL, '', NULL, 'IV_A', 'Cavite', 9933788794, NULL, 'Single', 'Male', '2003-05-29', '', NULL, 'No'),
(24, '', NULL, '', NULL, 'IV_A', 'Cavite', 9902819122, NULL, 'Single', 'Male', '2005-03-10', '', NULL, 'No'),
(25, '', NULL, '', NULL, 'IV_A', 'Cavite', 9912729232, NULL, 'Single', 'Male', '2003-09-26', '', NULL, 'No'),
(26, '', NULL, '', NULL, 'IV_A', 'Cavite', 9955188798, NULL, 'Single', 'Male', '2003-02-10', '', NULL, 'No'),
(27, '', NULL, '', NULL, 'IV_A', 'Cavite', 9937756298, NULL, 'Single', 'Male', '2004-05-04', '', NULL, 'No'),
(28, '', NULL, '', NULL, 'IV_A', 'Cavite', 9923215097, NULL, 'Single', 'Male', '2003-05-18', '', NULL, 'No'),
(29, '', NULL, '', NULL, 'IV_A', 'Cavite', 9902806597, NULL, 'Single', 'Male', '2003-11-10', '', NULL, 'No'),
(30, '', NULL, '', NULL, 'IV_A', 'Cavite', 9944387697, NULL, 'Single', 'Male', '2003-03-01', '', NULL, 'No'),
(31, '', NULL, '', NULL, 'IV_A', 'Cavite', 9913518696, NULL, 'Single', 'Male', '2004-03-28', '', NULL, 'No'),
(32, '', NULL, '', NULL, 'IV_A', 'Cavite', 9934430394, NULL, 'Single', 'Male', '2005-09-17', '', NULL, 'No'),
(33, '', NULL, '', NULL, 'IV_A', 'Cavite', 9931595885, NULL, 'Single', 'Male', '2003-11-06', '', NULL, 'No'),
(34, '', NULL, '', NULL, 'IV_A', 'Cavite', 9954688245, NULL, 'Single', 'Male', '2005-02-06', '', NULL, 'No'),
(35, '', NULL, '', NULL, 'IV_A', 'Cavite', 9978653576, NULL, 'Single', 'Male', '2004-12-19', '', NULL, 'No'),
(36, 'John Patrick', 'Enraca', 'Skidmore', NULL, 'IV_A', 'Cavite', 9918285766, NULL, 'Single', 'Male', '2005-11-23', 'Trece Martires', 'Roman Catholic', 'No'),
(37, '', NULL, '', NULL, 'IV_A', 'Cavite', 9929203146, NULL, 'Single', 'Male', '2003-07-15', '', NULL, 'No'),
(38, '', NULL, '', NULL, 'IV_A', 'Cavite', 9910055005, NULL, 'Single', 'Male', '2005-10-07', '', NULL, 'No');

-- --------------------------------------------------------

--
-- Table structure for table `tb_admission_user`
--

CREATE TABLE `tb_admission_user` (
  `admission_ID` int(11) NOT NULL,
  `admission_Email` varchar(255) NOT NULL,
  `admission_Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admission_user`
--

INSERT INTO `tb_admission_user` (`admission_ID`, `admission_Email`, `admission_Password`) VALUES
(1, 'jamal.abdulla@gmail.com', '$2y$10$8vwrFngWJ.3mv.K1UnGVdOTsSLI02ktH146yqyIzyeBBT5FX9/wU6'),
(2, 'rainerjack.altaraz@gmail.com', '$2y$10$Y/xAvfKFjUJAMonXAwUvt.qS0JMEGevo6zryMFJlqDd8cgo7/Hk.K'),
(3, 'carljoshua.cadungog@gmail.com', '$2y$10$x/HxN4gAF3WSPOdExn.vw.Ejq69Y6UB22/vWyPuSSQKgvVB56tgQi'),
(4, 'drixenpaul.calzado@gmail.com', '$2y$10$lzNM/y/Gj129bKCr0IVmVu9zyHkphFpy21yWdJsaxdGCCyhum6JPa'),
(5, 'marilyn.cantada@gmail.com', '$2y$10$8EbliNa1S510jrpuY7ADEuVBOd9wSOu3ABmKuj5QiaDaTcb/2ru1G'),
(6, 'erikamae.caraan@gmail.com', '$2y$10$N72AYiC1.Vc4MH29M8kN/euE8QK/Mzpm0MgrZYBHvUonx1pqk5v4u'),
(7, 'zedrickdenzel.claridad@gmail.com', '$2y$10$yGyNh/CqPmm9WaiBjgFlD.zEISpYwxkewVT.Vw15t.XFElWj1HoH.'),
(8, 'kentraven.deleon@gmail.com', '$2y$10$rJOZ.xVfp5hd4cy4gqJD9.bqcIoxr1zQ.l/lnyUY.VgurSNT1B0JG'),
(9, 'sebestienerhodney.dejesus@gmail.com', '$2y$10$92XNZ8kgRukMZ/.8gQqVe.Zw1lQMr2NlzjBxKR0llbTGzL95ui3A.'),
(10, 'jasmin.ebon@gmail.com', '$2y$10$5zjpRjDI403YtR6nQsA0aeSOxWPKkdVjzdQAsnLQUxpwgEIJm6Lk6'),
(11, 'christine.ermino@gmail.com', '$2y$10$Bg3l61DX5Lkni0HU2ZXf/u808TlaY8bH4.ONnN1uO4ifBsBvoKmNO'),
(12, 'charlesaldrin.galon@gmail.com', '$2y$10$SDeIpuNlwKKA.l4rzuTxCOZwsr5LjoZqErfnF7uAUnA0.eXdXeFsG'),
(13, 'kaishaun.gonzaga@gmail.com', '$2y$10$zvqwd9WdCYPo4wDai0aFwe5IYdOxLpeVX.1q9MjmCY8u//6TYNdUK'),
(14, 'ivan.joson@gmail.com', '$2y$10$FUsj/U5YWSP2pMBpuVONKelHzeH74wYbYgSuVAJZhC0nsVznB/W.e'),
(15, 'tairadanielle.julia@gmail.com', '$2y$10$WCPXoIkUYFvNU8HNMhIV7.OYVUQ3Lik2OuUK/8kOy3Gz0LYd7kqdu'),
(16, 'krysteljoy.kapangyarihan@gmail.com', '$2y$10$sxreUdCs68nCrpTZ.jtU5Oi/AIOkBGsnviLK3s40.xbWtCxf6rJO2'),
(17, 'anyahermione.loyola@gmail.com', '$2y$10$kmmnDLb8nsThgZX/MusF.O.myEoWf67S3Ux8ywUMUGfa5xKn3DyQS'),
(18, 'christianjames.maano@gmail.com', '$2y$10$Yqs9RNgtJeqaTaEgwrm07e9Qz2rvjq6xhqf6TqDezVtvEKjAKzPN6'),
(19, 'markariel.macawili@gmail.com', '$2y$10$YFVudH4qWI7J9GQLSeQQAesc/yGAO9KnaspABlbzzgzRZY6vxdBaK'),
(20, 'kurtkevin.mallari@gmail.com', '$2y$10$ZbpYpXAN1oBddFhYnQMz3eF0krbsYOoyiWE8Z4.EZle8VwbnF2Lq.'),
(21, 'joshua.mamorno@gmail.com', '$2y$10$KAA3m/CW4bylhEVlEZSpqONDHDrBDUzaoK1bLStOYk0AZwfjN9QHa'),
(22, 'lovedivine.manzano@gmail.com', '$2y$10$5eQL53KUnIW0nZXaEEPkM.uRTPd58dJS1nKTLepPax8iTARyqySVq'),
(23, 'francisjoshua.mapanoo@gmail.com', '$2y$10$.sDQOVzcsRdGUNx2.6KJ9eBOORX6Nsa2cFJXGhnv/L3RK13k6xTq6'),
(24, 'markjason.mendoza@gmail.com', '$2y$10$bZkw1xhRF5soVmx.KpxFHOPV4O7Uj52eMQXXL5Mp8EW4wMtXY3ag.'),
(25, 'ralphchryslerjohn.mendoza@gmail.com', '$2y$10$Zdbc6KgZii/ocpyAVuBa0e5GC9Knt6.YQJ4Olojew24LxRFUYAwNy'),
(26, 'mikejester.miano@gmail.com', '$2y$10$WjKDeQpTd5GyLexvW13nJOiOYI8QzxLKzVjsY/wi0RJSa0eNmS8oC'),
(27, 'johncarlo.montemayor@gmail.com', '$2y$10$oCruSa6vp/Eb6nq.rcDrd.VB8picR4Q84rL8sWtod2BQYnZoIOQpa'),
(28, 'ronaldtyrone.pangilinan@gmail.com', '$2y$10$CepSiOy.Q1OapvnX26larewlLLyJhQTrcB7mnI/CmUynVnc6fhJLC'),
(29, 'markaljon.pilar@gmail.com', '$2y$10$/6iThkSLOHzOWd6MJmHNXeX3wvFia3Cb1K1iVkm8bMlpynQvMJXdO'),
(30, 'johncena.piquero@gmail.com', '$2y$10$.9aktQHcbdRTdnPn6oNq8u8ikpaP2zjgQAhDkaJs1BmM3ERv1a4qm'),
(31, 'freddieboy.poblete@gmail.com', '$2y$10$YzQIg2anhcZ2NsdR/idY8eYvPJbcneuBoLahLlyDCEvDg0nXNwZPC'),
(32, 'christianjay.ramos@gmail.com', '$2y$10$2NivbEGvmCXB5TUtcI71GeVXspGeb2xjhgdLfQp2ccg33bov4iRU.'),
(33, 'mikhaelajoline.ramos@gmail.com', '$2y$10$Np3UuiQLiYyXXpxVeSeGiO19tulbZlGNvqG8rMD1HoNruRnjb39ku'),
(34, 'divinevalerie.reyes@gmail.com', '$2y$10$3nU.4iTz.xM2MhfgRjLmzOlAoRYVM85g/B4O2FB1vrvb3e2ofTNQO'),
(35, 'daveulrich.santos@gmail.com', '$2y$10$iUd8nVYtUOrpolD3tr7HduSH7AXofWOpLkN9vfTMmrgEAbI3j7.AS'),
(36, 'johnpatrick.skidmore@gmail.com', '$2y$10$o5M5Knkw1lHyrMEmUBHU7.uLnWp4de5hr60bhVGJeJtcAOXJK7mrq'),
(37, 'ghia.tabago@gmail.com', '$2y$10$6s./Kd8lsk0QqALHn9Kz8.N71VkjXu4P99NSNsVVXZbXIKpvrkDVS'),
(38, 'cedrick.toledana@gmail.com', '$2y$10$vP6aAWKYRzl5EnUMlCohGO6G1AnlumOf0cMJ2hPhEl3mbhbkjqB4.');

-- --------------------------------------------------------

--
-- Table structure for table `tb_event`
--

CREATE TABLE `tb_event` (
  `event_ID` int(11) NOT NULL,
  `event_Name` varchar(255) NOT NULL,
  `event_Date` date NOT NULL,
  `event_Description` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_incident`
--

CREATE TABLE `tb_incident` (
  `incident_ID` int(11) NOT NULL,
  `incident_Name` varchar(512) NOT NULL,
  `incident_DateTime` datetime NOT NULL,
  `incident_Location` varchar(255) NOT NULL,
  `incident_Type` varchar(255) NOT NULL,
  `incident_Description` mediumtext DEFAULT NULL,
  `incident_Status` enum('Ongoing','Resolved','Dismissed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_incident`
--

INSERT INTO `tb_incident` (`incident_ID`, `incident_Name`, `incident_DateTime`, `incident_Location`, `incident_Type`, `incident_Description`, `incident_Status`) VALUES
(11, 'Skidmore, John Patrick', '2025-05-06 22:01:00', 'Main Library - 2nd Floor', 'Destruction of Property', 'sada', 'Ongoing'),
(13, 'Gonzaga, Kaishaun', '2025-04-24 12:38:00', 'CL3', 'Vandalism', 'Fire alarm prank', 'Resolved');

-- --------------------------------------------------------

--
-- Table structure for table `tb_news`
--

CREATE TABLE `tb_news` (
  `news_ID` int(11) NOT NULL,
  `news_Title` varchar(1024) NOT NULL,
  `news_Description` mediumtext NOT NULL,
  `news_Category` varchar(256) NOT NULL,
  `news_Date` date NOT NULL,
  `news_Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_news`
--

INSERT INTO `tb_news` (`news_ID`, `news_Title`, `news_Description`, `news_Category`, `news_Date`, `news_Timestamp`) VALUES
(1, 'RAISE Southern Tagalog secures approval of PhP63.7-M from PCAARRD for AANR Tech Commercialization', 'The Department of Science and Technology’s Philippine Council for Agriculture, Aquatic, and Natural Resources Research and Development (PCAARRD) Directors’ Council (DC) and Governing Council (GC) have approved Cavite State University’s (CvSU) request for funding to continue the Regional Agri-Aqua Innovation System Enhancement (RAISE) Program in Southern Tagalog.\r\n\r\nThe approval was granted through the technology transfer and promotion division (TTPD) led by Dir. Noel Catibog during their meetings held on July 16, 2024, and August 12, 2024, respectively. RAISE Phase 2 was approved with a total budget of PhP63,729,796.00.\r\n\r\nThe RAISE program, now entering its second phase, focuses on strengthening technology commercialization across Southern Tagalog. The program is designed around four key components: Intellectual Property and Technology Business Management (IPTBM), Agribusiness Hub (ABH), Agri-Aqua Technology Business Incubation (ATBI), and Knowledge Management (KM). A total of PhP29,282,489 has been allocated to CvSU to fund these regional initiatives under the leadership of Dr. Teddy Tepora who serves as the program leader.\r\n\r\nDr. Tepora will also oversee the IPTBM component, while the other components will be led by new project leaders: Engr. Gee Jay C. Bartolome for the ABH, Dr. Rowena R. Noceda for the ATBI, and Dr. Lloyd O. Balinado for KM.\r\n\r\nThe project is set to run for a period of two years, from October 1, 2024, to September 30, 2026, during which the initiatives will continue to foster innovation and strengthen the region’s agribusiness and aquaculture sectors.\r\n\r\nIn addition to CvSU, 10 other institutions will collaborate in the implementation of the RAISE program. These include various organizations under each component, such as Batangas State University, Forest Products Research and Development Institute (FPRDI), Laguna State Polytechnic University (LSPU), Marinduque State University (MSU), Rizal Technological University (RTU), Romblon State University (RSU), Southern Luzon State University (SLSU), University of Rizal System (URS), University of the Philippines – Los Baños (UPLB), and Western Philippines University (WPU). Additionally, LSPU, FPRDI, and WPU will implement the ATBI component, contributing to a total of 17 approved projects under the RAISE Southern Tagalog Phase 2 initiative.\r\n\r\nAs part of Phase 2, a series of mentorship activities will be conducted to enhance key areas such as Intellectual Property Management, Technology Commercialization, Agri-business, ATBI Management, Technology Promotion, and Communication Planning. These sessions will be vital in equipping stakeholders with the skills and knowledge needed to navigate the complexities of technology commercialization.\r\n\r\nMoreover, several important events will be organized, including Regional Technology Pitching, Networking Events, Information Caravans, National Spinoff Writeshop, and the National ATBI Summit. These activities aim to promote collaboration, showcase innovations, and provide opportunities for networking and knowledge exchange among key players in the agri-aqua sector. (by Rhuzel Leinster Dean J. Julian)', 'ARTICLE', '2025-01-23', '2025-05-23 09:49:19'),
(2, 'CvSU tops February 2025 Criminology Licensure Examination', 'Cavite State University (CvSU) celebrates the outstanding performance of its examinees in the February 2025 Licensure Examination for Criminologists.\r\n\r\nThe CvSU Main Campus is the top performing school (with 101-199 examinees) after posting a 98.35% passing rate (179/182) in the said licensure examination with a national passing rate of 60.50%.\r\n\r\nMeanwhile, CvSU Bacoor City Campus recorded a 94% passing rate (47/50), ranking as the third top performing school with 30-50 examinees. \r\n\r\nAccording to the Professional Regulation Commission, a total of 22,245 out of 36,768 examinees hurdled the Criminology Licensure Examination given by the Board of Criminology.\r\n\r\nSee full results here: https://www.prc.gov.ph/article/february-2025-licensure-examination-criminologists-results-released-twenty-20-working-days?fbclid=IwY2xjawI9wp9leHRuA2FlbQIxMAABHQXO1XwKY-pTexL1ilyMHHXNy2j81QHDkKC_j0XnTla9_VOeve3XGoT8dA_aem_reZaJJnvDPUAuUOKD1O45w', 'ANNOUNCEMENT', '2025-02-19', '2025-05-23 10:14:46'),
(3, 'CvSU bags top 2 performing SUC with highest number of Level III-accredited programs', 'Cavite State University (CvSU) is recognized as the top 2 performing State University and College (SUC) with the highest number of Level III programs accredited by the Accrediting Agency of Chartered Colleges and Universities in the Philippines, Inc. (AACCUP).\r\n\r\nThe plaque of recognition was awarded to CvSU during the 38th AACCUP National Conference on March 5-7, 2025 at the Marikina Polytechnic College in Sta. Elena, Marikina City.\r\n\r\nRepresenting the University at the national conference were Dr. Almira G. Magcawas, Vice President for Planning and Development; Mr. John Xavier B. Nepomuceno, Vice President for Administrative and Support Services; Asst. Prof. Armina B. Pugay, Campus Administrator of CvSU Naic Campus; Dr. Lauro D. Pascua, Campus Administrator of CvSU CCAT Campus; Prof. Zannie I. Gamuyao, Faculty Regent; Dr. Pia Rhoda P. Lucero, Director of Institutional Development Office; Prof. Nancy C. Alaras, Director of Pollution Control Office; and Prof. Ronan M. Cajigal.\r\n\r\nWith the theme “Elevate, Empower, and Expand QA in Higher Education,” the national conference served as a platform for academic leaders, quality assurance (QA) professionals, and accreditors nationwide to strengthen collaboration and innovation in enhancing QA standards in higher education.', 'ANNOUNCEMENT', '2025-03-07', '2025-05-23 10:16:10'),
(4, 'CvSU celebrates 119th founding anniversary', 'Cavite State University (CvSU) commemorated its 119th Founding Anniversary with the theme “Sustaining Quality and Integrity Towards Excellence in the New Generation,” March 26-28, 2025.\r\n\r\nUniversity employees and officials led by CvSU President Dr. Ma. Agnes P. Nuestro, and the members of the de las Alas family, gathered for the wreath-laying ceremony to honor the enduring legacy of Don Severino de las Alas.\r\n\r\nThe family portrait of Don Severino was also unveiled at the CvSU Historical and Cultural Museum as a tribute to the visionary leader and educator.\r\n\r\nThis was followed by the Ecumenical Thanksgiving Service as the CvSU community offered prayers for families, students, parents, employees, and officials.\r\n\r\nEmployees and members of the Administrative Council also led the ribbon cutting for the Foundation Day Exhibit. They also graced the blessing of newly constructed facilities, including the Waste Water Treatment Facility, Baño de Señora Resort, Planning Office, SPRINT Center Training and Exhibit Hall (Bulwagang Irok), University Entrepreneurial Center, and International House II Arch.\r\n\r\nMeanwhile, transformative partnerships for a better future took the spotlight as the University recognized its partner organizations during the Partners’ Gala 2025: “Honoring Excellence, Integrity, and Collaboration.”\r\n\r\nThe second day kicked off with the Employees’ Star Olympics 2025 parade and zumba wellness activities spearheaded by the CvSU Faculty Association and Non-Academic Employees Association. Participating faculty members and employees from the main and satellite campuses competed in the following sports events: basketball, volleyball, table tennis, and badminton. \r\n\r\nThe community’s furry friends also gathered for the CvSU Pet Parade and free anti-rabies vaccination drive, a joint activity by the College of Medicine and the College of Veterinary Medicine and Biomedical Sciences (CVMBS) in celebration of the Rabies Month, the University Foundation Day, and the 25th anniversary of CVMBS.\r\n\r\nMoreover, student organizations opened the two-day Malayang Diwa Festival 2025 highlighting a series of activities including Iskolar’s Bazaar booths, Sine Juana film showing, musical and theatrical performances, and fire prevention seminar and workshop, among others. \r\n\r\nRecognizing the employees’ unwavering dedication to public service and upholding the tenets of the institution, CvSU honored the service loyalty awardees and retirees during the Gawad Laya at Diwa 2025. \r\n\r\nThe University also recognized notable faculty members, non-teaching personnel, students, and units that were hailed as this year’s recipients of CvSU Outstanding Student of the Year, Gabay ng CvSU Award (Administrator of the Year Award), Tanglaw ng Mag-aaral Award (Faculty of the Year Award), Kabalikat Award (Employee of the Year Award), Galing ng CvSU Award (Model Employee of the Year), Mananaliksik ng CvSU Award (Researcher of the Year Award), Tagapag-ugnay ng CvSU Award (Extensionist of the Year Award), Pinakamaayos na Yunit Award (Most Organized Unit Award), Husay ng CvSU Award (Best Organizational Unit Award).\r\n\r\nThe three-day celebration capped off with a zumba session, Kapehan ng Alumni, Parangal sa Alumni, and Pasiklaban ng Aluminum Season 3 as part of the Alumni Loyalty Day 2025 organized by the CvSU Alumni Association, Inc. ', 'NEWS', '2025-03-28', '2025-05-23 10:17:09'),
(5, 'CvSUeños’ loyalty and excellence honored in Gawad Laya at Diwa 2025', 'Cavite State University (CvSU) honored its students, faculty members, employees, retirees, and units during the Gawad Laya at Diwa 2025, March 27, at the International Convention Center.\r\n\r\nWith the theme “Sustaining Quality and Integrity towards Excellence in the New Generation,” CvSU recognized the awardees’ unwavering commitment to upholding the institution’s core values and contributing to its transformative growth. \r\n\r\nIn a message delivered by National Economic and Development Authority (NEDA) IV-A Regional Director Carmel P. Matabang, NEDA Sec. Arsenio M. Balisacan acknowledged the dedication of CvSU’s students, faculty, and staff, in making a profound impact not only locally, but in the whole country.\r\n\r\n“By working together, we are not only upholding the legacy of CvSU, but also laying the foundation for a society that thrives in an ever-changing world. Every role within this University is instrumental in shaping a brighter future for our region and our nation,” Sec. Balisacan said in the delivered speech. \r\n\r\nMoreover, Sec. Balisacan highlighted how the theme serves not only as a guiding principle but also a call to action. He emphasized “the crucial role of educators and institutions in producing highly skilled and globally competitive graduates” in line with the CALABARZON Regional Development Plan 2023-2028.\r\n\r\nUniversity President Dr. Ma. Agnes P. Nuestro, along with Regional Director Matabang, Vice President (VP) for Academic Affairs Dr. Cristina M. Signo, VP for Administrative and Support Services Mr. John Xavier B. Nepomuceno, and VP for Planning and Development and Business and Resource Generation Dr. Almira G. Magcawas, led in honoring the retirees and employees in active service who rendered 10, 15, 25, and 35 years of continuous service to CvSU.\r\n\r\nMr. Hyram Adrienne M. Salinas, a fourth year BS Education Major in English student from the CvSU Tanza Campus, was hailed as the CvSU Outstanding Student of the Year 2024 with his exemplary accomplishments in academics and extracurricular activities as an academic achiever and student leader. \r\n\r\nThrough the CvSU Program on Awards and Incentives for Service and Excellence (CvSU-PRAISE), the following awards were given to exceptional officials, employees, and units who went above and beyond in upholding the highest standards of excellence in education and public service:', 'ANNOUNCEMENT', '2025-03-29', '2025-05-23 10:18:05'),
(6, 'CvSU reaps fourth ITSO Platinum Award', 'For the fourth consecutive year, Cavite State University (CvSU) – Innovation and Technology Support Office (ITSO) received the prestigious Platinum Award during the 2025 ITSO Presidents’ Summit and General Assembly at the Sequoia Hotel, Manila Bay in Parañaque City, April 10, 2025.\r\n\r\nThe University is also awarded with two Special Citation Awards for achieving at least 10 filings each for both trademarks and patents in 2024.\r\n\r\nRepresenting the University during the event were Dr. Melbourne R. Talactac, Vice President for Research and Extension; Dr. Agnes C. Francisco, OIC of the Knowledge Management Center; Dr. Teddy F. Tepora, Head of the Intellectual Property and Technology Business Management Division (IPTBMD) and ITSO Manager; and Mr. Gerald T. Viado, IPTBMD Staff.\r\n\r\nWith the theme, “Empowering ITSOs Towards Global Recognition of Innovation Breakthroughs,” ITSO representatives in the country gathered to celebrate key milestones and strengthen collaborations among member institutions on innovation and intellectual property. (with report from the Knowledge Management Center)', 'ANNOUNCEMENT', '2025-04-10', '2025-05-23 10:18:41'),
(7, 'CvSU, stakeholders tackle critical science behind coasts in ‘Cavite Coastal Stories’', 'The Cavite State University (CvSU) gathered relevant stakeholders for a roundtable discussion on wetlands and sea turtle nesting sites, April 8, 2025, at the CvSU Interdisciplinary Research Building Conference Room.\r\n\r\nSpearheaded by the CvSU Research Center, “Cavite Coastal Stories: The Case of Cavite Wetlands and Sea Turtle Nesting Sites” united key stakeholders from Cavite’s coastal local government units of Cavite City, Kawit, Maragondon, Naic, and Noveleta; Department of Environment and Natural Resources – Provincial Environment and Natural Resources Cavite; the Philippine Reclamation Authority; and private institutions to forge collaborative pathways for coastal biodiversity conservation.\r\n\r\nCvSU President Dr. Ma. Agnes P. Nuestro and Research and Extension Vice President Dr. Melbourne R. Talactac opened the event with their inspirational messages where they emphasized how the university can contribute through research in providing holistic solutions to the problems and issues affecting coastal areas.\r\n\r\nResource persons including Ms. Ailene H. Calamlam, Mr. Daeniel Zarene P. Mojica, Mr. John Daniel V. Cap-atan, and Mr. Glenn Bryan A. Creencia from the College of Agriculture, Food, Environment, and Natural Resources (CAFENR) – Department of Forestry and Environmental Science, presented vital research on oyster farming suitability, sea turtle nesting sites, seagrass biodiversity, and wetland characterization.\r\n\r\nThe event concluded with the stakeholders’ presentation of the ways forward based on the research findings, with some focusing on policy formulation and science-based decision making. (with reports and photos from CvSU Research Center and CAFENR)', 'NEWS', '2025-04-12', '2025-05-23 10:19:42'),
(9, 'Dr. Nuestro named new CvSU President', 'Dr. Ma. Agnes P. Nuestro has been named as the fourth president of Cavite State University (CvSU).\r\n\r\nThe members of the CvSU Board of Regents elected Dr. Nuestro to become the next president of the University, succeeding Dr. Hernando D. Robles who retired in October 2024. \r\n\r\nHaving served as the University’s Vice President for Academic Affairs, Dr. Nuestro envisions CvSU as a premier global university by 2028.\r\n\r\nIn her presentation during the Public Forum for the Search for the 4th CvSU President, Dr. Nuestro emphasized her administration’s goals centered on IDEAL: Inclusive and Accessible Education, Dynamic and Competitive Research and Innovation, Empowered Communities and Stronger Partnership, Accountable and Client-Centered Governance, and Long-lasting/Sustainable Resource Generation. ', 'ANNOUNCEMENT', '2025-01-20', '2025-05-23 10:52:47'),
(10, 'CvSU partners with ABS-CBN for Halalan 2025 coverage', 'Cavite State University (CvSU) is among the institutions who partnered with Philippine broadcaster ABS-CBN to ensure a “peaceful, clean, and orderly” midterm elections on May 12, 2025.\r\n\r\nThis was formalized through the ABS-CBN’s Halalan 2025 Covenant Signing on January 14, 2025 at Studio 10, ABS-CBN Compound in Quezon City.\r\n\r\nProf. Tania Marie P. Melo, Director of the Public Affairs and Communications Office (PACO), and Ms. Nheslaine C. Eval, Information Officer III, represented CvSU during the covenant signing participated by 31 election partners composed of public and private agencies, media organizations, academic institutions, and civil society groups. \r\n\r\nThrough the College of Arts and Sciences – Department of Communication (DComm) headed by its chairperson, Prof. Lisette D. Mendoza, in collaboration with the International and Local Collaborations and Linkages Office (ILCLO) led by director Prof. Ma Veronica P. Peñaflorida, the University entered into this partnership which aims to bring to the public an in-depth and balanced news presentation – providing the most comprehensive election coverage that will reach as many communities as possible. \r\n\r\nAs part of this endeavor, ABS-CBN will also provide CvSU students and teachers with an on-campus training on fact checking and election reporting in preparation for Halalan 2025. The University will also be collaborating with the network on the coverage of election-related activities, and provision of subject matter experts and resource persons for ABS-CBN News platforms.\r\n\r\n', 'ANNOUNCEMENT', '2025-01-14', '2025-05-23 10:53:59'),
(11, 'Public forum for CvSU presidency held', 'Cavite State University (CvSU) held a public forum for the search for the next University President on 09 January 2025, 9:00 a.m. at the International Convention Center. \r\n\r\nThe five presidential candidates including Dr. Rhodora S. Crizaldo, Dr. Hosea DL. Matel, Dr. Ruel M. Mojica, Dr. Ma. Agnes P. Nuestro, and Dr. Bernardo N. Sepeda appeared before the academic community to present their vision, plans and programs for CvSU.\r\n\r\nDuring the said event, the aspirants also went through three rounds of questions as they addressed issues and concerns raised by the forum participants and representatives of administrative employees, faculty, students, alumni, and community. \r\n\r\nA closed-door panel interview was also held in the afternoon wherein the candidates faced the members of the Search Committee for Presidency headed by Dr. Elsa P. Manarpaac. \r\n\r\nIn October 2024, the Board of Regents of CvSU formally opened the search for the fourth University President who will succeed Dr. Hernando D. Robles. \r\n\r\nWatch the public forum through this link: https://www.facebook.com/share/v/189a9ADj3a/ ', 'ANNOUNCEMENT', '2025-01-09', '2025-05-23 10:54:22');

-- --------------------------------------------------------

--
-- Table structure for table `tb_student`
--

CREATE TABLE `tb_student` (
  `student_ID` int(11) NOT NULL,
  `student_FirstName` varchar(255) NOT NULL,
  `student_LastName` varchar(255) NOT NULL,
  `student_Email` varchar(255) NOT NULL,
  `student_Program` varchar(255) NOT NULL,
  `student_Year` int(11) NOT NULL,
  `student_Section` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin_exam`
--
ALTER TABLE `tb_admin_exam`
  ADD PRIMARY KEY (`exam_Date`);

--
-- Indexes for table `tb_admin_user`
--
ALTER TABLE `tb_admin_user`
  ADD PRIMARY KEY (`admin_ID`);

--
-- Indexes for table `tb_admission_control`
--
ALTER TABLE `tb_admission_control`
  ADD PRIMARY KEY (`admission_ControlNumber`),
  ADD UNIQUE KEY `admission_ID` (`admission_ID`),
  ADD KEY `fk_exam_Date` (`admission_Exam`);

--
-- Indexes for table `tb_admission_education`
--
ALTER TABLE `tb_admission_education`
  ADD PRIMARY KEY (`admission_ID`);

--
-- Indexes for table `tb_admission_family`
--
ALTER TABLE `tb_admission_family`
  ADD PRIMARY KEY (`admission_ID`);

--
-- Indexes for table `tb_admission_info`
--
ALTER TABLE `tb_admission_info`
  ADD PRIMARY KEY (`admission_ID`);

--
-- Indexes for table `tb_admission_medical`
--
ALTER TABLE `tb_admission_medical`
  ADD PRIMARY KEY (`admission_ID`);

--
-- Indexes for table `tb_admission_personal`
--
ALTER TABLE `tb_admission_personal`
  ADD PRIMARY KEY (`admission_ID`);

--
-- Indexes for table `tb_admission_user`
--
ALTER TABLE `tb_admission_user`
  ADD PRIMARY KEY (`admission_ID`);

--
-- Indexes for table `tb_event`
--
ALTER TABLE `tb_event`
  ADD PRIMARY KEY (`event_ID`);

--
-- Indexes for table `tb_incident`
--
ALTER TABLE `tb_incident`
  ADD PRIMARY KEY (`incident_ID`),
  ADD KEY `fk_student_ID` (`incident_Name`);

--
-- Indexes for table `tb_news`
--
ALTER TABLE `tb_news`
  ADD PRIMARY KEY (`news_ID`);

--
-- Indexes for table `tb_student`
--
ALTER TABLE `tb_student`
  ADD PRIMARY KEY (`student_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin_user`
--
ALTER TABLE `tb_admin_user`
  MODIFY `admin_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_admission_control`
--
ALTER TABLE `tb_admission_control`
  MODIFY `admission_ControlNumber` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_admission_user`
--
ALTER TABLE `tb_admission_user`
  MODIFY `admission_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tb_event`
--
ALTER TABLE `tb_event`
  MODIFY `event_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_incident`
--
ALTER TABLE `tb_incident`
  MODIFY `incident_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_news`
--
ALTER TABLE `tb_news`
  MODIFY `news_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_student`
--
ALTER TABLE `tb_student`
  MODIFY `student_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_admission_control`
--
ALTER TABLE `tb_admission_control`
  ADD CONSTRAINT `fk_admission_ID_control` FOREIGN KEY (`admission_ID`) REFERENCES `tb_admission_user` (`admission_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_exam_Date` FOREIGN KEY (`admission_Exam`) REFERENCES `tb_admin_exam` (`exam_Date`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_admission_education`
--
ALTER TABLE `tb_admission_education`
  ADD CONSTRAINT `fk_admission_ID_education` FOREIGN KEY (`admission_ID`) REFERENCES `tb_admission_user` (`admission_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_admission_family`
--
ALTER TABLE `tb_admission_family`
  ADD CONSTRAINT `fk_admission_ID_family` FOREIGN KEY (`admission_ID`) REFERENCES `tb_admission_user` (`admission_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_admission_info`
--
ALTER TABLE `tb_admission_info`
  ADD CONSTRAINT `fk_admission_ID` FOREIGN KEY (`admission_ID`) REFERENCES `tb_admission_user` (`admission_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_admission_medical`
--
ALTER TABLE `tb_admission_medical`
  ADD CONSTRAINT `fk_admission_ID_medical` FOREIGN KEY (`admission_ID`) REFERENCES `tb_admission_user` (`admission_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_admission_personal`
--
ALTER TABLE `tb_admission_personal`
  ADD CONSTRAINT `fk_admission_ID_personal` FOREIGN KEY (`admission_ID`) REFERENCES `tb_admission_user` (`admission_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
