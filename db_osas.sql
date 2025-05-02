-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2025 at 04:16 PM
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
-- Table structure for table `tb_admission_control`
--

CREATE TABLE `tb_admission_control` (
  `admission_ControlNumber` int(5) NOT NULL,
  `admission_ID` int(11) NOT NULL,
  `admission_Appointment` varchar(128) DEFAULT NULL,
  `admission_Exam` varchar(128) DEFAULT NULL,
  `admission_Result` enum('ACCEPTED','REJECTED') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `admission_Religion` varchar(64) NOT NULL,
  `admission_Indigenous` enum('Yes','No') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_admission_user`
--

CREATE TABLE `tb_admission_user` (
  `admission_ID` int(11) NOT NULL,
  `admission_Email` varchar(255) NOT NULL,
  `admission_Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `student_ID` int(11) NOT NULL,
  `incident_DateTime` datetime NOT NULL,
  `incident_Location` varchar(255) NOT NULL,
  `incident_Type` varchar(255) NOT NULL,
  `incident_Description` mediumtext DEFAULT NULL,
  `incident_Status` enum('Ongoing','Resolved','Dismissed') NOT NULL,
  `user_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_incident`
--

INSERT INTO `tb_incident` (`incident_ID`, `student_ID`, `incident_DateTime`, `incident_Location`, `incident_Type`, `incident_Description`, `incident_Status`, `user_ID`) VALUES
(24, 134, '2025-04-27 22:23:00', 'fsa', 'sfa', 'fsa', 'Ongoing', 0),
(26, 414, '2025-04-04 22:31:00', 'fsa', 'sfa', 'sfa', 'Resolved', 0),
(27, 414, '2025-04-04 22:31:00', 'fsa', 'sfa', 'sfa', 'Resolved', 0);

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
-- Indexes for table `tb_admission_control`
--
ALTER TABLE `tb_admission_control`
  ADD PRIMARY KEY (`admission_ControlNumber`),
  ADD UNIQUE KEY `admission_ID` (`admission_ID`);

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
  ADD KEY `fk_student_ID` (`student_ID`);

--
-- Indexes for table `tb_student`
--
ALTER TABLE `tb_student`
  ADD PRIMARY KEY (`student_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admission_control`
--
ALTER TABLE `tb_admission_control`
  MODIFY `admission_ControlNumber` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_admission_user`
--
ALTER TABLE `tb_admission_user`
  MODIFY `admission_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_event`
--
ALTER TABLE `tb_event`
  MODIFY `event_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_incident`
--
ALTER TABLE `tb_incident`
  MODIFY `incident_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
  ADD CONSTRAINT `fk_admission_ID_control` FOREIGN KEY (`admission_ID`) REFERENCES `tb_admission_user` (`admission_ID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tb_admission_education`
--
ALTER TABLE `tb_admission_education`
  ADD CONSTRAINT `fk_admission_ID_education` FOREIGN KEY (`admission_ID`) REFERENCES `tb_admission_user` (`admission_ID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tb_admission_family`
--
ALTER TABLE `tb_admission_family`
  ADD CONSTRAINT `fk_admission_ID_family` FOREIGN KEY (`admission_ID`) REFERENCES `tb_admission_user` (`admission_ID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tb_admission_info`
--
ALTER TABLE `tb_admission_info`
  ADD CONSTRAINT `fk_admission_ID` FOREIGN KEY (`admission_ID`) REFERENCES `tb_admission_user` (`admission_ID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tb_admission_medical`
--
ALTER TABLE `tb_admission_medical`
  ADD CONSTRAINT `fk_admission_ID_medical` FOREIGN KEY (`admission_ID`) REFERENCES `tb_admission_user` (`admission_ID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tb_admission_personal`
--
ALTER TABLE `tb_admission_personal`
  ADD CONSTRAINT `fk_admission_ID_personal` FOREIGN KEY (`admission_ID`) REFERENCES `tb_admission_user` (`admission_ID`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
