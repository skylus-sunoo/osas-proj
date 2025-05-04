-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2025 at 04:48 PM
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
(2, 'johnpatrickskidmore@gmail.com', '$2y$10$hpJ8ouSb/p7rMh0Q25xEI.PN49AT5JvwFcKTw3wDrUsYOdATK3iJq');

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
  `admission_Exam` varchar(128) DEFAULT NULL,
  `admission_Result` enum('ACCEPTED','REJECTED') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admission_control`
--

INSERT INTO `tb_admission_control` (`admission_ControlNumber`, `admission_ID`, `admission_Appointment`, `admission_Picture`, `admission_Folder`, `admission_Certificate`, `admission_Exam`, `admission_Result`) VALUES
(1, 1, NULL, 'Yes', 'Yes', NULL, NULL, NULL),
(2, 2, NULL, 'Yes', 'Yes', 'Yes', NULL, NULL);

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
(1, 'Pintong Gubat Elementary School', '8XCM+RQ4, Paliparan Rd, Dasmariñas, Cavite', 2017, 'Public', 'Paliparan II Integrated High School', '8X3V+686, Paliparan 2, Dasmariñas, 4114 Cavite', 2021, 'Public', 'Philippine Christian University - Dasmarinas', '7XV6+3X2, Aguinaldo Hwy, Dasmariñas, 4114 Cavite', 2023, 'Private', NULL, NULL, NULL, NULL),
(2, 'Pintong Gubat Elementary School', '8XCM+RQ4, Paliparan Rd, Dasmariñas, Cavite', 2019, 'Public', 'Paliparan II Integrated High School', '8X3V+686, Paliparan 2, Dasmariñas, 4114 Cavite', 2023, 'Public', 'Paliparan II Integrated High School', '8X3V+686, Paliparan 2, Dasmariñas, 4114 Cavite', 2025, 'Public', NULL, NULL, NULL, NULL);

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
(1, 'Joseph Bosul Skidmore', 9178354163, 'Sales Agent', 'Erly Enraca Skidmore', 9918285766, 'Housewife', '11,000-20,000', 1, 'Eldest', 'Erly Enraca Skidmore', 9918285766, 'Housewife'),
(2, 'Joseph Bosul Skidmore', 9178354163, 'Sales Agent', 'Erly Enraca Skidmore', 9918285766, 'Housewife', '11,000-20,000', 1, 'Youngest', 'Erly Enraca Skidmore', 9918285766, 'Housewife');

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
(1, 'Silang', 'New', 'Foreign', 'STEM', 'GR12', 107923130246, 'BSCS'),
(2, 'Silang', '2nd Courser', 'Filipino', NULL, NULL, NULL, 'BSTM');

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
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No'),
(2, NULL, NULL, NULL, NULL, NULL, 'Yes', 'Yes', 'Yes', NULL, 'No');

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
(1, 'John Patrick', 'Enraca', 'Skidmore', NULL, 'IV_A', 'Cavite', 9918285766, NULL, 'Single', 'Male', '2005-11-23', 'Trece Martires', 'Roman Catholic', 'No'),
(2, 'Ashley Clare', 'Enraca', 'Skidmore', NULL, 'IV_A', 'Cavite', 9985762341, NULL, 'Single', 'Female', '2007-05-14', 'San Francisco', 'Anglican', 'No');

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
(1, 'johnpatrickskidmore@gmail.com', '$2y$10$/OFuJXS8ZfeXJniFC0ehEu2y6FAJvJZkVY8Zxa30/582bLIjBqe4K'),
(2, 'jpes@gmail.com', '$2y$10$Cb00SEDiFGjYohc0sbhrfuDBeX6OM44DzQVjsNzlyWM4qbaPmWuiG'),
(3, '8e50138912@example.com', '$2y$10$T2IhDPI92cy3hIlV3W/sNeTFPWMfNdZrCJ/lQ4ySVkoUykfIkFh8m'),
(4, 'e63f546efa@example.com', '$2y$10$jXJKFFffdLWsMQxK2gemyOsiKd3UhEQ3iuDR8P6ftRahbehhRQBhS'),
(5, '1ff478d685@example.com', '$2y$10$UGVWaAy64YXn73ocS2TH0OvodMNcacqZffY39VehdoWYo9TWqXceG'),
(6, 'e1648276ef@example.com', '$2y$10$0S1KYsanTeVlTZaMM2fpoeCQqQjUPfXNNXDlLozuMDJMzzfJW2nDm'),
(7, '65ba30907e@example.com', '$2y$10$sq4G2WKMkYlUA9lf985GnuASISJV2b7.KTKiK/BOViLhGtzSM7oDS'),
(8, '7a82881b0d@example.com', '$2y$10$o9jCvizHA0OK2.Cfec0wFem1c1PI3GluOKDaAVvRKcMwLWOQODBZ.'),
(9, '8dfb0e57c7@example.com', '$2y$10$w4UYAI/uMlOtXS/KABxrWeqKeJcD2EtALNl88QsoegwLSpgeR0myG'),
(10, '151ad9c1a9@example.com', '$2y$10$8SAWFzjaz6OOIiFnpsGeCelXRquVNmIJPKcceagjqWamkp4MQhCb.'),
(11, '589147f9d5@example.com', '$2y$10$Y2jsc/yNmnP73OKx9XsIZeui4O/bohWXpvGPpitAeD55CDBgzwOvi'),
(12, '8ce386c618@example.com', '$2y$10$Bbc2Bb.H53m2pipVo3sywu7sr6ItxlemnSDF.ydU4l7Xz1b7g.yi2'),
(13, 'b6ce049f91@example.com', '$2y$10$sRkw20CjPZGJWm7ScIakf.K/fsBhOyNAPGhxfgyK1SUJyhUhSQZya'),
(14, 'ef470a2047@example.com', '$2y$10$vy0h/wBBfXhIA0pAfxAVdOA6piatiRfJ8bGqkMafqwERSSkGI8eLO'),
(15, 'ed32a37595@example.com', '$2y$10$OjKT0MUm7wttna6s9BLpXOj0mQ0avEvR90hZ95KF63BEc7Vxbbmy6'),
(16, '5f4434930e@example.com', '$2y$10$iSiVvtIpJ72Hzw35RxS4IuPdpI1.f0C7C9RHDU2YpFDL1XOnj1tle'),
(17, 'd126027414@example.com', '$2y$10$B5JbV9yBB.eUQqbxyzRnJu3Bilb.xI.WxyYiKUHLSQLGfClSJdeXy'),
(18, '9eee362eb7@example.com', '$2y$10$jCv6qKdgWV2fUBtk5DGuZ.2cU18JOraDioqTDx4UhIaId1QXoauKG'),
(19, '7f39c63640@example.com', '$2y$10$0SS1FwbX5h7QN3msy2GIjeNpmZs6eLp2E8I7170N/BKMMcQRgfPqe'),
(20, 'd680e5af84@example.com', '$2y$10$UkmM6wMq4GrWuiiZMnWPouIefr9GCIre26BewT8UEtAK2aglKf5Ty'),
(21, 'ff0f3086cf@example.com', '$2y$10$kknF/cvztp2eVlXoTPK6juNLG9wtpwsyr5wIUKYtis6o/nBo6qjiy'),
(22, '66a4905c7d@example.com', '$2y$10$vZT3VEdTVDMcJRVFQ2BlTOiPGXZLIuIyRT2kWTsQ2AO21/r6tbkuC'),
(23, '0600c307fa@example.com', '$2y$10$qDg7VprX.WVS7AR0UTS6ouURvi7e6U64XHq.3tbMZk3wy1FuucHt.'),
(24, '7a98b62bc3@example.com', '$2y$10$9C0Chh06yCBEmVAb/8rd8OXGnHE.Dx5..4JASNTHyJm/K4TL0mB6S'),
(25, 'a60f4880b3@example.com', '$2y$10$I4npGeHbR3lW9HIiZ1.jCOw2QUVPkkdyfH5BuH/OmXGug5o4xO0uW'),
(26, '7f1de5cecf@example.com', '$2y$10$SNOCDdgaCxsIHJHA8k8E.emw6XSv3vtL7x0L5ZKV47.1nUcguyxKW'),
(27, '5d56596e89@example.com', '$2y$10$lh2DGhHclStCpc47ixXmNOl1IwPt0VoJOTkp06LdmSjQytDF3jbyG'),
(28, 'fed104078d@example.com', '$2y$10$zSNixx9vLdKMR3Mh.9d5MeCRUMShuM82PPT2qkeP2g43O6Svefs6C'),
(29, 'cddce8096a@example.com', '$2y$10$XlqLxPAW/jJzlI9rKSh2wuUL.tX3oTHLEqp4oKa70CVJo/X9DdTCu'),
(30, '95f923a2e3@example.com', '$2y$10$FrJLmQ5Bam9I3EdAEulunOyraVS98cQUS/KMr2MFil2SIIApHtVam'),
(31, 'fe8e33ad31@example.com', '$2y$10$zHq/heNfo27Xm625HEBbfOlu.lrgCb1MgB1ZxvyHqlCQx/K.ApjEi'),
(32, 'b58a5f04be@example.com', '$2y$10$guFWvF0MYfZT3u5jATTVc.iNru/qm.23XW2qIzyMBMQsK.2PeE8N6'),
(33, 'ca869e9a42@example.com', '$2y$10$F.QzqHdFWhnYSWIrD7MExuj3qhajY/w8Uc4MX3LdOiVTWaCam2NwW'),
(34, '2b973a955d@example.com', '$2y$10$NtZuqaNqCL88IkrgFnbnMefjUJaaUmO.tWEhvaLPgJZ7Ut3YGnONS'),
(35, '4f7a99be80@example.com', '$2y$10$cGT8u8oj0kdeMk4PKrJeJu98R8fLohdZBg2vVDr4f/vArRQTWXir6'),
(36, '8b599375c0@example.com', '$2y$10$s60EbCpUFRvKf0uc5QR8euQA5b3uqKLgB1uSAgn3KyWjO0y/1hhli'),
(37, '248c6a8683@example.com', '$2y$10$ss1yAdRX2Bsa8tUBvZFfveEeWD6szb6hpD7uCsgF7sel3qx4C3btG'),
(38, 'ee8e3415fd@example.com', '$2y$10$wawhrKIjokw0HUvL8FDMvOUsrHh.M95PqB7QPYPCPwrhXLeQnKsa6'),
(39, '767def76c9@example.com', '$2y$10$WDjCSt3i07Hc7E0I8pEp1.dj5k36FsZgrvl2zEDPFWkS1MzY.kJ6u'),
(40, '9f9d2bcaf0@example.com', '$2y$10$jrMXXVbxVVJKIxOznjdEA.N/7VB273fPHLE7YcmZp0hShydPoqJ3O'),
(41, 'd8b5005275@example.com', '$2y$10$dN/uY.Z/UNmCd/kZ7ibUle3OUosOneP1dl.DIaxw2kiyf0afiABt2'),
(42, '8561d92c5d@example.com', '$2y$10$eWqoyUXnNvy4WHyhdXtSLegMvXNRLAWwcPTYGbfh1Q11jOEIdI6UW'),
(43, '491d4eee08@example.com', '$2y$10$3CO6EClJuNEd.IIDM0xVluM5knZH6/BGrK08n.PmV8cqdujELcXX.'),
(44, 'a2193cb245@example.com', '$2y$10$UAsFzDcl/oK1Ypj44T3cSuOdyshGM1CG1CpfZ1uelEbVTAqpUVBD2'),
(45, 'fcbd5ce94e@example.com', '$2y$10$4RsqXGmCzHD1CxWQC8UGh.lcUnxx5sgsgd.i.jLUsQz0QuEZXueka'),
(46, 'b2e2e6c144@example.com', '$2y$10$bWz9bvS9465K52/LNqFwquh/d1cZPiNGdSepmDqWvWAQ2YpLhYYgS'),
(47, 'cad26f356d@example.com', '$2y$10$tnaQqmbT4uQWZ3QRCu71COeDTglBDbxxXpR5H0/YYPJwsr6FeT7d2'),
(48, '8c0722aac1@example.com', '$2y$10$CpzLcspesQpZMe1AMoLoueCdsT2Kmfvavt0zbEMEyQm9IlAgg96Ni'),
(49, '201daffbab@example.com', '$2y$10$SM8wMoFTUd6G3r1hc62ZQetsofC/3uGeaNQXcDRoC9pkmaRgEE7ry'),
(50, 'baee65faa0@example.com', '$2y$10$IMY5XkkZHcyQkAVlAIZ9Ze4zKR1Lf0qrfgSuO.6u2sfZ/.czVQKua'),
(51, '143aa439fb@example.com', '$2y$10$4Xzv347Y0gA63xzGUEsVueUKjdjvx7q6bdKoN.dUTSkDWZ5xVKzcu'),
(52, 'ec0a943c1e@example.com', '$2y$10$1XzePFIJZi5F1lZqqWW5iOSrfbmK6aj16LX/4MoLRdv8WAjAi/Qwa'),
(53, 'ecbff8b473@example.com', '$2y$10$mksWyCLMUm6hMnhAX7Ywd.dG7W1RLlT.tzgcoWRej1imKYR13i2N.'),
(54, 'beed60e4e7@example.com', '$2y$10$9L8aO8oHk3f9zIx/hU/XzuxCzM5oSbWKknD3yMOGL3BJOtC0ak056'),
(55, '81a3669a81@example.com', '$2y$10$1bWwXk5sqP8f.REAXWXLheTmKKXdAGjg5PQa8nXfQ0HfNkAzAiFSC'),
(56, 'e9343ad712@example.com', '$2y$10$gCkQ.MLT7GOqGIRf.KqDJewPpejwbwl.zxe38eg2s8x4Ur/N3odRq'),
(57, '67bae89b6b@example.com', '$2y$10$Fx7ymVORWN7.FmBFWSxzuO2l5tGP4UEP6pfjXiqlFl/42Bkw1fF8u'),
(58, '9c2366d3fc@example.com', '$2y$10$oXJI1W8Fs9cdhOBUxRM8Qu.QuY9hEzJn95B3zC0TXCnKAb3.IZlFu'),
(59, 'c9b14cf8ac@example.com', '$2y$10$3Am4hujF/UUcZdctMAatw.ZgYcDIDU/UmLB0KnrM1W1TM1radcYPy'),
(60, 'f640d1fc4f@example.com', '$2y$10$ArbnxPB.IhxBUqrzyDpFOu1QnoLBWuejY/GAnyfmoIxo/YEF/6xui'),
(61, 'f05977f2f7@example.com', '$2y$10$MrCjiTbPkAguKF7yS8LrR.S5/9IqqTFdf4Dghc2AsVeER4LndtZmq'),
(62, 'ed7b8efe6b@example.com', '$2y$10$e/18JFlBF5x/T4ZclCnd6OFBW5T.KkvEbJZfo3sc1JVCfXxh0gRuC'),
(63, 'd2d8f9c904@example.com', '$2y$10$bl.SnYnaWWGzUNax4b.v3uDJqyumfLEm0Rd0kzEVVydThkQ1FKOCe'),
(64, '74a2765b7e@example.com', '$2y$10$IoqX9M24qxH1UgTqYougseiMI02Zg3NGuSzHvuySVmKT3DtwASnX.'),
(65, 'fab59559ae@example.com', '$2y$10$nlSdk6Mrqred8V0qE80uReyZEkf/PpvUdK2EX1SsODBHjxu7C0MSy'),
(66, '7c95770431@example.com', '$2y$10$7QLQJMZSW0L8DpwlwSTdG.WaiQ.P1x5bcJzztqvHi8JmqUsp5XVl6'),
(67, '5e3f135cc5@example.com', '$2y$10$g0O7wNaaGfTuab/ISFUEiurZc6ytxuqplBfZq4seloJuobT4YmW42'),
(68, 'c23958a226@example.com', '$2y$10$VO9/di19Lnp6kxLntBH0X.XBSUbKLHNwGCT5o6LMzQGrXpA5Lpk1C'),
(69, '66f6aa84a9@example.com', '$2y$10$FiQJlVCWFInN/f.BG.RkruiuCpyeMGNYEGkAeXflwNaNxW7J8SOt2'),
(70, 'ddfa0ac5fd@example.com', '$2y$10$fNF0RNTpW8UzncxsvY0oA.VDocPC/xhQZuiJmsw0JrCatNf60DdBa'),
(71, '2c4b83ac77@example.com', '$2y$10$PpHlafNxBfAjUq/sa9gMYuIDbPyxCX4Cw.JlqfeODSui.r8kFiOl.'),
(72, '315568d425@example.com', '$2y$10$3Kxg2vYk5lAeJxMke1ikh.DZGcSzMzpxX/ijiIrZmO7WPSyXYEUFy'),
(73, '834891d5b8@example.com', '$2y$10$3094jhYxl740a/7dzsz7WuVUcmeHv8eMFOrvan8HI4Gpl1dqw8ShW'),
(74, '68573ae907@example.com', '$2y$10$Pccq7hISmGpERbX06fEmnuQ8BDCzPCRI5gvCC9uM0TXVDLCjxVNXW'),
(75, 'edcc475930@example.com', '$2y$10$a1ffGXnAfpXOb7RLmWyq7.fzCdkQaZsDKQqULflijk.uuQ93vEp9G'),
(76, 'f67974cfde@example.com', '$2y$10$gbAL9rwV3vjBynPjPB1LVOqbGoCvF7jA.GJ/S.Ktrpd7U.osmIQwG'),
(77, '455e373597@example.com', '$2y$10$AY83pIbGENKTsIIcOlBUCetivW8qOfiNiwTdXrt.rgm1naJfagGI.'),
(78, '0d30cbf7f9@example.com', '$2y$10$Eiqd8eMXeJmq9ikVhlgF1eIqqzkVzKh5TQGBUG7zg6RQJEdJK2luC'),
(79, 'd7df31de44@example.com', '$2y$10$mwgibynEPGPkUf73nKXcsu6OO3aG2JWdfrh7z55ndO.9Lp5XhGBoy'),
(80, 'b340822bae@example.com', '$2y$10$9qFtNYjEqBCiQfIDDJeHBO8OU6mc7MKGgLkzaaVGVH3On6Ee531uu'),
(81, 'ec40ae2e3d@example.com', '$2y$10$yyUaxnr.WuyOi3w.EgOXx.cgF8/3Hl2NuvLKZtzY/0Acrw0ysvnGy'),
(82, 'db7c29514e@example.com', '$2y$10$hnk7Q1k9Y5UqXxrlI9e3yewC5PnXnEdURDQ2RmLycxagXS3FBH5RG'),
(83, '6377254ac2@example.com', '$2y$10$CKr9IlKlWD9iywWJa6H/ZOOaK9xLX5JwyhuALb1yjXzWzjHkPpPUy'),
(84, 'e935770b8f@example.com', '$2y$10$76m4QZdTh.gusGyaK1Nuu.2JdQWTnCANJx8W68OWoNFfHzXx.ylj6'),
(85, 'd3081660c5@example.com', '$2y$10$txCuk4TMO40hOPDuVjL6Qu4.PTLiD0vWcmZsp/GKUiiQM.3Mc3GCy'),
(86, 'a18a1321cc@example.com', '$2y$10$bj7McUgUyNr60G9BdXMA.e1ux734f/Jivs98X6IMp3Rch3h1kl9Hu'),
(87, 'c205241274@example.com', '$2y$10$xpboPSrmDskHwSGVhO0GGelZqQHDwO8s1Qtz18CgQL8wOhwXx9S3W'),
(88, '6cc2570a40@example.com', '$2y$10$SZ52mEYWGoGol3wbGJEqVuOjRME3s9wgp4Aupl5O6LR0uW9jTTOkG'),
(89, 'eb7a9cba74@example.com', '$2y$10$.RLfxLMY3ESzKynY8fdZNOwFLIBWG3pwCwyKSA5tWsJ5nToR2HeRG'),
(90, '57314ba3e5@example.com', '$2y$10$je6n3a9TfGGa82r.FqzMJe8SbFgowWETXqQEuvLJNHU0yeHIzWBDi'),
(91, 'f00c8cfbb7@example.com', '$2y$10$ZW4NpoNVFILLWXyrxfJoUuf0E9shOKVU7hnNCller37.lxn0xb6tq'),
(92, 'a7b01b283f@example.com', '$2y$10$BUDDDIyGVdSvEXKi8y5fiOLaJ5O1IkiXnMXw4mP69xCQM129H4hsi'),
(93, 'b0e18e27e7@example.com', '$2y$10$zXceq736A3RJkrcHQ8.Kt.1XFTIgS4A18cWFnLarkoMpAbTrkzEqC'),
(94, '61c84722a6@example.com', '$2y$10$O3ABxSIsFslYEYEsPLBtMuNWarqXyTeZ.YaUuUM6DmKSOTSog/UHK'),
(95, '69e7142a1c@example.com', '$2y$10$byaEi2ykUS7QDqpA0bkrRO.vFIzS.MZ7D024PooI/8UFJn2hcPcze');

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
-- Indexes for table `tb_admin_user`
--
ALTER TABLE `tb_admin_user`
  ADD PRIMARY KEY (`admin_ID`);

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
  MODIFY `admission_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

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
  ADD CONSTRAINT `fk_admission_ID_control` FOREIGN KEY (`admission_ID`) REFERENCES `tb_admission_user` (`admission_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
