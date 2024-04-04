-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2024 at 01:45 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ict_asset`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `companyid` int(11) NOT NULL,
  `abbreviation` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `added_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` bit(2) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`companyid`, `abbreviation`, `name`, `added_on`, `added_by`, `updated_on`, `updated_by`, `is_deleted`) VALUES
(1, 'MAC', 'MAC BUILDERS', '2020-12-03 15:23:30', NULL, '2020-12-03 15:19:17', NULL, b'00'),
(2, 'PMI', 'PREMIUM MEGASTUCTURES INC.', '2020-12-03 15:23:30', NULL, '2020-12-03 15:19:17', NULL, b'00'),
(3, 'MBI', 'MEGASHIP BUILDERS INC.', '2020-12-03 15:23:30', NULL, '2020-12-03 15:19:17', NULL, b'00'),
(4, 'OCS', 'OCTAGON CONCRETE SOLUTION', '2020-12-03 15:23:30', NULL, '2020-12-03 15:19:17', NULL, b'00'),
(5, 'BDT', 'BADMINTON', '2020-12-03 15:23:30', NULL, '2020-12-03 15:19:17', NULL, b'00'),
(6, 'TMP', 'TEMPURA HAUS', '2020-12-03 15:23:30', NULL, '2020-12-03 15:19:17', NULL, b'00'),
(7, 'IMC', 'INDUSTRY MOVERS CORPORATION', '2021-05-21 09:38:11', 3, '2021-05-21 03:36:46', NULL, b'00'),
(8, 'CSC', 'CONCRETE STONE CORPORATION', '2021-08-24 14:21:23', 11, NULL, NULL, b'00'),
(9, 'MCC GROUP', 'MICHAEL CHUA', '2022-05-20 16:57:31', 6, NULL, NULL, b'00');

-- --------------------------------------------------------

--
-- Table structure for table `consumable_item`
--

CREATE TABLE `consumable_item` (
  `consumableid` int(11) NOT NULL,
  `companyid` int(11) NOT NULL DEFAULT 1,
  `item_typeid` int(11) NOT NULL,
  `cbalance` varchar(255) NOT NULL DEFAULT '0',
  `unit` varchar(50) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `added_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` bit(2) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consumable_receivables`
--

