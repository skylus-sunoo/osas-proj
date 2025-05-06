-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2025 at 04:24 PM
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
('May 16, 2025 PM', '2025-05-16', 'PM', 20, 20, 'RELEASED');

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
(1, 'johnpatrick.skidmore@gmail.com', '$2y$10$P4AJu5B.LasWhRkvDnw86uB5tO9dQiI5Ncznhxc7MtbPhTVOkJAWq');

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
(6, 35, '', 'Yes', 'Yes', NULL, 'May 16, 2025 PM', NULL);

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
(35, 'Pintong Gubat Elementary School', '8XCM+RQ4, Paliparan Rd, Dasmariñas, Cavite', 2017, 'Public', 'Paliparan II Integrated High School', '8X3V+686, Paliparan 2, Dasmariñas, 4114 Cavite', 2021, 'Public', 'Philippine Christian University - Dasmarinas', '7XV6+3X2, Aguinaldo Hwy, Dasmariñas, 4114 Cavite', 2023, 'Private', NULL, NULL, NULL, NULL);

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
(35, 'Joseph Bosul Skidmore', 9178354163, 'Sales Agent', 'Erly Enraca Skidmore', 9472902443, 'Housewife', '11,000-20,000', 1, 'Eldest', 'Erly Enraca Skidmore', 9472902443, 'Housewife');

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
(35, 'Silang', 'New', 'Filipino', 'STEM', 'GR12', 107923130246, 'BSCS');

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
(35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No');

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
(35, 'John Patrick', 'Enraca', 'Skidmore', NULL, 'IV_A', 'Cavite', 9918285766, NULL, 'Single', 'Male', '2005-11-23', 'Trece Martires', 'Roman Catholic', 'No');

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
(4, 'marilyn.cantada@gmail.com', '$2y$10$8EbliNa1S510jrpuY7ADEuVBOd9wSOu3ABmKuj5QiaDaTcb/2ru1G'),
(5, 'erikamae.caraan@gmail.com', '$2y$10$N72AYiC1.Vc4MH29M8kN/euE8QK/Mzpm0MgrZYBHvUonx1pqk5v4u'),
(6, 'zedrickdenzel.claridad@gmail.com', '$2y$10$yGyNh/CqPmm9WaiBjgFlD.zEISpYwxkewVT.Vw15t.XFElWj1HoH.'),
(7, 'kentraven.deleon@gmail.com', '$2y$10$rJOZ.xVfp5hd4cy4gqJD9.bqcIoxr1zQ.l/lnyUY.VgurSNT1B0JG'),
(8, 'sebestienerhodney@gmail.com', '$2y$10$92XNZ8kgRukMZ/.8gQqVe.Zw1lQMr2NlzjBxKR0llbTGzL95ui3A.'),
(9, 'jasmin.ebon@gmail.com', '$2y$10$5zjpRjDI403YtR6nQsA0aeSOxWPKkdVjzdQAsnLQUxpwgEIJm6Lk6'),
(10, 'christine.ermino@gmail.com', '$2y$10$Bg3l61DX5Lkni0HU2ZXf/u808TlaY8bH4.ONnN1uO4ifBsBvoKmNO'),
(11, 'charlesaldrin.galon@gmail.com', '$2y$10$SDeIpuNlwKKA.l4rzuTxCOZwsr5LjoZqErfnF7uAUnA0.eXdXeFsG'),
(12, 'kaishaun.gonzaga@gmail.com', '$2y$10$zvqwd9WdCYPo4wDai0aFwe5IYdOxLpeVX.1q9MjmCY8u//6TYNdUK'),
(13, 'ivan.joson@gmail.com', '$2y$10$FUsj/U5YWSP2pMBpuVONKelHzeH74wYbYgSuVAJZhC0nsVznB/W.e'),
(14, 'tairadanielle.julia@gmail.com', '$2y$10$WCPXoIkUYFvNU8HNMhIV7.OYVUQ3Lik2OuUK/8kOy3Gz0LYd7kqdu'),
(15, 'krysteljoy.kapangyarihan@gmail.com', '$2y$10$sxreUdCs68nCrpTZ.jtU5Oi/AIOkBGsnviLK3s40.xbWtCxf6rJO2'),
(16, 'anyahermione.loyola@gmail.com', '$2y$10$kmmnDLb8nsThgZX/MusF.O.myEoWf67S3Ux8ywUMUGfa5xKn3DyQS'),
(17, 'christianjames.maano@gmail.com', '$2y$10$Yqs9RNgtJeqaTaEgwrm07e9Qz2rvjq6xhqf6TqDezVtvEKjAKzPN6'),
(18, 'markariel.macawili@gmail.com', '$2y$10$YFVudH4qWI7J9GQLSeQQAesc/yGAO9KnaspABlbzzgzRZY6vxdBaK'),
(19, 'kurtkevin.mallari@gmail.com', '$2y$10$ZbpYpXAN1oBddFhYnQMz3eF0krbsYOoyiWE8Z4.EZle8VwbnF2Lq.'),
(20, 'joshua.mamorno@gmail.com', '$2y$10$KAA3m/CW4bylhEVlEZSpqONDHDrBDUzaoK1bLStOYk0AZwfjN9QHa'),
(21, 'lovedivine.manzano@gmail.com', '$2y$10$5eQL53KUnIW0nZXaEEPkM.uRTPd58dJS1nKTLepPax8iTARyqySVq'),
(22, 'francisjoshua.mapanoo@gmail.com', '$2y$10$.sDQOVzcsRdGUNx2.6KJ9eBOORX6Nsa2cFJXGhnv/L3RK13k6xTq6'),
(23, 'markjason.mendoza@gmail.com', '$2y$10$bZkw1xhRF5soVmx.KpxFHOPV4O7Uj52eMQXXL5Mp8EW4wMtXY3ag.'),
(24, 'ralphchryslerjohn.mendoza@gmail.com', '$2y$10$Zdbc6KgZii/ocpyAVuBa0e5GC9Knt6.YQJ4Olojew24LxRFUYAwNy'),
(25, 'mikejester.miano@gmail.com', '$2y$10$WjKDeQpTd5GyLexvW13nJOiOYI8QzxLKzVjsY/wi0RJSa0eNmS8oC'),
(26, 'johncarlo.montemayor@gmail.com', '$2y$10$oCruSa6vp/Eb6nq.rcDrd.VB8picR4Q84rL8sWtod2BQYnZoIOQpa'),
(27, 'ronaldtyrone.pangilinan@gmail.com', '$2y$10$CepSiOy.Q1OapvnX26larewlLLyJhQTrcB7mnI/CmUynVnc6fhJLC'),
(28, 'markaljon.pilar@gmail.com', '$2y$10$/6iThkSLOHzOWd6MJmHNXeX3wvFia3Cb1K1iVkm8bMlpynQvMJXdO'),
(29, 'johncena.piquero@gmail.com', '$2y$10$.9aktQHcbdRTdnPn6oNq8u8ikpaP2zjgQAhDkaJs1BmM3ERv1a4qm'),
(30, 'freddieboy.poblete@gmail.com', '$2y$10$YzQIg2anhcZ2NsdR/idY8eYvPJbcneuBoLahLlyDCEvDg0nXNwZPC'),
(31, 'christianjay.ramos@gmail.com', '$2y$10$2NivbEGvmCXB5TUtcI71GeVXspGeb2xjhgdLfQp2ccg33bov4iRU.'),
(32, 'mikhaelajoline.ramos@gmail.com', '$2y$10$Np3UuiQLiYyXXpxVeSeGiO19tulbZlGNvqG8rMD1HoNruRnjb39ku'),
(33, 'divinevalerie.reyes@gmail.com', '$2y$10$3nU.4iTz.xM2MhfgRjLmzOlAoRYVM85g/B4O2FB1vrvb3e2ofTNQO'),
(34, 'daveulrich.santos@gmail.com', '$2y$10$iUd8nVYtUOrpolD3tr7HduSH7AXofWOpLkN9vfTMmrgEAbI3j7.AS'),
(35, 'johnpatrick.skidmore@gmail.com', '$2y$10$o5M5Knkw1lHyrMEmUBHU7.uLnWp4de5hr60bhVGJeJtcAOXJK7mrq'),
(36, 'ghia.tabago@gmail.com', '$2y$10$6s./Kd8lsk0QqALHn9Kz8.N71VkjXu4P99NSNsVVXZbXIKpvrkDVS'),
(37, 'cedrick.toledana@gmail.com', '$2y$10$vP6aAWKYRzl5EnUMlCohGO6G1AnlumOf0cMJ2hPhEl3mbhbkjqB4.');

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
(11, 'Skidmore, John Patrick', '2025-05-06 22:01:00', 'Main Library - 2nd Floor', 'Destruction of Property', 'sada', 'Ongoing');

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
  MODIFY `admin_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_admission_control`
--
ALTER TABLE `tb_admission_control`
  MODIFY `admission_ControlNumber` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_admission_user`
--
ALTER TABLE `tb_admission_user`
  MODIFY `admission_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tb_event`
--
ALTER TABLE `tb_event`
  MODIFY `event_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_incident`
--
ALTER TABLE `tb_incident`
  MODIFY `incident_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
