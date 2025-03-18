-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 18, 2025 at 10:06 AM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_applyonline2025`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE `api_keys` (
  `id` int(11) NOT NULL,
  `api_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `api_keys`
--

INSERT INTO `api_keys` (`id`, `api_key`, `created_at`) VALUES
(1, '626d1c19b5dcb2fe7122b030db5174c5a3b813b79a1224db270504d968239df7', '2025-03-06 09:43:00');

-- --------------------------------------------------------

--
-- Table structure for table `api_users`
--

CREATE TABLE `api_users` (
  `id` int(11) NOT NULL,
  `username` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `api_users`
--

INSERT INTO `api_users` (`id`, `username`, `password`) VALUES
(1, '7115009457', 'dfa05a9c07'),
(2, 'bp2aplyslc', 'bp2w778854');

-- --------------------------------------------------------

--
-- Table structure for table `application_ads1`
--

CREATE TABLE `application_ads1` (
  `ID` int(11) NOT NULL,
  `ApplicantID` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Address1` text COLLATE utf8_unicode_ci NOT NULL,
  `Province` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `District` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Sub_district` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Zipcode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `Phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `IDLine` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Email` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `application_ads1`
--

INSERT INTO `application_ads1` (`ID`, `ApplicantID`, `Address1`, `Province`, `District`, `Sub_district`, `Zipcode`, `Phone`, `IDLine`, `Email`) VALUES
(1, '250318094359', '123456', '7', '1601', '160101', '15000', '456434', '43434', '34434');

-- --------------------------------------------------------

--
-- Table structure for table `application_ads2`
--

CREATE TABLE `application_ads2` (
  `AddressID` int(11) NOT NULL,
  `ApplicantID` int(11) NOT NULL,
  `StreetAddress2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `City` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `State` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `PostalCode` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `application_data`
--

CREATE TABLE `application_data` (
  `ApplicantID` int(11) NOT NULL,
  `FirstName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `LastName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `DateOfBirth` date NOT NULL,
  `Email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ProgramApplied` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Status` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `application_edu`
--

CREATE TABLE `application_edu` (
  `ID` int(11) NOT NULL,
  `ApplicantID` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT 'รหัสสมัคร',
  `pdpa` int(2) NOT NULL COMMENT 'ยืนยันข้อมูลส่วนบุคคล',
  `type_application` int(2) NOT NULL COMMENT 'รูปแบบการสมัคร',
  `course` int(2) NOT NULL COMMENT 'หลักสูตรเลือก',
  `education` int(2) NOT NULL COMMENT 'ระดับการศึกษา',
  `Educationlevel_O` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ระดับการศึกษาอื่น',
  `edu_plan` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'แผนการเรียน',
  `gpa` varchar(5) COLLATE utf8_unicode_ci NOT NULL COMMENT 'เกรด (GPA)',
  `tcas` int(2) NOT NULL COMMENT 'สถาณะ TCAS'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `application_edu`
--

INSERT INTO `application_edu` (`ID`, `ApplicantID`, `pdpa`, `type_application`, `course`, `education`, `Educationlevel_O`, `edu_plan`, `gpa`, `tcas`) VALUES
(1, '250318094359', 1, 1, 1, 1, '', 'วิทย์ – คณิต', '3.50', 1);

-- --------------------------------------------------------

--
-- Table structure for table `application_ids`
--

CREATE TABLE `application_ids` (
  `ApplicationID` int(11) NOT NULL,
  `ApplicantID` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT 'รหัสสมัคร',
  `ApplicationDate` date NOT NULL COMMENT 'วันที่ทำการสมัคร'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `application_ids`
--

INSERT INTO `application_ids` (`ApplicationID`, `ApplicantID`, `ApplicationDate`) VALUES
(1, '250318094359', '2025-03-18');

-- --------------------------------------------------------

--
-- Table structure for table `application_payments`
--

CREATE TABLE `application_payments` (
  `payment_id` int(11) NOT NULL,
  `ApplicantID` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `qr_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expiry_time` datetime NOT NULL,
  `status` enum('pending','processing','completed','expired') COLLATE utf8_unicode_ci DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `application_payments`
--

INSERT INTO `application_payments` (`payment_id`, `ApplicantID`, `amount`, `qr_code`, `expiry_time`, `status`) VALUES
(1, '250318135627', '400.00', 'upload/250318135627.png', '2025-03-21 13:56:27', 'pending'),
(2, '250318135843', '400.00', 'upload/250318135843.png', '2025-03-21 13:58:43', 'pending'),
(3, '250318163321', '400.00', 'upload/250318163321.png', '2025-03-21 16:33:21', 'pending'),
(4, '250318163343', '400.00', 'upload/250318163343.png', '2025-03-21 16:33:43', 'pending'),
(5, '250318163357', '400.00', 'upload/250318163357.png', '2025-03-21 16:33:57', 'pending'),
(6, '250318163407', '400.00', 'upload/250318163407.png', '2025-03-21 16:34:07', 'pending'),
(7, '250318164206', '400.00', 'upload/250318164206.png', '2025-03-21 16:42:06', 'pending'),
(8, '250318164656', '400.00', 'upload/250318164656.png', '2025-03-21 16:46:56', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `course_application`
--

CREATE TABLE `course_application` (
  `ID` int(11) NOT NULL,
  `ID_Course` int(2) NOT NULL COMMENT 'ID หลักสูตร',
  `Name_Course` varchar(150) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ชื่อหลักสูตร',
  `Status` int(2) NOT NULL COMMENT 'สถาณะ 1=Active, 2=MA, 0=Offline'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `course_application`
--

INSERT INTO `course_application` (`ID`, `ID_Course`, `Name_Course`, `Status`) VALUES
(1, 1, 'ระดับปริญญาตรี หลักสูตรพยาบาลศาสตรบัณฑิต คณะพยาบาลศาสตร์', 1),
(2, 3, 'ระดับปริญญาตรี หลักสูตรกายภาพบำบัดบัณฑิต คณะกายภาพบำบัด', 1),
(3, 2, 'ระดับปริญญาตรี หลักสูตรวิทยาศาสตรบัณฑิต สาขาวิชาจิตวิทยา คณะจิตวิทยา', 1),
(4, 4, 'ระดับปริญญาโท หลักสูตรพยาบาลศาสตรมหาบัณฑิต คณะพยาบาลศาสตร์', 1),
(5, 7, 'หลักสูตรระยะสั้น หลักสูตรผู้ช่วยพยาบาล(PN) คณะพยาบาลศาสตร์', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fn_application`
--

CREATE TABLE `fn_application` (
  `ID` int(11) NOT NULL,
  `ID_Type` int(2) NOT NULL COMMENT 'ID รูปแบบการสมัคร',
  `ID_Side` int(2) NOT NULL COMMENT 'ID คณะ',
  `ID_Course` int(2) NOT NULL COMMENT 'ID หลักสูตร',
  `GPA` decimal(4,2) NOT NULL,
  `Date_Start` date NOT NULL COMMENT 'วันที่เริ่มสมัคร',
  `Date_End` date NOT NULL COMMENT 'วันที่ปิดรับสมัคร',
  `Status` int(11) NOT NULL COMMENT 'สถาณะ 1=Active, 0=Offline, 2=MA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fn_application`
--

INSERT INTO `fn_application` (`ID`, `ID_Type`, `ID_Side`, `ID_Course`, `GPA`, `Date_Start`, `Date_End`, `Status`) VALUES
(1, 1, 1, 1, '3.00', '2025-03-01', '2025-03-31', 1),
(2, 1, 2, 2, '2.00', '2025-03-01', '2025-03-31', 1),
(3, 1, 3, 3, '2.00', '2025-03-01', '2025-03-31', 1),
(4, 2, 1, 1, '3.50', '2025-03-01', '2025-03-31', 1),
(5, 2, 2, 2, '2.00', '2025-03-01', '2025-03-31', 1),
(6, 2, 3, 3, '2.00', '2025-03-01', '2025-03-31', 1),
(7, 6, 1, 1, '3.00', '2025-03-01', '2025-03-31', 1),
(8, 6, 2, 2, '2.00', '2025-03-01', '2025-03-31', 1),
(9, 6, 3, 3, '2.00', '2025-03-01', '2025-03-31', 1),
(10, 7, 1, 7, '2.00', '2025-03-01', '2025-03-31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_notifications`
--

CREATE TABLE `payment_notifications` (
  `id` int(11) NOT NULL,
  `transRef` varchar(30) NOT NULL,
  `payeeId` varchar(15) NOT NULL,
  `transDate` date NOT NULL,
  `transTime` time NOT NULL,
  `channel` varchar(2) NOT NULL,
  `termId` varchar(20) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `reference1` varchar(30) NOT NULL,
  `reference2` varchar(30) DEFAULT NULL,
  `fromBank` varchar(3) NOT NULL,
  `qr_code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment_notifications`
--

INSERT INTO `payment_notifications` (`id`, `transRef`, `payeeId`, `transDate`, `transTime`, `channel`, `termId`, `amount`, `reference1`, `reference2`, `fromBank`, `qr_code`, `created_at`) VALUES
(1, 'TXN250311085824', '099400018814500', '2025-03-11', '08:58:24', 'A', 'S048B09801010001', '1500.75', 'REF250311085824', '', '002', 'upload/TXN250311085824.png', '2025-03-11 01:58:24');

-- --------------------------------------------------------

--
-- Table structure for table `status_application`
--

CREATE TABLE `status_application` (
  `ID` int(11) NOT NULL,
  `ID_Status` int(2) NOT NULL,
  `Name_Status` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `status_application`
--

INSERT INTO `status_application` (`ID`, `ID_Status`, `Name_Status`) VALUES
(1, 1, 'Active'),
(2, 2, 'Maintenance'),
(3, 0, 'Offline');

-- --------------------------------------------------------

--
-- Table structure for table `study_plan`
--

CREATE TABLE `study_plan` (
  `ID` int(11) NOT NULL,
  `Name_plan` varchar(150) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `study_plan`
--

INSERT INTO `study_plan` (`ID`, `Name_plan`) VALUES
(1, 'วิทย์ – คณิต'),
(2, 'ศิลป์ – คำนวณ'),
(3, 'ศิลป์ – ภาษา'),
(4, 'ศิลป์ – สังคม '),
(5, 'ศิลป์ – ทั่วไป');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `payeeId` varchar(15) COLLATE utf32_unicode_ci NOT NULL,
  `transDate` date NOT NULL,
  `transTime` time NOT NULL,
  `transRef` varchar(20) COLLATE utf32_unicode_ci NOT NULL,
  `channel` varchar(2) COLLATE utf32_unicode_ci NOT NULL,
  `termId` varchar(20) COLLATE utf32_unicode_ci NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `reference1` varchar(30) COLLATE utf32_unicode_ci NOT NULL,
  `fromBank` varchar(3) COLLATE utf32_unicode_ci NOT NULL,
  `path_qr` varchar(150) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `payeeId`, `transDate`, `transTime`, `transRef`, `channel`, `termId`, `amount`, `reference1`, `fromBank`, `path_qr`) VALUES
(1, '1234567890123', '2024-03-18', '12:30:00', '000999123456789', 'A', 'S048B09801010001', '1500.75', '123456789', '002', ''),
(2, '9876543210987', '2024-03-19', '14:45:30', '000888123456789', 'I', 'S123B09801010002', '2200.50', '987654321', '005', ''),
(5, '099400018814500', '2025-03-18', '16:31:54', '250318163154', 'A', '250318163154', '400.00', '250318163154', '002', 'upload/250318163154.png'),
(6, '099400018814500', '2025-03-18', '16:33:43', '250318163343', 'A', '250318163343', '400.00', '250318163343', '002', 'upload/250318163343.png');

-- --------------------------------------------------------

--
-- Table structure for table `type_application`
--

CREATE TABLE `type_application` (
  `ID` int(11) NOT NULL,
  `ID_Type` int(2) NOT NULL COMMENT 'ID รูปแบบการสมัคร',
  `Type_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ชื่อรูปแบบการสมัคร',
  `Status` int(11) NOT NULL COMMENT 'สถาณะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `type_application`
--

INSERT INTO `type_application` (`ID`, `ID_Type`, `Type_name`, `Status`) VALUES
(1, 1, 'หลักสูตรปริญญาตรี รอบ Portfolio', 1),
(2, 2, 'หลักสูตรปริญญาตรี รอบ Quota', 1),
(3, 3, 'หลักสูตรปริญญาตรี TCAS รอบที่ 3 (Admission1)', 1),
(4, 4, 'หลักสูตรปริญญาตรี TCAS รอบที่ 4 (Admission2)', 1),
(5, 5, 'หลักสูตรปริญญาตรี TCAS รอบที่ 4 (Direct Admission)', 1),
(6, 6, 'หลักสูตรปริญญาตรี รอบ รับตรง', 1),
(7, 7, 'หลักสูตรระยะสั้น', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_keys`
--
ALTER TABLE `api_keys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `api_key` (`api_key`);

--
-- Indexes for table `api_users`
--
ALTER TABLE `api_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `application_ads1`
--
ALTER TABLE `application_ads1`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `application_ads2`
--
ALTER TABLE `application_ads2`
  ADD PRIMARY KEY (`AddressID`),
  ADD KEY `ApplicantID` (`ApplicantID`);

--
-- Indexes for table `application_data`
--
ALTER TABLE `application_data`
  ADD PRIMARY KEY (`ApplicantID`);

--
-- Indexes for table `application_edu`
--
ALTER TABLE `application_edu`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `application_ids`
--
ALTER TABLE `application_ids`
  ADD PRIMARY KEY (`ApplicationID`);

--
-- Indexes for table `application_payments`
--
ALTER TABLE `application_payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `course_application`
--
ALTER TABLE `course_application`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `fn_application`
--
ALTER TABLE `fn_application`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `payment_notifications`
--
ALTER TABLE `payment_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_application`
--
ALTER TABLE `status_application`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `study_plan`
--
ALTER TABLE `study_plan`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transRef` (`transRef`);

--
-- Indexes for table `type_application`
--
ALTER TABLE `type_application`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api_keys`
--
ALTER TABLE `api_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `api_users`
--
ALTER TABLE `api_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `application_ads1`
--
ALTER TABLE `application_ads1`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `application_ads2`
--
ALTER TABLE `application_ads2`
  MODIFY `AddressID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `application_edu`
--
ALTER TABLE `application_edu`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `application_ids`
--
ALTER TABLE `application_ids`
  MODIFY `ApplicationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `application_payments`
--
ALTER TABLE `application_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `course_application`
--
ALTER TABLE `course_application`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fn_application`
--
ALTER TABLE `fn_application`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payment_notifications`
--
ALTER TABLE `payment_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `status_application`
--
ALTER TABLE `status_application`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `study_plan`
--
ALTER TABLE `study_plan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `type_application`
--
ALTER TABLE `type_application`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `application_ads2`
--
ALTER TABLE `application_ads2`
  ADD CONSTRAINT `application_ads2_ibfk_1` FOREIGN KEY (`ApplicantID`) REFERENCES `application_data` (`ApplicantID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