CREATE TABLE `consumable_receivables` (
  `receivableid` int(11) NOT NULL,
  `consumableid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `amount` decimal(19,2) NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `rf` varchar(50) NOT NULL,
  `added_by` int(11) DEFAULT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `is_deleted` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consumable_request`
--

CREATE TABLE `consumable_request` (
  `requestid` int(11) NOT NULL,
  `consumableid` int(11) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'PENDING',
  `approved_by` varchar(100) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `is_deleted` bit(2) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_user`
--

CREATE TABLE `employee_user` (
  `empid` int(11) NOT NULL,
  `companyid` int(11) NOT NULL,
  `empname` varchar(255) NOT NULL,
  `location_dept` varchar(255) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `added_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_user`
--

INSERT INTO `employee_user` (`empid`, `companyid`, `empname`, `location_dept`, `added_on`, `added_by`, `updated_on`, `updated_by`, `is_deleted`) VALUES
(1, 1, 'MA. NIÑA  SOLLANO', 'MAC OPERATION DEPARTMENT', '2023-05-04 11:55:48', 6, NULL, NULL, 0),
(2, 1, 'MARYROSE YUMANG', 'MAC OPERATION DEPARTMENT', '2023-05-04 11:56:19', 6, NULL, NULL, 0),
(3, 1, 'RISTY VILLASO', 'MAC OPERATION DEPARTMENT', '2023-05-04 12:01:11', 6, NULL, NULL, 0),
(4, 1, 'EDGENE SENEPETE', 'MAC PMD', '2023-05-04 14:21:40', 6, NULL, NULL, 0),
(5, 1, 'AIRA JANE PAJARON', 'MAC PMD', '2023-05-04 14:26:44', 6, NULL, NULL, 0),
(6, 1, 'RO-ANNE  GOPIO', 'MAC PROJECT MONITORING', '2023-05-04 14:53:22', 6, NULL, NULL, 0),
(7, 1, 'LUCY MARIE TEVES', 'MAC PROJECT MONITORING', '2023-05-04 15:59:34', 6, NULL, NULL, 0),
(8, 1, 'RACHEL ESTRERA', 'MAC OPERATION', '2023-05-04 16:01:48', 6, NULL, NULL, 0),
(9, 1, 'JEFFERSON  PACALDO', 'MAC OPERATION', '2023-05-04 16:02:27', 6, NULL, NULL, 0),
(10, 1, 'CRYSTAL EDEN ISRAEL', 'MAC PROJECT MONITORING', '2023-05-04 16:03:15', 6, NULL, NULL, 0),
(11, 1, 'JOAN COCA', 'MAC PROJECT MONITORING', '2023-05-04 16:03:58', 6, NULL, NULL, 0),
(12, 1, 'ROMER CANTILLA', 'MAC OPERATION', '2023-05-04 16:12:00', 6, NULL, NULL, 0),
(13, 1, 'ELSIE VILLARIAS', 'MAC PROJECT MONITORING', '2023-05-04 16:48:59', 6, NULL, NULL, 0),
(14, 1, 'GLAYZA CABACABA', 'MAC PROJECT MONITORING', '2023-05-05 09:16:35', 6, NULL, NULL, 0),
(15, 1, 'MERENOLD CARITAN', 'MAC HR', '2023-05-05 09:39:01', 6, NULL, NULL, 0),
(16, 1, 'CLARISSE CAWALING', 'MAC SAFETY', '2023-05-05 10:04:20', 13, NULL, NULL, 0),
(17, 1, 'JAMES PAUL  SUSADA', 'MAC HR', '2023-05-05 11:15:23', 6, NULL, NULL, 0),
(18, 1, 'MA. ELLAINE  ARROFO', 'MAC ', '2023-05-05 11:15:58', 6, NULL, NULL, 0),
(19, 1, 'JENNIFER ARBAN', 'MAC MOTORPOOL', '2023-05-05 13:07:09', 6, NULL, NULL, 0),
(20, 1, 'JESSEL VELASQUEZ', 'MAC ACCOUNTING', '2023-05-05 13:33:48', 6, NULL, NULL, 0),
(21, 1, 'MARK JASON COLON', ' MAC ICT ', '2023-05-08 16:14:51', 6, NULL, NULL, 0),
(22, 1, 'RESMAR CORDERO', 'MAC ICT', '2023-05-08 16:27:54', 13, NULL, NULL, 0),
(23, 1, 'GRECILDA RABOR', 'MAC MARKETING', '2023-05-24 09:36:38', 13, NULL, NULL, 0),
(24, 1, 'ANECITO  SON', 'MAC MARKETING', '2023-05-24 09:53:05', 6, NULL, NULL, 0),
(25, 1, 'GIOVANNI GALLO', 'MAC MARKETING', '2023-05-24 10:09:14', 6, NULL, NULL, 0),
(26, 1, 'DONNA ROSE NAPOLES', 'MAC MARKETING', '2023-05-24 10:12:17', 6, NULL, NULL, 0),
(27, 1, 'MA. MIDALYN GANANCIAS', 'MAC AUDIT', '2023-05-24 11:16:54', 6, NULL, NULL, 0),
(28, 1, 'MARICHU PITOGO', 'MAC HUMAN RESOURCE DEPARTMENT', '2023-05-25 09:19:10', 6, NULL, NULL, 0),
(29, 1, 'SKIENNY SEDNY BURLAS', 'MAC HUMAN RESOURCE', '2023-05-26 10:29:35', 6, NULL, NULL, 0),
(30, 1, 'MELISSA OMAMBAC', 'MAC WAREHOUSE', '2023-05-26 10:30:15', 6, NULL, NULL, 0),
(31, 1, 'DINA SAING', 'MAC WAREHOUSE', '2023-05-26 10:30:42', 6, NULL, NULL, 0),
(32, 1, 'ROWENA  REBUYA', 'MAC WAREHOUSE', '2023-05-26 10:31:06', 6, NULL, NULL, 0),
(33, 1, 'RESMAR CORDERO', 'MAC ICT', '2023-05-26 10:37:35', 6, NULL, NULL, 0),
(34, 1, 'IRENE CASIMERO', 'MAC ACCOUNTING', '2023-05-26 10:32:04', 6, NULL, NULL, 0),
(35, 1, 'MARY JANE CASUCO', 'MAC ACCOUNTING', '2023-05-26 10:32:28', 6, NULL, NULL, 0),
(36, 1, 'GLENDA CALUMPAG', 'MAC ACCOUNTING', '2023-05-26 10:32:44', 6, NULL, NULL, 0),
(37, 1, 'RONA BAGARINAO', 'MAC ACCOUNTING', '2023-05-26 10:32:56', 6, NULL, NULL, 0),
(38, 1, 'MILVA SONGAHID', 'MAC ACCOUNTING', '2023-05-26 10:33:09', 6, NULL, NULL, 0),
(39, 1, 'ROSA MAE BOHOL', 'MAC ACCOUNTING', '2023-05-26 10:33:24', 6, NULL, NULL, 0),
(40, 1, 'CECILE DAÑO', 'MAC GENERAL SERVICES', '2023-05-26 10:33:38', 6, NULL, NULL, 0),
(41, 1, 'MARIBEL  ALQUINO', 'MAC GENERAL SERVICES', '2023-05-26 10:33:56', 6, NULL, NULL, 0),
(42, 1, 'RAMIL ARELLANO', 'MAC GENERAL SERVICES', '2023-05-26 10:34:08', 6, NULL, NULL, 0),
(43, 1, 'ALMIRA JUANITE', 'MAC GENERAL SERVICES', '2023-05-26 10:34:25', 6, NULL, NULL, 0),
(44, 1, 'ISAAC MANTO', 'MAC MOTORPOOL', '2023-05-26 10:34:46', 6, NULL, NULL, 0),
(45, 1, 'JENNIFER ARBAN', 'MAC MOTORPOOL', '2023-05-26 10:35:05', 6, NULL, NULL, 0),
(46, 1, 'ANGELICA  MEJIA', 'MAC MOTORPOOL', '2023-05-26 10:35:17', 6, NULL, NULL, 0),
(47, 1, 'JEFFREY LAGUA', 'MAC MOTORPOOL', '2023-05-26 10:35:35', 6, NULL, NULL, 0),
(48, 1, 'CLARICE CAWALING', 'MAC SAFETY', '2023-05-26 10:36:16', 6, NULL, NULL, 0),
(49, 1, 'PAULA ESTRERA', 'MAC SAFETY', '2023-05-26 10:36:33', 6, NULL, NULL, 0),
(50, 1, 'RASALIE BROCOY', 'MAC ICT', '2023-05-26 10:37:10', 6, NULL, NULL, 0),
(51, 1, 'MARK JASON COLON', 'MAC ICT', '2023-05-26 10:37:23', 6, NULL, NULL, 0),
(53, 1, 'NORMALYN  ALBARICO', 'MAC WHAREHOUSE', '2023-05-26 15:59:37', 6, NULL, NULL, 0),
(54, 1, 'CHONA ESMERO', 'MAC TREASURY', '2023-05-31 11:26:39', 6, NULL, NULL, 0),
(55, 1, 'JENNIFER TANDOY', 'MAC QUALITY CONTROL', '2023-05-31 16:53:07', 6, NULL, NULL, 0),
(56, 1, 'CHRISTIFANIE LYN GUIÑAREZ', 'MAC QUALITY CONTROL', '2023-05-31 17:27:28', 6, NULL, NULL, 0),
(57, 1, 'MICHELLE BERNAL', 'MAC QUALITY CONTROL', '2023-06-01 15:41:24', 6, NULL, NULL, 0),
(58, 1, 'LLOYD KLEIZER ODAN', 'MAC QUALITY CONTROL', '2023-06-01 16:03:47', 6, NULL, NULL, 0),
(59, 1, 'GELICRIS TABAY', 'MAC QUALITY CONTROL', '2023-06-01 16:51:07', 6, NULL, NULL, 0),
(60, 1, 'JUDITH RIO', 'MAC QUALITY CONTROL', '2023-06-01 17:07:31', 6, NULL, NULL, 0),
(61, 1, 'CRESCILDA BACO', 'MAC ICT', '2023-06-07 17:29:10', 6, NULL, NULL, 0),
(62, 1, 'DEXTER RAGA', 'MAC PLANNING AND ESTIMATING', '2023-06-13 13:40:05', 6, NULL, NULL, 0),
(63, 1, 'RENATO VIARINO', 'MAC PAGSANGA-AN PROJECT', '2023-06-19 09:23:50', 6, NULL, NULL, 0),
(64, 1, 'JAIRUS ARCONILA', 'MAC BAYBAY DREDGING PORT PROJECT', '2023-06-19 09:26:16', 6, NULL, NULL, 0),
(65, 1, 'CAAP TADP', 'MAC TACLOBAN AIRPORT', '2023-06-20 16:48:07', 6, NULL, NULL, 0),
(66, 1, 'JUNRY PANILAG', 'MAC BOHOL GETAFE PROJECT', '2023-06-21 15:44:10', 6, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `for_repair`
--

CREATE TABLE `for_repair` (
  `repairid` int(11) NOT NULL,
  `ticket` varchar(100) NOT NULL,
  `assetid` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `problem` varchar(255) NOT NULL,
  `solution` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `added_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` bit(2) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_addon`
--

CREATE TABLE `item_addon` (
  `addonid` int(11) NOT NULL,
  `addonname` varchar(50) NOT NULL,
  `asset_code` varchar(50) NOT NULL,
  `serial_no` varchar(50) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `receive_date` date NOT NULL,
  `receive_no` varchar(50) NOT NULL,
  `supplier` varchar(50) NOT NULL,
  `payment_order_no` varchar(50) NOT NULL,
  `invoice_date` date NOT NULL,
  `item_amount` decimal(19,2) NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `warranty` varchar(50) NOT NULL,
  `rf` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `added_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_removed` bit(2) NOT NULL DEFAULT b'0',
  `is_deleted` bit(2) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_addon`
--

INSERT INTO `item_addon` (`addonid`, `addonname`, `asset_code`, `serial_no`, `brand`, `model`, `description`, `receive_date`, `receive_no`, `supplier`, `payment_order_no`, `invoice_date`, `item_amount`, `invoice`, `warranty`, `rf`, `status`, `added_on`, `added_by`, `updated_on`, `updated_by`, `is_removed`, `is_deleted`) VALUES
(1, 'RAM', 'ICT-DC-000001', 'sfdsf', 'dfdsff', 'dfdfdf', 'ASUS memory', '2024-03-15', 'EDSFWQ5R2355', 'SFRSFDSFDF343444', 'GVFGSFDFF34DF', '2024-03-15', '0.00', 'N/A', '2025-03-15', 'SRFWRER2342343243', 'ACTIVE', '2024-03-15 11:40:25', 6, NULL, NULL, b'00', b'00'),
(2, 'VIDEOCARD', 'ICT-DC-000001', '', '', '', '', '2024-03-15', 'EDSFWQ5R2355', 'SFRSFDSFDF343444', 'GVFGSFDFF34DF', '2024-03-15', '0.00', 'N/A', '2025-03-15', 'SRFWRER2342343243', 'ACTIVE', '2024-03-15 11:40:25', 6, NULL, NULL, b'00', b'00'),
(3, 'MOTHERBOARD', 'ICT-DC-000001', '', '', '', '', '2024-03-15', 'EDSFWQ5R2355', 'SFRSFDSFDF343444', 'GVFGSFDFF34DF', '2024-03-15', '0.00', 'N/A', '2025-03-15', 'SRFWRER2342343243', 'ACTIVE', '2024-03-15 11:40:25', 6, NULL, NULL, b'00', b'00'),
(4, 'POWER-SUPPLY', 'ICT-DC-000001', '', '', '', '', '2024-03-15', 'EDSFWQ5R2355', 'SFRSFDSFDF343444', 'GVFGSFDFF34DF', '2024-03-15', '0.00', 'N/A', '2025-03-15', 'SRFWRER2342343243', 'ACTIVE', '2024-03-15 11:40:25', 6, NULL, NULL, b'00', b'00'),
(5, 'RAM', 'ICT-DC-000002', 'sdf', 'dsfdsf', 'fsfd', 'dfdfdfdff', '2024-03-15', 'EDSFWQ5R2355', 'ASDADAS', 'ASDA23123', '2024-03-15', '0.00', 'N/A', '2025-03-15', 'SRFWRER2342343243', 'ACTIVE', '2024-03-15 11:44:39', 6, NULL, NULL, b'00', b'00'),
(6, 'VIDEOCARD', 'ICT-DC-000002', '', '', '', '', '2024-03-15', 'EDSFWQ5R2355', 'ASDADAS', 'ASDA23123', '2024-03-15', '0.00', 'N/A', '2025-03-15', 'SRFWRER2342343243', 'ACTIVE', '2024-03-15 11:44:39', 6, NULL, NULL, b'00', b'00'),
(7, 'MOTHERBOARD', 'ICT-DC-000002', '', '', '', '', '2024-03-15', 'EDSFWQ5R2355', 'ASDADAS', 'ASDA23123', '2024-03-15', '0.00', 'N/A', '2025-03-15', 'SRFWRER2342343243', 'ACTIVE', '2024-03-15 11:44:39', 6, NULL, NULL, b'00', b'00'),
(8, 'POWER-SUPPLY', 'ICT-DC-000002', '', '', '', '', '2024-03-15', 'EDSFWQ5R2355', 'ASDADAS', 'ASDA23123', '2024-03-15', '0.00', 'N/A', '2025-03-15', 'SRFWRER2342343243', 'ACTIVE', '2024-03-15 11:44:39', 6, NULL, NULL, b'00', b'00'),
(9, 'RAM', 'ICT-DC-000003', 'n/a', 'n/a', 'n/a', 'n/a', '2024-03-15', 'N/A', 'N/A', 'N/A', '0001-01-01', '0.00', 'N/A', '0001-01-01', 'N/A', 'ACTIVE', '2024-03-15 15:13:40', 6, NULL, NULL, b'00', b'00'),
(10, 'STORAGE', 'ICT-DC-000003', 'n/a', 'n/a', 'n/a', 'n/a', '2024-03-15', 'N/A', 'N/A', 'N/A', '0001-01-01', '0.00', 'N/A', '0001-01-01', 'N/A', 'ACTIVE', '2024-03-15 15:13:40', 6, NULL, NULL, b'00', b'00'),
(11, 'MOTHERBOARD', 'ICT-DC-000003', 'N/A', 'N/A', 'N/A', '', '2024-03-15', 'N/A', 'N/A', 'N/A', '0001-01-01', '0.00', 'N/A', '0001-01-01', 'N/A', 'ACTIVE', '2024-03-15 15:13:40', 6, NULL, NULL, b'00', b'00'),
(12, 'POWER-SUPPLY', 'ICT-DC-000003', 'N/A', 'N/A', 'N/A', '', '2024-03-15', 'N/A', 'N/A', 'N/A', '0001-01-01', '0.00', 'N/A', '0001-01-01', 'N/A', 'ACTIVE', '2024-03-15 15:13:40', 6, NULL, NULL, b'00', b'00'),
(13, 'RAM', 'ICT-DC-000004', 'sdswds', 'sdsds', 'sdsd', 'ASUS logitech', '2024-03-19', '325SDFWE324', 'SFSFFSFDSF', '32523542342', '2024-03-19', '234.00', 'N/A', '2025-03-19', 'W545SDFG345', 'ACTIVE', '2024-03-19 10:40:56', 6, NULL, NULL, b'00', b'00'),
(14, 'STORAGE', 'ICT-DC-000004', 'sdd', 'sds', 'sdsd', 'sddsd', '2024-03-19', '325SDFWE324', 'SFSFFSFDSF', '32523542342', '2024-03-19', '0.00', 'N/A', '2025-03-19', 'W545SDFG345', 'ACTIVE', '2024-03-19 10:40:56', 6, NULL, NULL, b'00', b'00'),
(15, 'VIDEOCARD', 'ICT-DC-000004', 'SDS', 'SD', 'SDS', 'DSDSS', '2024-03-19', '325SDFWE324', 'SFSFFSFDSF', '32523542342', '2024-03-19', '0.00', 'N/A', '2025-03-19', 'W545SDFG345', 'ACTIVE', '2024-03-19 10:40:56', 6, NULL, NULL, b'00', b'00'),
(16, 'MOTHERBOARD', 'ICT-DC-000004', 'SDS', 'SDS', 'SDSD', 'SDS', '2024-03-19', '325SDFWE324', 'SFSFFSFDSF', '32523542342', '2024-03-19', '0.00', 'N/A', '2025-03-19', 'W545SDFG345', 'ACTIVE', '2024-03-19 10:40:56', 6, NULL, NULL, b'00', b'00'),
(17, 'POWER-SUPPLY', 'ICT-DC-000004', 'SDSDS', 'SDSD', 'SDSD', 'SDSS', '2024-03-19', '325SDFWE324', 'SFSFFSFDSF', '32523542342', '2024-03-19', '0.00', 'N/A', '2025-03-19', 'W545SDFG345', 'ACTIVE', '2024-03-19 10:40:56', 6, NULL, NULL, b'00', b'00'),
(18, 'RAM', 'ICT-DC-000005', 'ram', 'corsair', 'vengance', 'Allester X', '2024-03-19', 'N/A', 'N/A', 'N/A', '2024-03-19', '2000.00', 'N/A', '2025-03-19', 'N/A', 'ACTIVE', '2024-03-19 16:20:52', 6, NULL, NULL, b'00', b'00'),
(19, 'VIDEOCARD', 'ICT-DC-000005', '', '', '', '', '2024-03-19', 'N/A', 'N/A', 'N/A', '2024-03-19', '0.00', 'N/A', '2025-03-19', 'N/A', 'ACTIVE', '2024-03-19 16:20:52', 6, NULL, NULL, b'00', b'00'),
(20, 'MOTHERBOARD', 'ICT-DC-000005', '', '', '', '', '2024-03-19', 'N/A', 'N/A', 'N/A', '2024-03-19', '0.00', 'N/A', '2025-03-19', 'N/A', 'ACTIVE', '2024-03-19 16:20:52', 6, NULL, NULL, b'00', b'00'),
(21, 'POWER-SUPPLY', 'ICT-DC-000005', '', '', '', '', '2024-03-19', 'N/A', 'N/A', 'N/A', '2024-03-19', '0.00', 'N/A', '2025-03-19', 'N/A', 'ACTIVE', '2024-03-19 16:20:52', 6, NULL, NULL, b'00', b'00');

-- --------------------------------------------------------

--
-- Table structure for table `item_addon_history`
--

CREATE TABLE `item_addon_history` (
  `item_historyid` int(11) NOT NULL,
  `addonid` int(11) NOT NULL,
  `asset_code` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `datesrf` date NOT NULL,
  `srf` varchar(250) NOT NULL,
  `problem` varchar(1000) NOT NULL,
  `solution` varchar(1000) NOT NULL,
  `remarks` varchar(50) NOT NULL,
  `checkedby` varchar(250) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `added_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` bit(2) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_checkout`
--

CREATE TABLE `item_checkout` (
  `checkoutid` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `empid` int(11) NOT NULL,
  `srf` varchar(255) NOT NULL,
  `problem` varchar(255) NOT NULL,
  `solution` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `item_department` varchar(255) NOT NULL,
  `checkout_status` varchar(50) NOT NULL,
  `asset_code` varchar(50) NOT NULL,
  `approve_by` varchar(50) NOT NULL,
  `trans_no` varchar(255) NOT NULL DEFAULT '0',
  `added_by` int(11) DEFAULT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `is_deleted` bit(2) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_checkout`
--

INSERT INTO `item_checkout` (`checkoutid`, `itemid`, `empid`, `srf`, `problem`, `solution`, `remarks`, `item_department`, `checkout_status`, `asset_code`, `approve_by`, `trans_no`, `added_by`, `added_on`, `updated_by`, `updated_on`, `is_deleted`) VALUES
(1, 1, 2, 'TCKT# JK2024', 'Request Item', 'Deploy to MAC and MR to MARYROSE YUMANG', 'Deployed', 'MAC', 'APPROVED', 'ICT-AV-000001', 'RESMAR CORDERO', 'MR000001', 6, '2024-02-27 10:31:03', 6, '2024-02-27 10:31:23', b'00'),
(2, 1, 1, 'TCKT# JK22024', 'Request Item', 'Deploy to MAC  and MR to MA. NIÑA  SOLLANO', 'Deployed', 'MAC ', 'REJECTED', 'ICT-AV-000001', 'RESMAR CORDERO', 'MR000002', 6, '2024-02-27 10:33:33', 6, '2024-02-28 09:11:54', b'00'),
(3, 2, 3, 'TCKT# TEST214', 'Request Item', 'Deploy to MAC  and MR to RISTY VILLASO', 'Deployed', 'MAC ', 'APPROVED', 'ICT-MT-000001', 'RESMAR CORDERO', 'MR000003', 6, '2024-02-28 09:12:44', 6, '2024-02-28 09:13:42', b'00'),
(4, 1, 3, 'TCKT# TEST214', 'Request Item', 'Deploy to MAC  and MR to RISTY VILLASO', 'Deployed', 'MAC ', 'APPROVED', 'ICT-AV-000001', 'RESMAR CORDERO', 'MR000003', 6, '2024-02-28 09:12:44', 6, '2024-02-28 09:13:41', b'00'),
(5, 3, 3, 'RF# 12135FDR43', 'Request Item', 'Deploy to PMI  and MR to RISTY VILLASO', 'Deployed', 'PMI ', 'APPROVED', 'ICT-MS-000001', 'RESMAR CORDERO', 'MR000004', 6, '2024-03-15 11:37:41', 6, '2024-03-15 11:37:49', b'00'),
(6, 4, 3, 'RF# ERFW4R2343434', 'Request Item', 'Deploy to BDT  and MR to RISTY VILLASO', 'Deployed', 'BDT ', 'APPROVED', 'ICT-DC-000001', 'RESMAR CORDERO', 'MR000005', 6, '2024-03-15 11:41:35', 6, '2024-03-15 11:41:37', b'00'),
(7, 5, 3, 'TCKT# ZFAADASDSD', 'Request Item', 'Deploy to MAC  and MR to RISTY VILLASO', 'Deployed', 'MAC ', 'APPROVED', 'ICT-DC-000002', 'RESMAR CORDERO', 'MR000006', 6, '2024-03-15 11:45:05', 6, '2024-03-15 11:45:07', b'00'),
(8, 6, 3, 'RF# 23131231', 'Request Item', 'Deploy to PMI  and MR to RISTY VILLASO', 'Deployed', 'PMI ', 'APPROVED', 'ICT-MT-000002', 'RESMAR CORDERO', 'MR000007', 6, '2024-03-15 11:47:15', 6, '2024-03-15 11:47:17', b'00'),
(9, 7, 22, 'TCKT# 0000', 'Request Item', 'Deploy to MAC IT and MR to RESMAR CORDERO', 'Deployed', 'MAC IT', 'APPROVED', 'ICT-DC-000003', 'RESMAR CORDERO', 'MR000008', 6, '2024-03-15 15:14:08', 6, '2024-03-15 03:14:11', b'00'),
(10, 9, 33, 'TCKT# 0000', 'Request Item', 'Deploy to MAC ICT and MR to RESMAR CORDERO', 'Deployed', 'MAC ICT', 'APPROVED', 'ICT-KB-000001', 'RESMAR CORDERO', 'MR000009', 6, '2024-03-15 15:16:25', 6, '2024-03-15 03:16:29', b'00'),
(11, 8, 33, 'TCKT# 0000', 'Request Item', 'Deploy to MAC ICT and MR to RESMAR CORDERO', 'Deployed', 'MAC ICT', 'APPROVED', 'ICT-PR-000001', 'RESMAR CORDERO', 'MR000009', 6, '2024-03-15 15:16:25', 6, '2024-03-15 03:16:28', b'00'),
(12, 12, 33, 'TCKT# 0', 'Request Item', 'Deploy to MAC ICT and MR to RESMAR CORDERO', 'Deployed', 'MAC ICT', 'APPROVED', 'ICT-MT-000003', 'RESMAR CORDERO', 'MR000010', 6, '2024-03-15 15:19:09', 6, '2024-03-15 03:19:15', b'00'),
(13, 11, 33, 'TCKT# 0', 'Request Item', 'Deploy to MAC ICT and MR to RESMAR CORDERO', 'Deployed', 'MAC ICT', 'APPROVED', 'ICT-PS-000001', 'RESMAR CORDERO', 'MR000010', 6, '2024-03-15 15:19:10', 6, '2024-03-15 03:19:14', b'00'),
(14, 10, 33, 'TCKT# 0', 'Request Item', 'Deploy to MAC ICT and MR to RESMAR CORDERO', 'Deployed', 'MAC ICT', 'APPROVED', 'ICT-MS-000002', 'RESMAR CORDERO', 'MR000010', 6, '2024-03-15 15:19:10', 6, '2024-03-15 03:19:13', b'00'),
(15, 13, 49, 'TCKT# 0', 'Request Item', 'Deploy to OCS  and MR to PAULA ESTRERA', 'Deployed', 'OCS ', 'APPROVED', 'ICT-DC-000004', 'RESMAR CORDERO', 'MR000011', 6, '2024-03-19 10:42:44', 6, '2024-03-19 10:42:47', b'00'),
(16, 14, 10, 'TCKT# 1222', 'Request Item', 'Deploy to MAC  and MR to CRYSTAL EDEN ISRAEL', 'Deployed', 'MAC ', 'APPROVED', 'ICT-DC-000005', 'RESMAR CORDERO', 'MR000012', 6, '2024-03-19 16:21:32', 6, '2024-03-19 04:21:36', b'00');

-- --------------------------------------------------------

--
-- Table structure for table `item_deploy`
--

CREATE TABLE `item_deploy` (
  `item_deployid` int(11) NOT NULL,
  `empid` int(11) NOT NULL,
  `itemid` int(50) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `added_by` int(50) NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` bit(2) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_deploy`
--

INSERT INTO `item_deploy` (`item_deployid`, `empid`, `itemid`, `added_on`, `added_by`, `updated_on`, `updated_by`, `is_deleted`) VALUES
(1, 2, 1, '2024-02-27 10:31:23', 6, '0000-00-00 00:00:00', 6, b'01'),
(2, 3, 1, '2024-02-28 09:13:41', 6, NULL, NULL, b'00'),
(3, 3, 2, '2024-02-28 09:13:42', 6, NULL, NULL, b'00'),
(4, 3, 3, '2024-03-15 11:37:49', 6, NULL, NULL, b'00'),
(5, 3, 4, '2024-03-15 11:41:37', 6, NULL, NULL, b'00'),
(6, 3, 5, '2024-03-15 11:45:07', 6, NULL, NULL, b'00'),
(7, 3, 6, '2024-03-15 11:47:17', 6, NULL, NULL, b'00'),
(8, 22, 7, '2024-03-15 15:14:11', 6, NULL, NULL, b'00'),
(9, 33, 8, '2024-03-15 15:16:28', 6, NULL, NULL, b'00'),
(10, 33, 9, '2024-03-15 15:16:29', 6, NULL, NULL, b'00'),
(11, 33, 10, '2024-03-15 15:19:13', 6, NULL, NULL, b'00'),
(12, 33, 11, '2024-03-15 15:19:14', 6, NULL, NULL, b'00'),
(13, 33, 12, '2024-03-15 15:19:15', 6, NULL, NULL, b'00'),
(14, 49, 13, '2024-03-19 10:42:47', 6, NULL, NULL, b'00'),
(15, 10, 14, '2024-03-19 16:21:36', 6, NULL, NULL, b'00');

-- --------------------------------------------------------

--
-- Table structure for table `item_disposed`
--

CREATE TABLE `item_disposed` (
  `disposeid` int(11) NOT NULL,
  `task` varchar(100) NOT NULL,
  `ticket` varchar(100) NOT NULL,
  `assetid` varchar(100) NOT NULL DEFAULT 'N/A',
  `type` varchar(100) NOT NULL,
  `brand` varchar(100) NOT NULL DEFAULT 'N/A',
  `model` varchar(100) NOT NULL DEFAULT 'N/A',
  `serial_number` varchar(100) NOT NULL DEFAULT 'N/A',
  `date_dispose` date NOT NULL,
  `reason` varchar(255) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` date DEFAULT NULL,
  `is_deleted` bit(2) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_history`
--

CREATE TABLE `item_history` (
  `item_historyid` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `datesrf` date NOT NULL,
  `srf` varchar(250) NOT NULL,
  `problem` varchar(1000) NOT NULL,
  `solution` varchar(1000) NOT NULL,
  `remarks` varchar(50) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `added_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` bit(2) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_history`
--

INSERT INTO `item_history` (`item_historyid`, `itemid`, `datesrf`, `srf`, `problem`, `solution`, `remarks`, `added_on`, `added_by`, `updated_on`, `updated_by`, `is_deleted`) VALUES
(1, 1, '2024-02-27', 'TCKT# JK2024', 'Request Item', 'Deploy to MAC and MR to MARYROSE YUMANG', 'Deployed', '2024-02-27 10:31:23', 6, NULL, NULL, b'00'),
(2, 1, '2024-02-27', 'JK2024', 'Turn Over Asset', 'Turn over asset from MARYROSE YUMANG of MAC', 'AVAILABLE', '2024-02-27 10:32:30', 6, NULL, NULL, b'00'),
(3, 1, '2024-02-28', 'TCKT# TEST214', 'Request Item', 'Deploy to MAC  and MR to RISTY VILLASO', 'Deployed', '2024-02-28 09:13:41', 6, NULL, NULL, b'00'),
(4, 2, '2024-02-28', 'TCKT# TEST214', 'Request Item', 'Deploy to MAC  and MR to RISTY VILLASO', 'Deployed', '2024-02-28 09:13:42', 6, NULL, NULL, b'00'),
(5, 3, '2024-03-15', 'RF# 12135FDR43', 'Request Item', 'Deploy to PMI  and MR to RISTY VILLASO', 'Deployed', '2024-03-15 11:37:49', 6, NULL, NULL, b'00'),
(6, 4, '2024-03-15', 'RF# ERFW4R2343434', 'Request Item', 'Deploy to BDT  and MR to RISTY VILLASO', 'Deployed', '2024-03-15 11:41:37', 6, NULL, NULL, b'00'),
(7, 5, '2024-03-15', 'TCKT# ZFAADASDSD', 'Request Item', 'Deploy to MAC  and MR to RISTY VILLASO', 'Deployed', '2024-03-15 11:45:07', 6, NULL, NULL, b'00'),
(8, 6, '2024-03-15', 'RF# 23131231', 'Request Item', 'Deploy to PMI  and MR to RISTY VILLASO', 'Deployed', '2024-03-15 11:47:17', 6, NULL, NULL, b'00'),
(9, 7, '2024-03-15', 'TCKT# 0000', 'Request Item', 'Deploy to MAC IT and MR to RESMAR CORDERO', 'Deployed', '2024-03-15 15:14:11', 6, NULL, NULL, b'00'),
(10, 8, '2024-03-15', 'TCKT# 0000', 'Request Item', 'Deploy to MAC ICT and MR to RESMAR CORDERO', 'Deployed', '2024-03-15 15:16:28', 6, NULL, NULL, b'00'),
(11, 9, '2024-03-15', 'TCKT# 0000', 'Request Item', 'Deploy to MAC ICT and MR to RESMAR CORDERO', 'Deployed', '2024-03-15 15:16:29', 6, NULL, NULL, b'00'),
(12, 10, '2024-03-15', 'TCKT# 0', 'Request Item', 'Deploy to MAC ICT and MR to RESMAR CORDERO', 'Deployed', '2024-03-15 15:19:13', 6, NULL, NULL, b'00'),
(13, 11, '2024-03-15', 'TCKT# 0', 'Request Item', 'Deploy to MAC ICT and MR to RESMAR CORDERO', 'Deployed', '2024-03-15 15:19:15', 6, NULL, NULL, b'00'),
(14, 12, '2024-03-15', 'TCKT# 0', 'Request Item', 'Deploy to MAC ICT and MR to RESMAR CORDERO', 'Deployed', '2024-03-15 15:19:15', 6, NULL, NULL, b'00'),
(15, 13, '2024-03-19', 'TCKT# 0', 'Request Item', 'Deploy to OCS  and MR to PAULA ESTRERA', 'Deployed', '2024-03-19 10:42:47', 6, NULL, NULL, b'00'),
(16, 14, '2024-03-19', 'TCKT# 1222', 'Request Item', 'Deploy to MAC  and MR to CRYSTAL EDEN ISRAEL', 'Deployed', '2024-03-19 16:21:36', 6, NULL, NULL, b'00'),
(17, 3, '2024-03-25', 'TASK# 1', 'N/A', 'N/A', 'PMS Conducted', '2024-03-25 08:42:21', 6, NULL, NULL, b'00'),
(18, 9, '2024-03-25', 'TASK# 1', 'N/A', 'N/A', 'PMS Conducted', '2024-03-25 08:42:21', 6, NULL, NULL, b'00'),
(19, 2, '2024-03-25', 'TASK# 1', 'N/A', 'N/A', 'PMS Conducted', '2024-03-25 08:42:21', 6, NULL, NULL, b'00'),
(20, 4, '2024-03-25', 'TASK# 1', 'N/A', 'N/A', 'PMS Conducted', '2024-03-25 08:42:21', 6, NULL, NULL, b'00'),
(21, 1, '2024-03-25', 'TASK# 1', 'N/A', 'N/A', 'PMS Conducted', '2024-03-25 08:42:21', 6, NULL, NULL, b'00'),
(22, 8, '2024-03-25', 'TASK# 1', 'N/A', 'N/A', 'PMS Conducted', '2024-03-25 08:42:21', 6, NULL, NULL, b'00'),
(23, 9, '2024-03-25', 'TASK# 2', 'N/A', 'N/A', 'PMS Conducted', '2024-03-25 08:43:07', 6, NULL, NULL, b'00');

-- --------------------------------------------------------

--
-- Table structure for table `item_type`
--

CREATE TABLE `item_type` (
  `item_typeid` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `type` varchar(50) NOT NULL,
  `category` int(11) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `added_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` bit(2) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_type`
--

INSERT INTO `item_type` (`item_typeid`, `code`, `type`, `category`, `added_on`, `added_by`, `updated_on`, `updated_by`, `is_deleted`) VALUES
(25, 'DC', 'DESKTOP', 1, '2020-12-04 15:00:33', NULL, NULL, NULL, b'00'),
(26, 'LC', 'LAPTOP', 1, '2020-12-04 15:02:10', NULL, NULL, NULL, b'00'),
(27, 'MT', 'MONITOR', 1, '2020-12-04 15:02:10', NULL, NULL, NULL, b'00'),
(28, 'KB', 'KEYBOARD', 1, '2020-12-04 15:02:36', NULL, NULL, NULL, b'00'),
(29, 'MS', 'MOUSE', 1, '2020-12-04 15:02:36', NULL, NULL, NULL, b'00'),
(30, 'AV', 'AVR', 1, '2020-12-04 15:03:01', NULL, NULL, NULL, b'00'),
(31, 'PS', 'UPS', 1, '2020-12-04 15:03:01', NULL, NULL, NULL, b'00'),
(34, 'SP', 'SERVICE PRINTER', 1, '2021-04-26 10:11:18', 3, '2021-04-26 04:10:47', NULL, b'00'),
(35, 'CV', 'CCTV CAMERA', 1, '2021-05-06 10:48:11', 3, '2021-05-06 04:25:29', NULL, b'00'),
(36, 'CS', 'CCTV POWER SUPPLY', 1, '2021-05-06 10:48:11', 3, '2021-05-06 04:25:29', NULL, b'00'),
(37, 'DR', 'DIGITAL VIDEO RECORDER', 1, '2021-05-06 10:58:43', 3, '2021-05-06 04:58:22', NULL, b'00'),
(38, 'NR', 'NETWORK VIDEO RECORDER', 1, '2021-05-06 11:09:27', 3, '2021-05-06 05:08:40', NULL, b'00'),
(41, 'PR', 'PRINTER', 1, '2021-05-12 16:39:16', 3, '2021-05-12 10:38:41', NULL, b'00'),
(42, 'PC', 'PHOTOCOPIER', 1, '2021-05-12 16:39:16', 3, '2021-05-12 10:38:41', NULL, b'00'),
(48, 'WD', 'WIRELESS DEVICES', 1, '2021-06-15 10:40:47', 6, NULL, NULL, b'00'),
(49, 'SH', 'SWITCH HUB', 1, '2021-06-15 13:23:47', 11, NULL, NULL, b'00'),
(51, 'ED', 'EXTERNAL HDD', 1, '2021-06-16 09:49:07', 11, NULL, NULL, b'00'),
(52, 'TP', 'TELEPHONE', 1, '2021-06-16 10:24:55', 11, NULL, NULL, b'00'),
(53, 'BM', 'BIOMETRIC', 1, '2021-06-22 13:49:20', 11, NULL, NULL, b'00'),
(54, 'CM', 'CAMERA', 1, '2021-06-26 16:09:09', 11, NULL, NULL, b'00'),
(55, 'PX', 'PABX', 1, '2021-06-29 17:11:49', 6, NULL, NULL, b'00'),
(56, 'TF', 'TELEFAX', 1, '2021-08-24 14:12:22', 11, NULL, NULL, b'00'),
(57, 'PE', 'POE SWITCH', 1, '2021-08-26 15:09:54', 6, NULL, NULL, b'00'),
(58, 'AC', 'UNMANNED AERIAL VEHICLE (DRONE)', 1, '2021-09-06 14:28:09', 11, NULL, NULL, b'00'),
(59, 'SK', 'SPEAKER', 1, '2021-09-22 08:26:56', 6, NULL, NULL, b'00'),
(60, 'FD', 'FLASH DRIVE', 1, '2021-09-22 09:07:36', 6, NULL, NULL, b'00'),
(61, 'SV', 'SERVER', 1, '2021-09-27 09:09:42', 6, NULL, NULL, b'00'),
(62, 'PJ', 'PROJECTOR', 1, '2021-10-07 17:02:45', 11, NULL, NULL, b'00'),
(64, 'NS', 'NETWORK STORAGE', 1, '2021-10-18 14:58:16', 6, NULL, NULL, b'00'),
(65, '', 'THERMAL BINDER', 3, '2021-11-03 15:44:44', 6, NULL, NULL, b'00'),
(66, '', 'KVM SWITCH', 3, '2021-11-03 15:47:19', 6, NULL, NULL, b'00'),
(67, '', 'DISPLAY SPLITTER', 3, '2021-11-03 15:47:43', 6, NULL, NULL, b'00'),
(68, '', 'PROJECTOR PRESENTER REMOTE', 3, '2021-11-03 15:49:02', 6, NULL, NULL, b'00'),
(69, '', 'RJ45', 2, '2021-11-08 09:01:30', 11, NULL, NULL, b'00'),
(70, '', 'RJ11', 2, '2021-11-08 09:01:40', 11, NULL, NULL, b'00'),
(71, '', 'UTP CABLE', 2, '2021-11-08 09:01:54', 11, NULL, NULL, b'00'),
(72, '', 'LAN MODULE', 2, '2021-11-08 16:15:34', 11, NULL, NULL, b'00'),
(73, '', 'TELEPHONE MODULE', 2, '2021-11-08 16:15:48', 11, NULL, NULL, b'00'),
(74, '', 'MODULE GANG PLATE', 2, '2021-11-08 16:16:06', 11, NULL, NULL, b'00'),
(75, '', 'EXTERNAL HDD CABLE', 2, '2021-11-08 16:16:34', 11, NULL, NULL, b'00'),
(76, '', 'TRIPOD', 3, '2021-11-12 09:16:41', 6, NULL, NULL, b'00'),
(77, '', 'PORTABLE MICROSCOPE', 3, '2021-11-12 09:18:45', 6, NULL, NULL, b'00'),
(78, '', 'SOLDERING MACHINE', 3, '2021-11-12 09:19:13', 6, NULL, NULL, b'00'),
(79, '', 'CAMERA FLASH', 3, '2021-11-12 09:19:30', 6, NULL, NULL, b'00'),
(80, '', 'BIOS PROGRAMMER', 3, '2021-11-12 09:19:58', 6, NULL, NULL, b'00'),
(81, '', 'SIGNATURE PAD', 3, '2021-11-12 09:50:42', 6, NULL, NULL, b'00'),
(82, '', 'CAMERA STABILIZER', 3, '2021-11-12 09:51:32', 6, NULL, NULL, b'00'),
(83, '', 'WIRELESS MICROPHONE', 3, '2021-11-12 09:51:51', 6, NULL, NULL, b'00'),
(84, '', 'BNC CONNECTOR', 2, '2021-11-15 10:57:32', 6, NULL, NULL, b'00'),
(86, '', 'POE ADAPTER 24V', 2, '2021-12-22 08:41:14', 6, NULL, NULL, b'00'),
(90, '', 'BOND PAPER LEGAL SIZE', 2, '2021-12-22 09:05:44', 6, NULL, NULL, b'00'),
(91, '', 'BOND PAPER LETTER SIZE', 2, '2021-12-22 09:06:05', 6, NULL, NULL, b'00'),
(92, '', 'BOND PAPER A4 SIZE', 2, '2021-12-22 09:06:18', 6, NULL, NULL, b'00'),
(93, '', 'EPSON INK 664 BLACK', 2, '2021-12-22 09:07:22', 6, NULL, NULL, b'00'),
(94, '', 'EPSON INK 664 MAGENTA', 2, '2021-12-22 09:07:58', 6, NULL, NULL, b'00'),
(95, '', 'EPSON INK 664 YELLOW', 2, '2021-12-22 09:08:16', 6, NULL, NULL, b'00'),
(96, '', 'EPSON INK 664 CYAN', 2, '2021-12-22 09:08:31', 6, NULL, NULL, b'00'),
(97, '', 'EPSON INK 673 CYAN', 2, '2021-12-22 09:09:21', 6, NULL, NULL, b'00'),
(98, '', 'EPSON INK 673 MAGENTA', 2, '2021-12-22 09:09:37', 6, NULL, NULL, b'00'),
(99, '', 'EPSON INK 673 LIGHT MAGENTA', 2, '2021-12-22 09:09:55', 6, NULL, NULL, b'00'),
(100, '', 'EPSON INK 673 LIGHT CYAN', 2, '2021-12-22 09:10:18', 6, NULL, NULL, b'00'),
(101, '', 'EPSON INK 673 BLACK', 2, '2021-12-22 09:10:42', 6, NULL, NULL, b'00'),
(102, '', 'EPSON INK 673 YELLOW', 2, '2021-12-22 09:11:33', 6, NULL, NULL, b'00'),
(103, '', 'THERMAL GREASE', 2, '2022-01-04 16:42:17', 11, NULL, NULL, b'00'),
(104, '', 'CAMCORDER', 3, '2022-02-04 15:25:46', 6, NULL, NULL, b'00'),
(105, '', 'TP LINK SFT FOR FIBER CABLE MODULE', 3, '2022-02-04 15:32:23', 6, NULL, NULL, b'00'),
(106, '', 'NETWORK CABLE TESTER', 3, '2022-02-04 15:34:44', 6, NULL, NULL, b'00'),
(107, '', 'POWER ADAPTER - 5V/3A', 2, '2022-02-23 10:29:27', 6, NULL, NULL, b'00'),
(108, '', 'POWER ADAPTER - 12V/2A', 2, '2022-02-23 10:33:04', 6, NULL, NULL, b'00'),
(109, '', 'POWER ADAPTER - 9V/1A', 2, '2022-02-23 10:33:36', 6, NULL, NULL, b'00'),
(110, '', 'DC CONNECTOR MALE', 2, '2022-03-28 08:49:16', 6, NULL, NULL, b'00'),
(111, '', 'DC CONNECTOR FEMALE', 2, '2022-03-28 08:49:34', 6, NULL, NULL, b'00'),
(112, 'CP', 'SMART PHONE', 1, '2022-12-19 10:33:14', 6, NULL, NULL, b'00');

-- --------------------------------------------------------

--
-- Table structure for table `memo_receipt`
--

CREATE TABLE `memo_receipt` (
  `mrid` int(11) NOT NULL,
  `empid` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `itemid` int(11) NOT NULL,
  `trans_no` varchar(255) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `added_by` int(11) NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` bit(2) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `memo_receipt`
--

INSERT INTO `memo_receipt` (`mrid`, `empid`, `location`, `itemid`, `trans_no`, `added_on`, `added_by`, `updated_on`, `updated_by`, `is_deleted`) VALUES
(1, 2, 'MAC', 1, 'MR000001', '2024-02-27 10:31:23', 6, NULL, NULL, b'00'),
(2, 3, 'MAC ', 1, 'MR000003', '2024-02-28 09:13:41', 6, NULL, NULL, b'00'),
(3, 3, 'MAC ', 2, 'MR000003', '2024-02-28 09:13:42', 6, NULL, NULL, b'00'),
(4, 3, 'PMI ', 3, 'MR000004', '2024-03-15 11:37:49', 6, NULL, NULL, b'00'),
(5, 3, 'BDT ', 4, 'MR000005', '2024-03-15 11:41:37', 6, NULL, NULL, b'00'),
(6, 3, 'MAC ', 5, 'MR000006', '2024-03-15 11:45:07', 6, NULL, NULL, b'00'),
(7, 3, 'PMI ', 6, 'MR000007', '2024-03-15 11:47:17', 6, NULL, NULL, b'00'),
(8, 22, 'MAC IT', 7, 'MR000008', '2024-03-15 15:14:11', 6, NULL, NULL, b'00'),
(9, 33, 'MAC ICT', 8, 'MR000009', '2024-03-15 15:16:28', 6, NULL, NULL, b'00'),
(10, 33, 'MAC ICT', 9, 'MR000009', '2024-03-15 15:16:29', 6, NULL, NULL, b'00'),
(11, 33, 'MAC ICT', 10, 'MR000010', '2024-03-15 15:19:13', 6, NULL, NULL, b'00'),
(12, 33, 'MAC ICT', 11, 'MR000010', '2024-03-15 15:19:15', 6, NULL, NULL, b'00'),
(13, 33, 'MAC ICT', 12, 'MR000010', '2024-03-15 15:19:15', 6, NULL, NULL, b'00'),
(14, 49, 'OCS ', 13, 'MR000011', '2024-03-19 10:42:47', 6, NULL, NULL, b'00'),
(15, 10, 'MAC ', 14, 'MR000012', '2024-03-19 16:21:36', 6, NULL, NULL, b'00');

-- --------------------------------------------------------

--
-- Table structure for table `miscellaneous_item`
--

CREATE TABLE `miscellaneous_item` (
  `miscid` int(11) NOT NULL,
  `companyid` int(11) NOT NULL,
  `item_typeid` int(11) NOT NULL,
  `asset_code` varchar(50) NOT NULL,
  `serial_no` varchar(50) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `receive_date` date NOT NULL,
  `receive_no` varchar(50) NOT NULL,
  `supplier` varchar(50) NOT NULL,
  `payment_order_no` varchar(50) NOT NULL,
  `invoice_date` date NOT NULL,
  `item_amount` decimal(19,2) NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `rf` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `added_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` bit(2) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `non_consumable_item`
--

CREATE TABLE `non_consumable_item` (
  `itemid` int(11) NOT NULL,
  `companyid` int(11) NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `equipment_code` varchar(50) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(50) NOT NULL,
  `serial_no` varchar(50) NOT NULL,
  `location` varchar(500) NOT NULL,
  `operating_system` varchar(255) NOT NULL,
  `system_type` varchar(50) NOT NULL,
  `processor` varchar(50) NOT NULL,
  `odd` varchar(255) NOT NULL DEFAULT 'N/A',
  `card_reader` varchar(255) NOT NULL DEFAULT 'N/A',
  `software` varchar(1000) NOT NULL,
  `receive_date` date NOT NULL,
  `receive_no` varchar(50) NOT NULL,
  `supplier` varchar(50) NOT NULL,
  `payment_order_no` varchar(50) NOT NULL,
  `invoice_date` date NOT NULL,
  `item_amount` decimal(19,2) NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `warranty` date NOT NULL,
  `rf` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `department` varchar(255) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `added_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` bit(2) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `non_consumable_item`
--

INSERT INTO `non_consumable_item` (`itemid`, `companyid`, `item_code`, `equipment_code`, `brand`, `model`, `serial_no`, `location`, `operating_system`, `system_type`, `processor`, `odd`, `card_reader`, `software`, `receive_date`, `receive_no`, `supplier`, `payment_order_no`, `invoice_date`, `item_amount`, `invoice`, `warranty`, `rf`, `status`, `department`, `added_on`, `added_by`, `updated_on`, `updated_by`, `is_deleted`) VALUES
(1, 1, 'AV', 'ICT-DC-000001', 'POWER GRID', 'VP600', 'XJEK2OSW1Y891N', 'MAC - ICT', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-02-27', 'N/A', 'N/A', 'N/A', '2024-02-27', '1000.00', 'N/A', '2025-02-27', 'N/A', 'ACTIVE', 'MAC ', '2024-02-27 10:29:33', 6, '2024-02-28 09:13:41', 6, b'00'),
(2, 1, 'MT', 'ICT-MT-000001', 'ACER', 'VISION', 'KOKW1249', 'MAC ', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-02-27', 'N/A', 'N/A', 'N/A', '2024-02-27', '2000.00', 'N/A', '2025-02-27', 'N/A', 'ACTIVE', 'MAC ', '2024-02-27 10:41:58', 6, '2024-02-28 09:13:42', 6, b'00'),
(3, 2, 'MS', 'ICT-MS-000001', 'ACER', 'N/A', 'KOKW1249', 'PMI ', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-03-15', 'N/A', 'N/A', 'N/A', '2024-03-15', '200.00', 'N/A', '2024-03-15', 'N/A', 'ACTIVE', 'PMI ', '2024-03-15 11:36:54', 6, '2024-03-15 11:37:49', 6, b'00'),
(4, 1, 'DC', 'ICT-DC-000001', 'ACER', 'N/A', 'SFG3243DGFS324', 'MAC ', 'DFSD', '32 Bit', 'INTEL(R) CORE(TM) I5-9400F CPU @ 2.90 GHZ', 'N/A', 'N/A', '', '2024-03-15', 'EDSFWQ5R2355', 'SFRSFDSFDF343444', 'GVFGSFDFF34DF', '2024-03-15', '2323.00', 'N/A', '2025-03-15', 'SRFWRER2342343243', 'ACTIVE', 'BDT ', '2024-03-15 11:40:25', 6, '2024-03-15 11:41:37', 6, b'00'),
(5, 4, 'DC', 'ICT-DC-000002', 'ACER', 'N/A', 'KOKW1249', 'OCS ', 'DAFA', '64 Bit', 'ASDFADASA', 'N/A', 'N/A', '', '2024-03-15', 'EDSFWQ5R2355', 'ASDADAS', 'ASDA23123', '2024-03-15', '23121.00', 'N/A', '2025-03-15', 'SRFWRER2342343243', 'ACTIVE', 'MAC ', '2024-03-15 11:44:39', 6, '2024-03-15 11:45:07', 6, b'00'),
(6, 4, 'MT', 'ICT-MT-000002', 'SDASD', 'ASDASDA', 'ADASDSADSA', 'OCS ', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-03-15', 'ASDASD', 'ASDAD', '23414', '2024-03-15', '234123421.00', 'N/A', '2025-03-15', 'N/A', 'ACTIVE', 'PMI ', '2024-03-15 11:47:00', 6, '2024-03-15 11:47:17', 6, b'00'),
(7, 1, 'DC', 'ICT-DC-000003', 'HP', 'HP', 'HP', 'MAC - ICT', 'WIN 10 PRO', '64 Bit', 'INTEL(R) CORE(TM) I5-9400F CPU @ 2.90 GHZ', 'N/A', 'N/A', 'MS OFFICE 2019, AUTOCAD 2019, ', '2024-03-15', 'N/A', 'N/A', 'N/A', '0001-01-01', '0.00', 'N/A', '0001-01-01', 'N/A', 'ACTIVE', 'MAC IT', '2024-03-15 15:13:40', 6, '2024-03-15 03:14:11', 6, b'00'),
(8, 1, 'PR', 'ICT-PR-000001', 'N/A', 'N/A', 'N/A', 'MAC - ICT', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-03-15', 'N/A', 'N/A', 'N/A', '0001-01-01', '0.00', 'N/A', '0001-01-01', 'N/A', 'ACTIVE', 'MAC ICT', '2024-03-15 15:15:21', 6, '2024-03-15 03:16:28', 6, b'00'),
(9, 1, 'KB', 'ICT-KB-000001', 'N/A', 'N/A', 'N/A', 'MAC - ICT', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-03-15', '', 'N/A', 'N/A', '0001-01-01', '0.00', 'N/A', '0001-01-01', 'N/A', 'ACTIVE', 'MAC ICT', '2024-03-15 15:15:55', 6, '2024-03-15 03:16:29', 6, b'00'),
(10, 1, 'MS', 'ICT-MS-000002', 'N/A', 'N/A', 'N/A', 'MAC - ICT', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-03-15', '', 'N/A', 'N/A', '0001-01-01', '0.00', 'N/A', '0001-01-01', 'N/A', 'ACTIVE', 'MAC ICT', '2024-03-15 15:17:37', 6, '2024-03-15 03:19:13', 6, b'00'),
(11, 1, 'PS', 'ICT-PS-000001', 'N/A', 'N/A', 'N/A', 'MAC ', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-03-15', 'N/A', 'N/A', 'N/A', '0101-01-10', '0.00', 'N/A', '0001-01-01', 'N/A', 'ACTIVE', 'MAC ICT', '2024-03-15 15:18:11', 6, '2024-03-15 03:19:14', 6, b'00'),
(12, 1, 'MT', 'ICT-MT-000003', 'N/A', 'N/A', 'N/A', 'MAC - ICT', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-03-15', 'N/A', 'N/A', 'N/A', '0001-01-01', '0.00', 'N/A', '0101-01-01', 'N/A', 'ACTIVE', 'MAC ICT', '2024-03-15 15:18:51', 6, '2024-03-15 03:19:15', 6, b'00'),
(13, 4, 'DC', 'ICT-DC-000004', 'ASUS', 'VISION', '3423423423', 'OCS ', 'SDFSF', '64 Bit', ' 12TH GEN INTEL® CORE™ I9', 'N/A', 'N/A', 'MS OFFICE 2019, AUTOCAD 2019, SKETCH UP 2018, PRIMAVERA, WINRAR, ', '2024-03-19', '325SDFWE324', 'SFSFFSFDSF', '32523542342', '2024-03-19', '2354.00', 'N/A', '2025-03-19', 'W545SDFG345', 'ACTIVE', 'OCS ', '2024-03-19 10:40:56', 6, '2024-03-19 10:42:47', 6, b'00'),
(14, 1, 'DC', 'ICT-DC-000005', 'ALLESTER', 'CORTON', 'N/A', 'MAC ', 'WIN 10 PRO', '64 Bit', 'INTEL(R) CORE(TM) I5-9400F CPU @ 2.90 GHZ', 'N/A', 'N/A', '', '2024-03-19', 'N/A', 'N/A', 'N/A', '2024-03-19', '1200.00', 'N/A', '2025-03-19', 'N/A', 'ACTIVE', 'MAC ', '2024-03-19 16:20:52', 6, '2024-03-19 04:21:36', 6, b'00');

-- --------------------------------------------------------

--
-- Table structure for table `pms`
--

CREATE TABLE `pms` (
  `id` int(11) NOT NULL,
  `quarter` enum('1','2','3','4','N/A') DEFAULT 'N/A',
  `task_id` varchar(100) NOT NULL DEFAULT 'N/A',
  `asset_id` varchar(100) NOT NULL DEFAULT 'N/A',
  `computer_name` varchar(100) NOT NULL DEFAULT 'N/A',
  `sys1` enum('ok','not_ok','none') DEFAULT 'none',
  `sys1_remarks` text DEFAULT NULL,
  `sys2` enum('ok','not_ok','none') DEFAULT 'none',
  `sys2_remarks` text DEFAULT NULL,
  `net_set1` enum('ok','not_ok','none') DEFAULT 'none',
  `net_set1_remarks` text DEFAULT NULL,
  `net_set2` enum('ok','not_ok','none') DEFAULT 'none',
  `net_set2_remarks` text DEFAULT NULL,
  `net_set3` enum('ok','not_ok','none') DEFAULT 'none',
  `net_set3_remarks` text DEFAULT NULL,
  `net_set4` enum('ok','not_ok','none') DEFAULT 'none',
  `net_set4_remarks` text DEFAULT NULL,
  `net_set5` enum('ok','not_ok','none') DEFAULT 'none',
  `net_set5_remarks` text DEFAULT NULL,
  `hw_set1` enum('ok','not_ok','none') DEFAULT 'none',
  `hw_set1_remarks` text DEFAULT NULL,
  `hw_set2` enum('ok','not_ok','none') DEFAULT 'none',
  `hw_set2_remarks` text DEFAULT NULL,
  `hw_set3` enum('ok','not_ok','none') DEFAULT 'none',
  `hw_set3_remarks` text DEFAULT NULL,
  `hw_set4` enum('ok','not_ok','none') DEFAULT 'none',
  `hw_set4_remarks` text DEFAULT NULL,
  `sw1` enum('ok','not_ok','none') DEFAULT 'none',
  `sw1_remarks` text DEFAULT NULL,
  `sw2` enum('ok','not_ok','none') DEFAULT 'none',
  `sw2_remarks` text DEFAULT NULL,
  `sw3` enum('ok','not_ok','none') DEFAULT 'none',
  `sw3_remarks` text DEFAULT NULL,
  `sw4` enum('ok','not_ok','none') DEFAULT 'none',
  `sw4_remarks` text DEFAULT NULL,
  `sw5` enum('ok','not_ok','none') DEFAULT 'none',
  `sw5_remarks` text DEFAULT NULL,
  `sw6` enum('ok','not_ok','none') DEFAULT 'none',
  `sw6_remarks` text DEFAULT NULL,
  `sw7` enum('ok','not_ok','none') DEFAULT 'none',
  `sw7_remarks` text DEFAULT NULL,
  `sec1` enum('ok','not_ok','none') DEFAULT 'none',
  `sec1_remarks` text DEFAULT NULL,
  `sec2` enum('ok','not_ok','none') DEFAULT 'none',
  `sec2_remarks` text DEFAULT NULL,
  `sec3` enum('ok','not_ok','none') DEFAULT 'none',
  `sec3_remarks` text DEFAULT NULL,
  `gen_main1` enum('ok','not_ok','none') DEFAULT 'none',
  `gen_main1_remarks` text DEFAULT NULL,
  `gen_main2` enum('ok','not_ok','none') DEFAULT 'none',
  `gen_main2_remarks` text DEFAULT NULL,
  `gen_main3` enum('ok','not_ok','none') DEFAULT 'none',
  `gen_main3_remarks` text DEFAULT NULL,
  `gen_main4` enum('ok','not_ok','none') DEFAULT 'none',
  `gen_main4_remarks` text DEFAULT NULL,
  `gen_main5` enum('ok','not_ok','none') DEFAULT 'none',
  `gen_main5_remarks` text DEFAULT NULL,
  `gen_main6` enum('ok','not_ok','none') DEFAULT 'none',
  `gen_main6_remarks` text DEFAULT NULL,
  `gen_main7` enum('ok','not_ok','none') DEFAULT 'none',
  `gen_main7_remarks` text DEFAULT NULL,
  `gen_main8` enum('ok','not_ok','none') DEFAULT 'none',
  `gen_main8_remarks` text DEFAULT NULL,
  `per_dev1` enum('ok','not_ok','none') DEFAULT 'none',
  `per_dev1_remarks` text DEFAULT NULL,
  `per_dev2` enum('ok','not_ok','none') DEFAULT 'none',
  `per_dev2_remarks` text DEFAULT NULL,
  `per_dev3` enum('ok','not_ok','none') DEFAULT 'none',
  `per_dev3_remarks` text DEFAULT NULL,
  `per_dev4` enum('ok','not_ok','none') DEFAULT 'none',
  `per_dev4_remarks` text DEFAULT NULL,
  `per_dev5` enum('ok','not_ok','none') DEFAULT 'none',
  `per_dev5_remarks` text DEFAULT NULL,
  `per_dev6` enum('ok','not_ok','none') DEFAULT 'none',
  `per_dev6_remarks` text DEFAULT NULL,
  `userid` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pms`
--

INSERT INTO `pms` (`id`, `quarter`, `task_id`, `asset_id`, `computer_name`, `sys1`, `sys1_remarks`, `sys2`, `sys2_remarks`, `net_set1`, `net_set1_remarks`, `net_set2`, `net_set2_remarks`, `net_set3`, `net_set3_remarks`, `net_set4`, `net_set4_remarks`, `net_set5`, `net_set5_remarks`, `hw_set1`, `hw_set1_remarks`, `hw_set2`, `hw_set2_remarks`, `hw_set3`, `hw_set3_remarks`, `hw_set4`, `hw_set4_remarks`, `sw1`, `sw1_remarks`, `sw2`, `sw2_remarks`, `sw3`, `sw3_remarks`, `sw4`, `sw4_remarks`, `sw5`, `sw5_remarks`, `sw6`, `sw6_remarks`, `sw7`, `sw7_remarks`, `sec1`, `sec1_remarks`, `sec2`, `sec2_remarks`, `sec3`, `sec3_remarks`, `gen_main1`, `gen_main1_remarks`, `gen_main2`, `gen_main2_remarks`, `gen_main3`, `gen_main3_remarks`, `gen_main4`, `gen_main4_remarks`, `gen_main5`, `gen_main5_remarks`, `gen_main6`, `gen_main6_remarks`, `gen_main7`, `gen_main7_remarks`, `gen_main8`, `gen_main8_remarks`, `per_dev1`, `per_dev1_remarks`, `per_dev2`, `per_dev2_remarks`, `per_dev3`, `per_dev3_remarks`, `per_dev4`, `per_dev4_remarks`, `per_dev5`, `per_dev5_remarks`, `per_dev6`, `per_dev6_remarks`, `userid`, `updated_at`, `created_at`) VALUES
(1, '1', 'TASK# 1', 'ICT-DC-000004', 'ict-1', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 6, '2024-03-25 00:42:21', '2024-03-25 00:42:21'),
(2, '2', 'TASK# 2', 'ICT-DC-000004', 'ict-2', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'not_ok', '', 'ok', '', 'ok', '', 'ok', '', 'none', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'not_ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 'ok', '', 6, '2024-03-25 00:43:07', '2024-03-25 00:43:07');

-- --------------------------------------------------------

--
-- Table structure for table `transfer`
--

CREATE TABLE `transfer` (
  `transferid` int(11) NOT NULL,
  `ticket` varchar(255) NOT NULL,
  `assetid` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `from_user` varchar(255) NOT NULL,
  `from_position` varchar(100) NOT NULL,
  `from_location` varchar(255) NOT NULL,
  `to_user` varchar(100) NOT NULL,
  `to_position` varchar(100) NOT NULL,
  `to_location` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `added_by` int(11) DEFAULT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `is_deleted` bit(2) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `turnover`
--

CREATE TABLE `turnover` (
  `turnoverid` int(11) NOT NULL,
  `ticket` varchar(255) NOT NULL,
  `assetid` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `added_by` int(11) DEFAULT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `is_deleted` bit(2) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `turnover`
--

INSERT INTO `turnover` (`turnoverid`, `ticket`, `assetid`, `type`, `user`, `location`, `remarks`, `added_by`, `added_on`, `updated_by`, `updated_on`, `is_deleted`) VALUES
(1, 'JK2024', 'ICT-AV-000001', 'AVR', 'MARYROSE YUMANG', 'MAC', 'TURN OVER', 6, '2024-02-27 10:32:30', NULL, NULL, b'00');

-- --------------------------------------------------------

--
-- Table structure for table `upload_documents`
--

CREATE TABLE `upload_documents` (
  `fileid` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `filename` text NOT NULL,
  `fileextension` varchar(100) NOT NULL,
  `filedescription` text NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `added_by` int(11) NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `user_role` int(5) NOT NULL,
  `names` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `passwords` varchar(100) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `reset_pass` bit(2) NOT NULL DEFAULT b'0',
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `added_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` bit(2) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `user_role`, `names`, `username`, `passwords`, `last_login`, `reset_pass`, `added_on`, `added_by`, `updated_on`, `updated_by`, `is_deleted`) VALUES
(3, 2, 'J-GEAR LABARTINE', 'jlabartine', '$2y$10$asEHAYc1FeFxJ33xSpcGoeH3Fd7wsgdBbpPfIOlTGpFfb6BV2V9Rq', '2023-05-27 08:38:04', b'01', '2021-01-05 16:23:51', NULL, '2021-11-25 08:46:16', 3, b'00'),
(4, 3, 'JEFF JUROLAN', 'jcjurolan', '$2y$10$xhCpyT2NJlhZegpuIGntJuJzzjsoUePF6BrzWSA/SYealF9OBcYNK', '2021-10-15 05:17:48', b'01', '2021-01-20 16:17:59', NULL, '2021-10-29 03:09:16', 11, b'01'),
(5, 1, 'CRESCILDA BACO', 'cbaco', '$2y$10$VRDnfRD6AcBp7/XcdNFvxuZV2Lw7moqzZFEAEkzqF4/SqrYEKaSpq', '2023-01-24 11:29:45', b'00', '2021-04-05 09:26:01', NULL, '2021-04-26 05:08:56', 6, b'00'),
(6, 1, 'RESMAR CORDERO', 'rcordero', '$2y$10$XjMzgyYAEJcbUoAPvYWyKeqOI6IZXYrbMvMr2DQ1z.zF.AyagKQei', '2024-03-22 11:10:53', b'01', '2021-04-05 09:26:01', NULL, '2021-09-29 08:38:45', 6, b'00'),
(7, 3, 'JEM VELOSO', 'jveloso', '$2y$10$KIpwT6p9zbQgmB.eeT1X1ujizwpLB01MELCXbtQOkWY9VOeHU/9fa', '2021-07-27 04:31:13', b'00', '2021-04-25 14:07:35', 3, '2021-10-29 03:09:20', 11, b'01'),
(8, 3, 'NORBERTO TAMBIS III', 'ntambis', '$2y$10$OlMHWIiUO1sBa0zLqE2UDu0wcDvE4geaQifkF6Haxw6eJiYRy438y', '2021-10-22 09:09:02', b'01', '2021-04-26 10:05:25', 7, '2023-06-21 04:35:29', 6, b'00'),
(9, 3, 'ANDRIAN OSCAR LAMBO', 'aalambo', '$2y$10$CZofHW.fy0tld.inYX2YyeNVEsTBy3T.6zy5se8VAYcBWUtEFwnW.', '2022-03-21 10:52:10', b'01', '2021-04-26 10:05:52', 7, '2023-06-21 04:35:21', 6, b'00'),
(11, 1, 'ADMINISTRATOR', 'admin', '$2y$10$OIiVR3rvh1HwD3lxBthv8uJVlxAgHW83vuY9g8vzg4fdHA8KJkHNa', '2023-05-03 10:45:18', b'01', '2021-04-30 09:30:07', 3, '2021-09-29 03:08:50', 11, b'00'),
(12, 3, 'ANTHONIO BALAJADIA', 'abalajadia', '$2y$10$oUrgYhEOScAE.8jpEYLLkeUGZpZFNd6rGp/n7hMnq8IIPbcS0b8Fy', '2023-01-16 08:53:24', b'01', '2021-10-29 11:27:02', 6, '2023-06-21 04:35:24', 6, b'00'),
(13, 2, 'RASALIE BROCOY', 'rbrocoy', '$2y$10$Jiq2EDI0ytAtgs7qvQ.uaOtMlf1/ocf3wtfCRRKnLh5vuBhqGjGh6', '2023-06-23 09:03:08', b'01', '2021-11-25 08:38:05', 11, '2021-11-25 09:06:01', 13, b'00'),
(14, 3, 'LESTER MARC CALIXTRO', 'lmcalixtro', '$2y$10$xm9GaEE6RwuAk1D6XrmacuWm.Er0aQOPwJH7mxFf0McayUu0NslZm', '2022-03-03 04:16:08', b'01', '2022-01-12 23:51:06', 11, '2022-02-16 10:44:37', 6, b'00'),
(15, 2, 'MARK JASON COLON', 'MCOLON', '$2y$10$0zV63KTaYyc1.XjSt5KYDe3Hzw4auSngAOj1IHGwURv1N2NMdlaZW', '2023-11-21 05:47:49', b'01', '2022-05-10 13:37:38', 6, '2023-06-22 05:03:46', 6, b'00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`companyid`),
  ADD UNIQUE KEY `abbreviation` (`abbreviation`);

--
-- Indexes for table `consumable_item`
--
ALTER TABLE `consumable_item`
  ADD PRIMARY KEY (`consumableid`);

--
-- Indexes for table `consumable_receivables`
--
ALTER TABLE `consumable_receivables`
  ADD PRIMARY KEY (`receivableid`);

--
-- Indexes for table `consumable_request`
--
ALTER TABLE `consumable_request`
  ADD PRIMARY KEY (`requestid`);

--
-- Indexes for table `employee_user`
--
ALTER TABLE `employee_user`
  ADD PRIMARY KEY (`empid`);

--
-- Indexes for table `for_repair`
--
ALTER TABLE `for_repair`
  ADD PRIMARY KEY (`repairid`);

--
-- Indexes for table `item_addon`
--
ALTER TABLE `item_addon`
  ADD PRIMARY KEY (`addonid`);

--
-- Indexes for table `item_addon_history`
--
ALTER TABLE `item_addon_history`
  ADD PRIMARY KEY (`item_historyid`);

--
-- Indexes for table `item_checkout`
--
ALTER TABLE `item_checkout`
  ADD PRIMARY KEY (`checkoutid`);

--
-- Indexes for table `item_deploy`
--
ALTER TABLE `item_deploy`
  ADD PRIMARY KEY (`item_deployid`);

--
-- Indexes for table `item_disposed`
--
ALTER TABLE `item_disposed`
  ADD PRIMARY KEY (`disposeid`);

--
-- Indexes for table `item_history`
--
ALTER TABLE `item_history`
  ADD PRIMARY KEY (`item_historyid`);

--
-- Indexes for table `item_type`
--
ALTER TABLE `item_type`
  ADD PRIMARY KEY (`item_typeid`);

--
-- Indexes for table `memo_receipt`
--
ALTER TABLE `memo_receipt`
  ADD PRIMARY KEY (`mrid`);

--
-- Indexes for table `miscellaneous_item`
--
ALTER TABLE `miscellaneous_item`
  ADD PRIMARY KEY (`miscid`);

--
-- Indexes for table `non_consumable_item`
--
ALTER TABLE `non_consumable_item`
  ADD PRIMARY KEY (`itemid`),
  ADD UNIQUE KEY `equipment_code` (`equipment_code`,`serial_no`);

--
-- Indexes for table `pms`
--
ALTER TABLE `pms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `task_id` (`task_id`);

--
-- Indexes for table `transfer`
--
ALTER TABLE `transfer`
  ADD PRIMARY KEY (`transferid`);

--
-- Indexes for table `turnover`
--
ALTER TABLE `turnover`
  ADD PRIMARY KEY (`turnoverid`);

--
-- Indexes for table `upload_documents`
--
ALTER TABLE `upload_documents`
  ADD PRIMARY KEY (`fileid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `companyid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `consumable_item`
--
ALTER TABLE `consumable_item`
  MODIFY `consumableid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consumable_receivables`
--
ALTER TABLE `consumable_receivables`
  MODIFY `receivableid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consumable_request`
--
ALTER TABLE `consumable_request`
  MODIFY `requestid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_user`
--
ALTER TABLE `employee_user`
  MODIFY `empid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `for_repair`
--
ALTER TABLE `for_repair`
  MODIFY `repairid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_addon`
--
ALTER TABLE `item_addon`
  MODIFY `addonid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `item_addon_history`
--
ALTER TABLE `item_addon_history`
  MODIFY `item_historyid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_checkout`
--
ALTER TABLE `item_checkout`
  MODIFY `checkoutid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `item_deploy`
--
ALTER TABLE `item_deploy`
  MODIFY `item_deployid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `item_disposed`
--
ALTER TABLE `item_disposed`
  MODIFY `disposeid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_history`
--
ALTER TABLE `item_history`
  MODIFY `item_historyid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `item_type`
--
ALTER TABLE `item_type`
  MODIFY `item_typeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `memo_receipt`
--
ALTER TABLE `memo_receipt`
  MODIFY `mrid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `miscellaneous_item`
--
ALTER TABLE `miscellaneous_item`
  MODIFY `miscid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `non_consumable_item`
--
ALTER TABLE `non_consumable_item`
  MODIFY `itemid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pms`
--
ALTER TABLE `pms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transfer`
--
ALTER TABLE `transfer`
  MODIFY `transferid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `turnover`
--
ALTER TABLE `turnover`
  MODIFY `turnoverid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `upload_documents`
--
ALTER TABLE `upload_documents`
  MODIFY `fileid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
