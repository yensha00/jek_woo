-- sys - System
-- net_set - Network Settings
-- hw_set - Hardware Settings
-- sw - Software
-- sec - Security
-- gen_main - General Maintenance
-- per_dev - Pheripheral Devices

DROP TABLE IF EXISTS pms;

-- PMS TABLE
CREATE TABLE pms (
    id INT AUTO_INCREMENT PRIMARY KEY UNIQUE,
    quarter ENUM('1', '2', '3', '4', 'N/A') DEFAULT 'N/A',
    task_id VARCHAR(100) NOT NULL DEFAULT 'N/A' UNIQUE,
    asset_id VARCHAR(100) NOT NULL DEFAULT 'N/A',
    computer_name VARCHAR(100) NOT NULL DEFAULT 'N/A',
    sys1 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    sys1_remarks TEXT,
    sys2 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    sys2_remarks TEXT,
    net_set1 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    net_set1_remarks TEXT,
    net_set2 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    net_set2_remarks TEXT,
    net_set3 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    net_set3_remarks TEXT,
    net_set4 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    net_set4_remarks TEXT,
    net_set5 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    net_set5_remarks TEXT,
    hw_set1 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    hw_set1_remarks TEXT,
    hw_set2 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    hw_set2_remarks TEXT,
    hw_set3 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    hw_set3_remarks TEXT,
    hw_set4 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    hw_set4_remarks TEXT,
    sw1 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    sw1_remarks TEXT,
    sw2 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    sw2_remarks TEXT,
    sw3 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    sw3_remarks TEXT,
    sw4 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    sw4_remarks TEXT,
    sw5 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    sw5_remarks TEXT,
    sw6 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    sw6_remarks TEXT,
    sw7 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    sw7_remarks TEXT,
    sec1 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    sec1_remarks TEXT,
    sec2 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    sec2_remarks TEXT,
    sec3 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    sec3_remarks TEXT,
    gen_main1 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    gen_main1_remarks TEXT,
    gen_main2 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    gen_main2_remarks TEXT,
    gen_main3 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    gen_main3_remarks TEXT,
    gen_main4 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    gen_main4_remarks TEXT,
    gen_main5 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    gen_main5_remarks TEXT,
    gen_main6 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    gen_main6_remarks TEXT,
    gen_main7 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    gen_main7_remarks TEXT,
    gen_main8 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    gen_main8_remarks TEXT,
    per_dev1 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    per_dev1_remarks TEXT,
    per_dev2 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    per_dev2_remarks TEXT,
    per_dev3 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    per_dev3_remarks TEXT,
    per_dev4 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    per_dev4_remarks TEXT,
    per_dev5 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    per_dev5_remarks TEXT,
    per_dev6 ENUM('ok', 'not_ok', 'none') DEFAULT 'none',
    per_dev6_remarks TEXT,
    userid INT NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- PMS FETCH RELATION TABLES

CREATE TABLE user (
  userid INT(11) NOT NULL,
  user_role INT(5) NOT NULL,
  names VARCHAR(50) NOT NULL,
  username VARCHAR(50) NOT NULL,
  passwords VARCHAR(100) NOT NULL,
  last_login DATETIME DEFAULT NULL,
  reset_pass BIT(2) NOT NULL DEFAULT b'0',
  added_on DATETIME NOT NULL DEFAULT current_timestamp(),
  added_by INT(11) DEFAULT NULL,
  updated_on DATETIME DEFAULT NULL,
  updated_by INT(11) DEFAULT NULL,
  is_deleted BIT(2) NOT NULL DEFAULT b'0'
);

CREATE TABLE non_consumable_item (
    itemid INT(11) NOT NULL,
    companyid INT(11) NOT NULL,
    item_code VARCHAR(20) NOT NULL,
    equipment_code VARCHAR(50) NOT NULL,
    brand VARCHAR(255) NOT NULL,
    model VARCHAR(50) NOT NULL,
    serial_no VARCHAR(50) NOT NULL,
    location VARCHAR(500) NOT NULL,
    operating_system VARCHAR(255) NOT NULL,
    system_type VARCHAR(50) NOT NULL,
    processor VARCHAR(50) NOT NULL,
    odd VARCHAR(255) NOT NULL DEFAULT 'N/A',
    card_reader VARCHAR(255) NOT NULL DEFAULT 'N/A',
    software VARCHAR(1000) NOT NULL,
    receive_date DATE NOT NULL,
    receive_no VARCHAR(50) NOT NULL,
    supplier VARCHAR(50) NOT NULL,
    payment_order_no VARCHAR(50) NOT NULL,
    invoice_date DATE NOT NULL,
    item_amount DECIMAL(19,2) NOT NULL,
    invoice VARCHAR(50) NOT NULL,
    warranty DATE NOT NULL,
    rf VARCHAR(50) NOT NULL,
    status VARCHAR(50) NOT NULL,
    department VARCHAR(255) NOT NULL,
    added_on DATETIME NOT NULL DEFAULT current_timestamp(),
    added_by INT(11) DEFAULT NULL,
    updated_on DATETIME DEFAULT NULL,
    updated_by INT(11) DEFAULT NULL,
    is_deleted BIT(2) NOT NULL DEFAULT b'0'
);

CREATE TABLE item_deploy (
    item_deployid INT(11) NOT NULL,
    empid INT(11) NOT NULL,
    itemid INT(50) NOT NULL,
    added_on DATETIME NOT NULL DEFAULT current_timestamp(),
    added_by INT(50) NOT NULL,
    updated_on DATETIME DEFAULT NULL,
    updated_by INT(11) DEFAULT NULL,
    is_deleted BIT(2) NOT NULL DEFAULT b'0'
);

CREATE TABLE employee_user (
    empid INT(11) NOT NULL,
    companyid INT(11) NOT NULL,
    empname varchar(255) NOT NULL,
    location_dept varchar(255) NOT NULL,
    added_on datetime NOT NULL DEFAULT current_timestamp(),
    added_by INT(11) DEFAULT NULL,
    updated_on datetime DEFAULT NULL,
    updated_by INT(11) DEFAULT NULL,
    is_deleted INT(11) NOT NULL DEFAULT 0
);

CREATE TABLE item_addon (
    addonid INT(11) NOT NULL,
    addonname VARCHAR(50) NOT NULL,
    asset_code VARCHAR(50) NOT NULL,
    serial_no VARCHAR(50) NOT NULL,
    brand VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    description VARCHAR(255) NOT NULL,
    receive_date DATE NOT NULL,
    receive_no VARCHAR(50) NOT NULL,
    supplier VARCHAR(50) NOT NULL,
    payment_order_no VARCHAR(50) NOT NULL,
    invoice_date DATE NOT NULL,
    item_amount DECIMAL(19,2) NOT NULL,
    invoice VARCHAR(50) NOT NULL,
    warranty VARCHAR(50) NOT NULL,
    rf VARCHAR(50) NOT NULL,
    status VARCHAR(50) NOT NULL,
    added_on DATETIME NOT NULL DEFAULT current_timestamp(),
    added_by INT(11) DEFAULT NULL,
    updated_on DATETIME DEFAULT NULL,
    updated_by INT(11) DEFAULT NULL,
    is_removed BIT(2) NOT NULL DEFAULT b'0',
    is_deleted BIT(2) NOT NULL DEFAULT b'0'
);

CREATE TABLE memo_receipt (
    mrid INT(11) NOT NULL,
    empid INT(11) NOT NULL,
    location VARCHAR(100) NOT NULL,
    itemid INT(11) NOT NULL,
    trans_no VARCHAR(255) NOT NULL,
    added_on DATETIME NOT NULL DEFAULT current_timestamp(),
    added_by INT(11) NOT NULL,
    updated_on DATETIME DEFAULT NULL,
    updated_by INT(11) DEFAULT NULL,
    is_deleted BIT(2) NOT NULL DEFAULT b'0'
);

CREATE TABLE item_history (
  item_historyid INT(11) NOT NULL,
  itemid INT(11) NOT NULL,
  datesrf DATE NOT NULL,
  srf VARCHAR(250) NOT NULL,
  problem VARCHAR(1000) NOT NULL,
  solution VARCHAR(1000) NOT NULL,
  remarks VARCHAR(50) NOT NULL,
  added_on DATETIME NOT NULL DEFAULT current_timestamp(),
  added_by INT(11) DEFAULT NULL,
  updated_on DATETIME DEFAULT NULL,
  updated_by INT(11) DEFAULT NULL,
  is_deleted BIT(2) NOT NULL DEFAULT b'0'
);

-- Sample insert data into item_addon table
-- Insert into item_addon table
INSERT INTO item_addon (addonid, addonname, asset_code, serial_no, brand, model, description, receive_date, receive_no, supplier, payment_order_no, invoice_date, item_amount, invoice, warranty, rf, status, added_on, added_by, updated_on, updated_by, is_removed, is_deleted)
VALUES (1, 'RAM', 'ICT-DC-000001', 'KOKW1249', 'ACER', 'vision', 'Memory', '2024-02-27', 'N/A', 'N/A', 'N/A', '2024-02-27', 0.00, 'N/A', '2025-02-27', 'N/A', 'ACTIVE', '2024-02-27 10:41:58', 6, '2024-02-28 09:13:42', 6, b'0', b'0');

-- SAMPLE INSERT

-- non_consumable_item
INSERT INTO `non_consumable_item` (`itemid`, `companyid`, `item_code`, `equipment_code`, `brand`, `model`, `serial_no`, `location`, `operating_system`, `system_type`, `processor`, `odd`, `card_reader`, `software`, `receive_date`, `receive_no`, `supplier`, `payment_order_no`, `invoice_date`, `item_amount`, `invoice`, `warranty`, `rf`, `status`, `department`, `added_on`, `added_by`, `updated_on`, `updated_by`, `is_deleted`) VALUES
(3, 1, 'MS', 'ICT-MS-000001', 'POWER GRID', 'VP600', 'XJEK2OSW1Y891N', 'MAC - ICT', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-02-27', 'N/A', 'N/A', 'N/A', '2024-02-27', '1000.00', 'N/A', '2025-02-27', 'N/A', 'ACTIVE', 'MAC ', '2024-02-27 10:29:33', 6, '2024-02-28 09:13:41', 6, b'00'),
(4, 1, 'KB', 'ICT-KB-000001', 'ACER', 'VISION', 'KOKW1249', 'MAC ', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-02-27', 'N/A', 'N/A', 'N/A', '2024-02-27', '2000.00', 'N/A', '2025-02-27', 'N/A', 'ACTIVE', 'MAC ', '2024-02-27 10:41:58', 6, '2024-02-28 09:13:42', 6, b'00'),
(5, 1, 'MT', 'ICT-MT-000001', 'ACER', 'VISION', 'KOKW1249', 'MAC ', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-02-27', 'N/A', 'N/A', 'N/A', '2024-02-27', '2000.00', 'N/A', '2025-02-27', 'N/A', 'ACTIVE', 'MAC ', '2024-02-27 10:41:58', 6, '2024-02-28 09:13:42', 6, b'00'),
(6, 1, 'PS', 'ICT-PS-000001', 'ACER', 'VISION', 'KOKW1249', 'MAC ', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-02-27', 'N/A', 'N/A', 'N/A', '2024-02-27', '2000.00', 'N/A', '2025-02-27', 'N/A', 'ACTIVE', 'MAC ', '2024-02-27 10:41:58', 6, '2024-02-28 09:13:42', 6, b'00'),
(7, 1, 'AV', 'ICT-AV-000001', 'ACER', 'VISION', 'KOKW1249', 'MAC ', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-02-27', 'N/A', 'N/A', 'N/A', '2024-02-27', '2000.00', 'N/A', '2025-02-27', 'N/A', 'ACTIVE', 'MAC ', '2024-02-27 10:41:58', 6, '2024-02-28 09:13:42', 6, b'00'),
(8, 1, 'PR', 'ICT-PR-000001', 'ACER', 'VISION', 'KOKW1249', 'MAC ', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-02-27', 'N/A', 'N/A', 'N/A', '2024-02-27', '2000.00', 'N/A', '2025-02-27', 'N/A', 'ACTIVE', 'MAC ', '2024-02-27 10:41:58', 6, '2024-02-28 09:13:42', 6, b'00'),
(9, 1, 'TP', 'ICT-TP-000001', 'ACER', 'VISION', 'KOKW1249', 'MAC ', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-02-27', 'N/A', 'N/A', 'N/A', '2024-02-27', '2000.00', 'N/A', '2025-02-27', 'N/A', 'ACTIVE', 'MAC ', '2024-02-27 10:41:58', 6, '2024-02-28 09:13:42', 6, b'00'),

(10, 1, 'MS', 'ICT-MS-000002', 'POWER GRID', 'VP600', 'XJEK2OSW1Y891N', 'MAC - ICT', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-03-14', 'N/A', 'N/A', 'N/A', '2024-03-14', '1000.00', 'N/A', '2025-02-27', 'N/A', 'ACTIVE', 'MAC ', '2024-03-14 10:29:33', 6, '2024-02-28 09:13:41', 6, b'00'),
(11, 1, 'KB', 'ICT-KB-000002', 'ACER', 'VISION', 'KOKW1249', 'MAC ', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-03-14', 'N/A', 'N/A', 'N/A', '2024-03-14', '2000.00', 'N/A', '2025-02-27', 'N/A', 'ACTIVE', 'MAC ', '2024-03-14 10:41:58', 6, '2024-02-28 09:13:42', 6, b'00'),
(12, 1, 'MT', 'ICT-MT-000002', 'ACER', 'VISION', 'KOKW1249', 'MAC ', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-03-14', 'N/A', 'N/A', 'N/A', '2024-03-14', '2000.00', 'N/A', '2025-02-27', 'N/A', 'ACTIVE', 'MAC ', '2024-03-14 10:41:58', 6, '2024-02-28 09:13:42', 6, b'00'),
(13, 1, 'PS', 'ICT-PS-000002', 'ACER', 'VISION', 'KOKW1249', 'MAC ', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-03-14', 'N/A', 'N/A', 'N/A', '2024-03-14', '2000.00', 'N/A', '2025-02-27', 'N/A', 'ACTIVE', 'MAC ', '2024-03-14 10:41:58', 6, '2024-02-28 09:13:42', 6, b'00'),
(14, 1, 'AV', 'ICT-AV-000002', 'ACER', 'VISION', 'KOKW1249', 'MAC ', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-03-14', 'N/A', 'N/A', 'N/A', '2024-03-14', '2000.00', 'N/A', '2025-02-27', 'N/A', 'ACTIVE', 'MAC ', '2024-03-14 10:41:58', 6, '2024-02-28 09:13:42', 6, b'00'),
(15, 1, 'PR', 'ICT-PR-000002', 'ACER', 'VISION', 'KOKW1249', 'MAC ', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-03-14', 'N/A', 'N/A', 'N/A', '2024-03-14', '2000.00', 'N/A', '2025-02-27', 'N/A', 'ACTIVE', 'MAC ', '2024-03-14 10:41:58', 6, '2024-02-28 09:13:42', 6, b'00'),
(16, 1, 'TP', 'ICT-TP-000002', 'ACER', 'VISION', 'KOKW1249', 'MAC ', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-03-14', 'N/A', 'N/A', 'N/A', '2024-03-14', '2000.00', 'N/A', '2025-02-27', 'N/A', 'ACTIVE', 'MAC ', '2024-03-14 10:41:58', 6, '2024-02-28 09:13:42', 6, b'00');

INSERT INTO `non_consumable_item` (`itemid`, `companyid`, `item_code`, `equipment_code`, `brand`, `model`, `serial_no`, `location`, `operating_system`, `system_type`, `processor`, `odd`, `card_reader`, `software`, `receive_date`, `receive_no`, `supplier`, `payment_order_no`, `invoice_date`, `item_amount`, `invoice`, `warranty`, `rf`, `status`, `department`, `added_on`, `added_by`, `updated_on`, `updated_by`, `is_deleted`) VALUES
(17, 1, 'DC', 'ICT-DC-000004', 'ACER', 'VISION', 'KOKW1249', 'MAC ', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', '2024-03-14', 'N/A', 'N/A', 'N/A', '2024-03-14', '2000.00', 'N/A', '2025-02-27', 'N/A', 'ACTIVE', 'MAC ', '2024-03-14 10:41:58', 6, '2024-02-28 09:13:42', 6, b'00');

-- item_deploy
INSERT INTO `item_deploy` (`item_deployid`, `empid`, `itemid`, `added_on`, `added_by`, `updated_on`, `updated_by`, `is_deleted`) VALUES
(4, 6, 3, '2024-03-14 10:31:23', 6, '2024-03-14 10:31:23', 6, b'01'),
(5, 6, 4, '2024-03-14 10:31:23', 6, '2024-03-14 10:31:23', 6, b'01'),
(6, 6, 5, '2024-03-14 10:31:23', 6, '2024-03-14 10:31:23', 6, b'01'),
(7, 6, 6, '2024-03-14 10:31:23', 6, '2024-03-14 10:31:23', 6, b'01'),
(8, 6, 7, '2024-03-14 10:31:23', 6, '2024-03-14 10:31:23', 6, b'01'),
(9, 6, 8, '2024-03-14 10:31:23', 6, '2024-03-14 10:31:23', 6, b'01'),
(10, 6, 9, '2024-03-14 10:31:23', 6, '2024-03-14 10:31:23', 6, b'01'),

(11, 6, 10, '2024-03-14 10:31:23', 6, '2024-03-14 10:31:23', 6, b'01'),
(12, 6, 11, '2024-03-14 10:31:23', 6, '2024-03-14 10:31:23', 6, b'01'),
(13, 6, 12, '2024-03-14 10:31:23', 6, '2024-03-14 10:31:23', 6, b'01'),
(14, 6, 13, '2024-03-14 10:31:23', 6, '2024-03-14 10:31:23', 6, b'01'),
(15, 6, 14, '2024-03-14 10:31:23', 6, '2024-03-14 10:31:23', 6, b'01'),
(16, 6, 15, '2024-03-14 10:31:23', 6, '2024-03-14 10:31:23', 6, b'01'),
(17, 6, 16, '2024-03-14 10:31:23', 6, '2024-03-14 10:31:23', 6, b'01');

INSERT INTO `item_deploy` (`item_deployid`, `empid`, `itemid`, `added_on`, `added_by`, `updated_on`, `updated_by`, `is_deleted`) VALUES
(18, 6, 17, '2024-03-14 10:31:23', 6, '2024-03-14 10:31:23', 6, b'01');

-- memo_receipt
INSERT INTO `memo_receipt` (`mrid`, `empid`, `location`, `itemid`, `trans_no`, `added_on`, `added_by`, `updated_on`, `updated_by`, `is_deleted`) VALUES
(4, 6, 'MAC', 3, 'MR000004', '2024-03-14 10:31:23', 6, NULL, NULL, b'00'),
(5, 6, 'MAC ', 4, 'MR000005', '2024-03-14 09:13:41', 6, NULL, NULL, b'00'),
(6, 6, 'MAC ', 5, 'MR000006', '2024-03-14 09:13:42', 6, NULL, NULL, b'00'),
(7, 6, 'MAC', 6, 'MR000004', '2024-03-14 10:31:23', 6, NULL, NULL, b'00'),
(8, 6, 'MAC ', 7, 'MR000005', '2024-03-14 09:13:41', 6, NULL, NULL, b'00'),
(9, 6, 'MAC ', 8, 'MR000006', '2024-03-14 09:13:42', 6, NULL, NULL, b'00'),
(10, 6, 'MAC', 9, 'MR000004', '2024-03-14 10:31:23', 6, NULL, NULL, b'00'),

(11, 6, 'MAC ', 10, 'MR000005', '2024-03-14 09:13:41', 6, NULL, NULL, b'00'),
(12, 6, 'MAC ', 11, 'MR000006', '2024-03-14 09:13:42', 6, NULL, NULL, b'00'),
(13, 6, 'MAC', 12, 'MR000004', '2024-03-14 10:31:23', 6, NULL, NULL, b'00'),
(14, 6, 'MAC ', 13, 'MR000005', '2024-03-14 09:13:41', 6, NULL, NULL, b'00'),
(15, 6, 'MAC ', 14, 'MR000006', '2024-03-14 09:13:42', 6, NULL, NULL, b'00'),
(16, 6, 'MAC', 15, 'MR000004', '2024-03-14 10:31:23', 6, NULL, NULL, b'00'),
(17, 6, 'MAC ', 16, 'MR000005', '2024-03-14 09:13:41', 6, NULL, NULL, b'00');

INSERT INTO `memo_receipt` (`mrid`, `empid`, `location`, `itemid`, `trans_no`, `added_on`, `added_by`, `updated_on`, `updated_by`, `is_deleted`) VALUES
(18, 6, 'MAC ', 17, 'MR000005', '2024-03-14 09:13:41', 6, NULL, NULL, b'00');

INSERT INTO item_addon (addonname, asset_code, serial_no, brand, model, description, receive_date, receive_no, supplier, payment_order_no, invoice_date, item_amount, invoice, warranty, rf, status, added_by) VALUES 
('RAM', 'ASSET_CODE_VALUE', 'SERIAL_NO_VALUE', 'BRAND_VALUE', 'MODEL_VALUE', 'ASUS', '2024-03-14', 'RECEIVE_NO_VALUE', 'SUPPLIER_VALUE', 'PAYMENT_ORDER_NO_VALUE', '2024-03-14', 100.00, 'INVOICE_VALUE', 'WARRANTY_VALUE', 'RF_VALUE', 'STATUS_VALUE', 1);