-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 10, 2015 at 05:35 PM
-- Server version: 5.5.46-0ubuntu0.14.04.2
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rajapura`
--

--
-- Dumping data for table `alarm_fields`
--

INSERT INTO `alarm_fields` (`id`, `alarm_type`, `alarm_field`, `type`, `status`, `audio_status`, `history_enable`, `priority`) VALUES
(1, 'inverter', 'MAIN_ST_Fault', 'process', 1, 1, 0, '4'),
(2, 'inverter', 'MAIN_ST_Warning', 'process', 1, 1, 0, '4'),
(3, 'inverter', 'MAIN_ST_Ready_to_Switch_ON', 'process', 1, 0, 0, '1'),
(4, 'inverter', 'MAIN_ST_Ready_to_Operate', 'process', 1, 0, 0, '1'),
(5, 'inverter', 'MAIN_ST_Operation_enabled', 'process', 1, 0, 0, '1'),
(6, 'inverter', 'MAIN_ST_Inverter_is_Modulating', 'process', 1, 0, 0, '1'),
(7, 'inverter', 'MAIN_ST_Control_Mode_REMOTE', 'process', 1, 0, 0, '1'),
(8, 'inverter', 'MAIN_ST_Grid_Voltage_OK', 'process', 1, 0, 0, '1'),
(9, 'inverter', 'MAIN_ST_DC_Bus_Charged', 'process', 1, 0, 0, '1'),
(10, 'inverter', 'MAIN_ST_DC_Bus_Charging_Contactor_Closed', 'process', 1, 0, 0, '1'),
(11, 'inverter', 'PV_ST_Inverter_in_MPP_Mode', 'process', 1, 0, 0, '1'),
(12, 'inverter', 'PV_ST_INV_Local_Mode&MPPT_Disabld&DC_Switch_Open', 'process', 1, 0, 0, '1'),
(13, 'inverter', 'PV_ST_Start_Enabled', 'process', 1, 0, 0, '1'),
(14, 'inverter', 'PV_ST_Inverter_Unit_Ready', 'process', 1, 0, 0, '1'),
(15, 'inverter', 'PV_ST_DC_Switch_Closed', 'process', 1, 0, 0, '1'),
(16, 'inverter', 'PV_ST_Grid_Monitoring_Failure', 'process', 1, 0, 0, '1'),
(17, 'inverter', 'PV_ST_Power_Limit_Set_Low', 'process', 1, 0, 0, '1'),
(18, 'inverter', 'PV_ST_Start_Command_Received', 'process', 1, 0, 0, '1'),
(19, 'inverter', 'PV_ST_MPPT_Minimum_Voltage_Reached', 'process', 1, 0, 0, '1'),
(20, 'inverter', 'PV_ST_MPPT_Maximum_Voltage_Reached', 'process', 1, 0, 0, '1'),
(21, 'inverter', 'PV_ST_Ext_DC_Ref_not_maint_due_to_power_limit', 'process', 1, 0, 0, '1'),
(22, 'inverter', 'PV_ST_DC_Voltage_Ramped_down_after_LVRT', 'process', 1, 0, 0, '1'),
(23, 'inverter', 'PV_ST_Grid_Volt_rise_suppression_function_active', 'process', 1, 0, 0, '1'),
(24, 'inverter', 'PV_ST_Anti_Islanding_Restart_delay_active', 'process', 1, 0, 0, '1'),
(25, 'inverter', 'PV_ST_Inverter_in_Reactive_Power_State', 'process', 1, 0, 0, '1'),
(26, 'inverter', 'GND_ST_DC_Grounding_Monitoring_Enabled', 'process', 1, 0, 0, '1'),
(27, 'inverter', 'GND_ST_Grounding_Contactor_Closed', 'process', 1, 0, 0, '1'),
(28, 'inverter', 'GND_ST_Inverter_Start_Enabled', 'process', 1, 0, 0, '1'),
(29, 'inverter', 'GND_ST_DC_Grounding_Control_Enabled', 'process', 1, 0, 0, '1'),
(30, 'inverter', 'GND_ST_Grounding_Contactor_Manually_Closed', 'process', 1, 0, 0, '1'),
(31, 'inverter', 'GND_ST_Grounding_Contactor_Manually_Opened', 'process', 1, 0, 0, '1'),
(32, 'inverter', 'GND_ST_Grounding_Contactor_Open_on_INV_Fault', 'process', 1, 0, 0, '1'),
(33, 'inverter', 'PV_ST', 'process', 1, 0, 0, '1'),
(34, 'inverter', 'GND_ST', 'process', 1, 0, 0, '1'),
(35, 'inverter', 'SUPPLY_FAULT_ERR_3284', 'process', 1, 0, 0, '1'),
(36, 'inverter', 'SUPPLY_FAULT_ERR_2380', 'process', 1, 0, 0, '1'),
(37, 'inverter', 'SUPPLY_FAULT_ERR_1081', 'process', 1, 0, 0, '1'),
(38, 'inverter', 'SUPPLY_FAULT_ERR_4291', 'process', 1, 1, 0, '4'),
(39, 'inverter', 'SUPPLY_FAULT_ERR_1080', 'process', 1, 0, 0, '1'),
(40, 'inverter', 'SUPPLY_FAULT_ERR_1082', 'process', 1, 1, 0, '4'),
(41, 'inverter', 'SUPPLY_FAULT_ERR_2384', 'process', 1, 1, 0, '4'),
(42, 'inverter', 'SUPPLY_FAULT_ERR_2381', 'process', 1, 1, 0, '4'),
(43, 'inverter', 'SUPPLY_FAULT_ERR_1083', 'process', 1, 1, 0, '4'),
(44, 'inverter', 'SUPPLY_FAULT_ERR_3285', 'process', 1, 0, 0, '1'),
(45, 'inverter', 'SUPPLY_FAULT_ERR_7581', 'process', 1, 1, 0, '4'),
(46, 'inverter', 'SUPPLY_FAULT_ERR_FF96', 'process', 1, 0, 0, '1'),
(47, 'inverter', 'SUPPLY_FAULT_ERR_2383', 'process', 1, 1, 0, '4'),
(48, 'inverter', 'SUPPLY_FAULT_ERR_8180', 'process', 1, 0, 0, '1'),
(49, 'inverter', 'SUPPLY_FAULT_ERR_3282', 'process', 1, 0, 0, '3'),
(50, 'inverter', 'SUPPLY_FAULT_ERR_32AF', 'process', 1, 0, 0, '3'),
(51, 'inverter', 'SUPPLY_ALARM_WARN_758A', 'process', 1, 0, 0, '3'),
(52, 'inverter', 'SUPPLY_ALARM_WARN_5382', 'process', 1, 0, 0, '3'),
(53, 'inverter', 'SUPPLY_ALARM_WARN_1089', 'process', 1, 0, 0, '3'),
(54, 'inverter', 'SUPPLY_ALARM_WARN_818B', 'process', 1, 0, 0, '3'),
(55, 'inverter', 'SUPPLY_ALARM_WARN_4292', 'process', 1, 0, 0, '3'),
(56, 'inverter', 'SUPPLY_ALARM_WARN_44AB', 'process', 1, 0, 0, '3'),
(57, 'inverter', 'SUPPLY_ALARM_WARN_44AC', 'process', 1, 0, 0, '3'),
(58, 'inverter', 'SUPPLY_ALARM_WARN_818F', 'process', 1, 0, 0, '3'),
(59, 'inverter', 'SUPPLY_ALARM_WARN_8194', 'process', 1, 0, 0, '3'),
(60, 'inverter', 'SUPPLY_ALARM_WARN_32A6', 'process', 1, 0, 0, '3'),
(61, 'inverter', 'SUPPLY_ALARM_WARN_108C', 'process', 1, 0, 0, '3'),
(62, 'inverter', 'SUPPLY_ALARM_WARN_32AA', 'process', 1, 0, 0, '3'),
(63, 'inverter', 'SUPPLY_ALARM_WARN_108A', 'process', 1, 0, 0, '3'),
(64, 'inverter', 'SUPPLY_ALARM_WARN_108B', 'process', 1, 0, 0, '3'),
(65, 'inverter', 'MCU_FAULT_ERR_7520', 'process', 1, 1, 0, '4'),
(66, 'inverter', 'MCU_FAULT_ERR_8187', 'process', 1, 1, 0, '4'),
(67, 'inverter', 'MCU_FAULT_ERR_8188', 'process', 1, 1, 0, '4'),
(68, 'inverter', 'MCU_FAULT_ERR_8189', 'process', 1, 1, 0, '4'),
(69, 'inverter', 'MCU_FAULT_ERR_818C', 'process', 1, 1, 0, '4'),
(70, 'inverter', 'MCU_FAULT_ERR_818D', 'process', 1, 1, 0, '4'),
(71, 'inverter', 'MCU_FAULT_ERR_818E', 'process', 1, 1, 0, '4'),
(72, 'inverter', 'MCU_FAULT_ERR_6080', 'process', 1, 1, 0, '4'),
(73, 'inverter', 'MCU_FAULT_ERR_9083', 'process', 1, 0, 0, '1'),
(74, 'inverter', 'MCU_FAULT_ERR_9084', 'process', 1, 0, 0, '1'),
(75, 'inverter', 'MCU_FAULT_ERR_9085', 'process', 1, 0, 0, '1'),
(76, 'inverter', 'MCU_FAULT_ERR_819F', 'process', 1, 1, 0, '4'),
(77, 'inverter', 'MCU_FAULT_ERR_F083', 'process', 1, 1, 0, '4'),
(78, 'inverter', 'MCU_FAULT_ERR_8185', 'process', 1, 1, 0, '4'),
(79, 'inverter', 'MCU_ALARM_WARN_32A9', 'process', 1, 0, 0, '1'),
(80, 'inverter', 'MCU_ALARM_WARN_FF54', 'process', 1, 0, 0, '1'),
(81, 'inverter', 'MCU_ALARM_WARN_6081', 'process', 1, 0, 0, '1'),
(82, 'inverter', 'MCU_ALARM_WARN_2185', 'process', 1, 0, 0, '1'),
(83, 'inverter', 'MCU_ALARM_WARN_8190', 'process', 1, 0, 0, '1'),
(84, 'inverter', 'MCU_ALARM_WARN_32A7', 'process', 1, 0, 0, '1'),
(85, 'inverter', 'MCU_ALARM_WARN_9083', 'process', 1, 0, 0, '1'),
(86, 'inverter', 'MCU_ALARM_WARN_9084', 'process', 1, 0, 0, '1'),
(87, 'inverter', 'MCU_ALARM_WARN_9085', 'process', 1, 0, 0, '1'),
(88, 'inverter', 'MCU_ALARM_WARN_FFD9', 'process', 1, 0, 0, '1'),
(89, 'inverter', 'MCU_ALARM_WARN_FFD6', 'process', 1, 0, 0, '1'),
(90, 'inverter', 'MCU_ALARM_WARN_FFD7', 'process', 1, 0, 0, '1'),
(91, 'inverter', 'MCU_ALARM_WARN_61AA', 'process', 1, 0, 0, '1'),
(92, 'inverter', 'MCU_ALARM2_WARN_32AD', 'process', 1, 0, 0, '1'),
(93, 'inverter', 'MCU_ALARM2_WARN_32AE', 'process', 1, 0, 0, '1'),
(94, 'inverter', 'MCU_ALARM2_WARN_8186', 'process', 1, 0, 0, '3'),
(95, 'IO', 'INV1_VF_FAIL', 'process', 1, 1, 0, '4'),
(96, 'IO', 'INV2_VF_FAIL', 'process', 1, 1, 0, '4'),
(97, 'IO', 'INV3_VF_FAIL', 'process', 1, 1, 0, '4'),
(98, 'IO', 'INV4_VF_FAIL', 'process', 1, 1, 0, '4'),
(99, 'IO', 'INR_VF_FAIL', 'process', 1, 1, 0, '4'),
(100, 'inverter', 'INR_RT_HIGH', 'process', 1, 0, 0, '3'),
(101, 'inverter', 'IGBT_OVERTEMP_Alarm', 'process', 1, 1, 0, '4'),
(102, 'CR_IO', 'GRID_FAIL', 'process', 1, 1, 0, '4'),
(103, 'SMU_INV_EM_PLANT', 'PR_Alarm', 'process', 1, 0, 0, '0'),
(104, 'IO', 'CB1_ON', 'process', 1, 0, 0, '1'),
(105, 'IO', 'CB1_OFF', 'process', 1, 0, 0, '1'),
(106, 'IO', 'CB1_TRIP', 'process', 1, 1, 0, '4'),
(107, 'IO', 'ITF_MECH_FAULT', 'process', 1, 1, 0, '4'),
(108, 'IO', 'CB2_ON', 'process', 1, 0, 0, '1'),
(109, 'IO', 'CB2_OFF', 'process', 1, 0, 0, '1'),
(110, 'IO', 'CB2_TRIP', 'process', 1, 1, 0, '4'),
(111, 'IO', 'ITF_TRIP_HEALTHY', 'process', 1, 1, 0, '4'),
(112, 'IO', 'WD_ALARM', 'process', 1, 1, 0, '4'),
(113, 'IO', 'ITF_OTI_BU_AL', 'process', 1, 0, 0, '3'),
(114, 'IO', 'ITF_WTI_MO_AL', 'process', 1, 0, 0, '3'),
(115, 'IO', 'INV1_ON', 'process', 1, 0, 0, '1'),
(116, 'IO', 'INV2_ON', 'process', 1, 0, 0, '1'),
(117, 'IO', 'INV3_ON', 'process', 1, 0, 0, '1'),
(118, 'IO', 'INV4_ON', 'process', 1, 0, 0, '1'),
(119, 'IO', 'INV1_VF_ON', 'process', 1, 0, 0, '1'),
(120, 'IO', 'INV2_VF_ON', 'process', 1, 0, 0, '1'),
(121, 'IO', 'INV3_VF_ON', 'process', 1, 0, 0, '1'),
(122, 'IO', 'INV4_VF_ON', 'process', 1, 0, 0, '1'),
(123, 'IO', 'INR_VF_ON', 'process', 1, 0, 0, '1'),
(124, 'IO', 'INR_PL_ON', 'process', 1, 0, 0, '1'),
(125, 'IO', 'BAT_CHARGE_ALARM', 'process', 1, 0, 0, '1'),
(126, 'IO', 'INR_SMKD_OPTD', 'fire', 1, 1, 0, '4'),
(127, 'IO', 'WMCP_ON', 'fire', 1, 0, 0, '4'),
(128, 'CR_IO', '33KV_FEEDER1_CB_CF', 'process', 1, 0, 0, '1'),
(129, 'CR_IO', '33KV_FEEDER1_CB_OF', 'process', 1, 0, 0, '1'),
(130, 'CR_IO', '33KV_FEEDER1_CB_TRIP', 'process', 1, 1, 0, '4'),
(131, 'CR_IO', '33KV_FEEDER1_ISO_CF', 'process', 1, 0, 0, '1'),
(132, 'CR_IO', '33KV_FEEDER1_ISO_ES_CF', 'process', 1, 0, 0, '1'),
(133, 'CR_IO', '33KV_FEEDER2_CB_CF', 'process', 1, 0, 0, '1'),
(134, 'CR_IO', '33KV_FEEDER2_CB_OF', 'process', 1, 0, 0, '1'),
(135, 'CR_IO', '33KV_FEEDER2_CB_TRIP', 'process', 1, 1, 0, '4'),
(136, 'CR_IO', '33KV_FEEDER2_ISO_CF', 'process', 1, 0, 0, '1'),
(137, 'CR_IO', '33KV_FEEDER2_ISO_ES_CF', 'process', 1, 0, 0, '1'),
(138, 'CR_IO', '33KV_FEEDER3_CB_CF', 'process', 1, 0, 0, '1'),
(139, 'CR_IO', '33KV_FEEDER3_CB_OF', 'process', 1, 0, 0, '1'),
(140, 'CR_IO', '33KV_FEEDER3_CB_TRIP', 'process', 1, 1, 0, '4'),
(141, 'CR_IO', '33KV_FEEDER3_ISO_CF', 'process', 1, 0, 0, '1'),
(142, 'CR_IO', '33KV_FEEDER3_ISO_ES_CF', 'process', 1, 0, 0, '1'),
(143, 'CR_IO', '33KV_FEEDER4_CB_CF', 'process', 1, 0, 0, '1'),
(144, 'CR_IO', '33KV_FEEDER4_CB_OF', 'process', 1, 0, 0, '1'),
(145, 'CR_IO', '33KV_FEEDER4_CB_TRIP', 'process', 1, 1, 0, '4'),
(146, 'CR_IO', '33KV_FEEDER4_ISO_CF', 'process', 1, 0, 0, '1'),
(147, 'CR_IO', '33KV_FEEDER4_ISO_ES_CF', 'process', 1, 0, 0, '1'),
(148, 'CR_IO', '33KV_BUS_SEC_CF', 'process', 1, 0, 0, '1'),
(149, 'CR_IO', '33KV_STF1_CB_CF', 'process', 1, 0, 0, '1'),
(150, 'CR_IO', '33KV_STF1_CB_OF', 'process', 1, 0, 0, '1'),
(151, 'CR_IO', '33KV_STF1_ISO_CF', 'process', 1, 0, 0, '1'),
(152, 'CR_IO', '33KV_STF1_ISO_ES1_CF', 'process', 1, 0, 0, '1'),
(153, 'CR_IO', '33KV_STF1_ISO_ES2_CF', 'process', 1, 0, 0, '1'),
(154, 'CR_IO', '33KV_STF2_CB_CF', 'process', 1, 0, 0, '1'),
(155, 'CR_IO', '33KV_STF2_CB_OF', 'process', 1, 0, 0, '1'),
(156, 'CR_IO', '33KV_STF2_ISO_CF', 'process', 1, 0, 0, '1'),
(157, 'CR_IO', '33KV_STF2_ISO_ES1_CF', 'process', 1, 0, 0, '1'),
(158, 'CR_IO', '33KV_STF2_ISO_ES2_CF', 'process', 1, 0, 0, '1'),
(159, 'CR_IO', '110KV_STF1_CB_CF', 'process', 1, 0, 0, '1'),
(160, 'CR_IO', '110KV_STF1_CB_OF', 'process', 1, 0, 0, '1'),
(161, 'CR_IO', '110KV_STF1_BACKUP_RLY_OPTD', 'process', 1, 1, 0, '4'),
(162, 'CR_IO', '110KV_STF1_CB_TCH', 'process', 1, 1, 0, '4'),
(163, 'CR_IO', '110KV_STF1_CB_WD_OPTD', 'process', 1, 1, 0, '4'),
(164, 'CR_IO', '110KV_STF1_ISO_CF', 'process', 1, 0, 0, '1'),
(165, 'CR_IO', '110KV_STF1_ISO_ES_CF', 'process', 1, 0, 0, '1'),
(166, 'CR_IO', '110KV_STF2_CB_CF', 'process', 1, 0, 0, '1'),
(167, 'CR_IO', '110KV_STF2_CB_OF', 'process', 1, 0, 0, '1'),
(168, 'CR_IO', '110KV_STF2_BACKUP_RLY_OPTD', 'process', 1, 1, 0, '4'),
(169, 'CR_IO', '110KV_STF2_CB_TCH', 'process', 1, 1, 0, '4'),
(170, 'CR_IO', '110KV_STF2_CB_WD_OPTD', 'process', 1, 1, 0, '4'),
(171, 'CR_IO', '110KV_LF1_CB_CF', 'process', 1, 0, 0, '1'),
(172, 'CR_IO', '110KV_LF1_CB_OF', 'process', 1, 0, 0, '1'),
(173, 'CR_IO', '110KV_LINE1_CB_RLY_OPTD', 'process', 1, 1, 0, '4'),
(174, 'CR_IO', '110KV_LINE1_CB_TCH', 'process', 1, 1, 0, '4'),
(175, 'CR_IO', '110KV_LINE1_CB_WD_OPTD', 'process', 1, 1, 0, '4'),
(176, 'CR_IO', '110KV_BUS_ISO_CF', 'process', 1, 0, 0, '1'),
(177, 'CR_IO', '110KV_BUS_ISO_ES1_CF', 'process', 1, 0, 0, '1'),
(178, 'CR_IO', '110KV_BUS_ISO_ES2_CF', 'process', 1, 0, 0, '1'),
(179, 'CR_IO', '110KV_LINE1_ISO_CF', 'process', 1, 0, 0, '1'),
(180, 'CR_IO', '110KV_LINE1_ISO_ES_CF', 'process', 1, 0, 0, '1'),
(181, 'CR_IO', 'MAIN_STF1_OTI_BU_AL', 'process', 1, 0, 0, '3'),
(182, 'CR_IO', 'MAIN_STF1_WTI_OSR_AL', 'process', 1, 0, 0, '3'),
(183, 'CR_IO', 'MAIN_STF2_OTI_BU_AL', 'process', 1, 0, 0, '3'),
(184, 'CR_IO', 'MAIN_STF2_WTI_OSR_AL', 'process', 1, 0, 0, '3'),
(185, 'CR_IO', 'SMKD_OPTD_CTRL_ROOM', 'fire', 1, 1, 0, '4'),
(186, 'CR_IO', 'SMKD_OPTD_PANEL_ROOM', 'fire', 1, 1, 0, '4'),
(187, 'CR_IO', 'SMKD_OPTD_FCBC_ROOM', 'fire', 1, 1, 0, '4'),
(188, 'CR_IO', 'SMKD_OPTD_BAT_ROOM', 'fire', 1, 1, 0, '4'),
(189, 'CR_IO', 'SMKD_OPTD_LOBBY', 'fire', 1, 1, 0, '4'),
(190, 'CR_IO', 'FCP1_OPTD', 'fire', 1, 1, 0, '4'),
(191, 'CR_IO', 'FCP2_OPTD', 'fire', 1, 1, 0, '4'),
(192, 'smu', 'OUTDSS', 'process', 0, 0, 0, '2'),
(193, 'smu', 'OUTDSS_Alarm', 'process', 1, 0, 0, '2'),
(194, 'smu', 'SPD', 'process', 1, 0, 0, '2'),
(195, 'smu', 'SPD_Alarm', 'process', 1, 0, 0, '2'),
(196, 'smu', 'OVERTEMP', 'process', 1, 0, 0, '2'),
(197, 'smu', 'OVERTEMP_Alarm', 'process', 1, 0, 0, '2'),
(198, 'smu', 'OVERVOLT', 'process', 1, 0, 0, '2'),
(199, 'smu', 'OVERVOLT_Alarm', 'process', 1, 0, 0, '2'),
(200, 'smu', 'UNBALANCE', 'process', 1, 0, 0, '2'),
(201, 'smu', 'UNBALANCE_Alarm', 'process', 1, 0, 0, '2'),
(202, 'smu', 'IDC1_Alarm', 'process', 1, 0, 0, '2'),
(203, 'smu', 'IDC2_Alarm', 'process', 1, 0, 0, '2'),
(204, 'smu', 'IDC3_Alarm', 'process', 1, 0, 0, '2'),
(205, 'smu', 'IDC4_Alarm', 'process', 1, 0, 0, '2'),
(206, 'smu', 'IDC5_Alarm', 'process', 1, 0, 0, '2'),
(207, 'smu', 'IDC6_Alarm', 'process', 1, 0, 0, '2'),
(208, 'inverter', 'INV_FAULT_CODE', 'process', 1, 1, 0, '4'),
(209, 'inverter', 'INV_ALARM_CODE', 'process', 1, 1, 0, '4'),
(210, 'inverter', 'MCU_FAULT_ERR_7510', 'process', 1, 1, 0, '4'),
(211, 'inverter', 'MCU_ALARM_WARN_61A9', 'process', 1, 0, 0, '1'),
(212, 'CR_IO', '33KV_FEEDER2_CB_TCH', 'process', 1, 1, 0, '4'),
(213, 'CR_IO', '33KV_FEEDER3_CB_TCH', 'process', 1, 1, 0, '4'),
(214, 'CR_IO', '33KV_FEEDER4_CB_TCH', 'process', 1, 1, 0, '4'),
(215, 'CR_IO', '110KV_STF1_CB_DIFF_RLY_OPTD', 'process', 1, 1, 0, '4'),
(216, 'CR_IO', '110KV_STF2_CB_DIFF_RLY_OPTD', 'process', 1, 1, 0, '4'),
(217, 'CR_IO', '110KV_LINE1_CB_86_OPTD', 'process', 1, 1, 0, '4'),
(218, 'CR_IO', 'MAIN_STF1_WTI_PRV_AL', 'process', 1, 0, 0, '3'),
(219, 'CR_IO', 'MAIN_STF2_WTI_PRV_AL', 'process', 1, 0, 0, '3'),
(220, 'IO', 'ITF_OTI_Alarm', 'process', 0, 0, 0, '1'),
(221, 'IO', 'ITF_WTI_Alarm', 'process', 0, 0, 0, '1'),
(222, 'IO', 'INR_RT_Alarm', 'process', 1, 0, 0, '1'),
(223, 'IO', 'MODULE_TEMP_Alarm', 'process', 1, 0, 0, '1'),
(224, 'CR_IO', 'MAIN_STF1_OTI_Alarm', 'process', 0, 0, 0, '1'),
(225, 'CR_IO', 'MAIN_STF1_WTI_Alarm', 'process', 0, 0, 0, '1'),
(226, 'CR_IO', 'MAIN_STF2_OTI_Alarm', 'process', 0, 0, 0, '1'),
(227, 'CR_IO', 'MAIN_STF2_WTI_Alarm', 'process', 0, 0, 0, '1'),
(228, 'CR_IO', 'CTRL_RT_Alarm', 'process', 1, 0, 0, '1'),
(229, 'CR_IO', 'PANEL_RT_Alarm', 'process', 1, 0, 0, '1'),
(230, 'IO', 'INV1_ON_OFF', 'event', 1, 0, 0, 'N'),
(231, 'IO', 'INV2_ON_OFF', 'event', 1, 0, 0, 'N'),
(232, 'IO', 'INV3_ON_OFF', 'event', 1, 0, 0, 'N'),
(233, 'IO', 'INV4_ON_OFF', 'event', 1, 0, 0, 'N'),
(234, 'IO', 'INV1_VF_ON_OFF', 'event', 1, 0, 0, 'N'),
(235, 'IO', 'INV2_VF_ON_OFF', 'event', 1, 0, 0, 'N'),
(236, 'IO', 'INV3_VF_ON_OFF', 'event', 1, 0, 0, 'N'),
(237, 'IO', 'INV4_VF_ON_OFF', 'event', 1, 0, 0, 'N'),
(238, 'IO', 'INR_VF_ON_OFF', 'event', 1, 0, 0, 'N'),
(239, 'IO', 'INR_PL_ON_OFF', 'event', 1, 0, 0, 'N'),
(240, 'IO', 'CB1_CMD', 'event', 1, 0, 0, 'N'),
(243, 'IO', 'B01_EAI_DAY', 'process', 1, 0, 0, '3');

--
-- Dumping data for table `day_variable_fields`
--

INSERT INTO `day_variable_fields` (`id`, `type`, `field`, `status`) VALUES
(1, 'EM', 'EAI_DAY', 1),
(3, 'EM', 'PR', 1),
(4, 'EM', 'PR_DAY', 1),
(6, 'INV', 'PR', 1),
(7, 'INV', 'PR_DAY', 1),
(8, 'INV', 'START_TIME', 1),
(9, 'INV', 'STOP_TIME', 1),
(10, 'SMU', 'PR', 1),
(11, 'SMU', 'PR_DAY', 1),
(87, 'CR_EM', 'GRID_AVAILABILITY', 1),
(86, 'CR_EM', 'PF_MIN', 1),
(85, 'IO', 'INR_RT_AVG', 1),
(15, 'CR_EM', 'CUF', 1),
(16, 'CR_EM', 'EAE', 1),
(17, 'CR_EM', 'EAN_DAY', 1),
(18, 'CR_EM', 'EAE_DAY', 1),
(19, 'CR_EM', 'EAI', 1),
(20, 'CR_EM', 'EAI_DAY', 1),
(21, 'CR_EM', 'PR', 1),
(22, 'CR_EM', 'PR_DAY', 1),
(33, 'WS', 'AMBIENT_TEMP_AVG', 1),
(34, 'WS', 'AMBIENT_TEMP_MAX', 1),
(35, 'WS', 'AMBIENT_TEMP_MIN', 1),
(36, 'WS', 'AMBIENT_TEMP_AVG_OT', 1),
(37, 'WS', 'AMBIENT_TEMP_MAX_OT', 1),
(38, 'WS', 'AMBIENT_TEMP_MIN_OT', 1),
(39, 'WS', 'MODULE_TEMP', 1),
(90, 'CR_EM', 'QAC_MIN', 1),
(45, 'WS', 'MODULE_TEMP_MAX', 1),
(46, 'WS', 'MODULE_TEMP_MIN', 1),
(89, 'CR_IO', 'MAIN_STF2_WTI_MAX', 1),
(88, 'CR_IO', 'MAIN_STF1_WTI_MAX', 1),
(50, 'WS', 'RELATIVE_HUMITIDY', 1),
(51, 'WS', 'SOLAR_RADIATION', 1),
(52, 'WS', 'SOLAR_RADIATION_AVG', 1),
(53, 'WS', 'SOLAR_RADIATION_MAX', 1),
(54, 'WS', 'WIND_DIRECTION', 1),
(55, 'WS', 'WIND_DIRECTION_DAY', 1),
(56, 'WS', 'WIND_SPEED', 1),
(57, 'WS', 'WIND_SPEED_DAY', 1),
(58, 'WS', 'WIND_SPEED_MAX', 1),
(60, 'CR_EM', 'PAC_MAX', 1),
(61, 'CR_IO', 'MAIN_STF1_WTI_AVG', 1),
(62, 'CR_IO', 'MAIN_STF1_OTI_AVG', 1),
(63, 'INV', 'EDC_DAY', 1),
(64, 'INV', 'IGBT_TEMP_MAX', 1),
(65, 'INV', 'PR_MIN', 1),
(66, 'SMU', 'COMMUNICATION_DAY', 1),
(67, 'SMU', 'E_DAY', 1),
(68, 'IO', 'INR_RT_MAX', 1),
(69, 'WS', 'MODULE_TEMP_AVG_OT', 1),
(70, 'WS', 'MODULE_TEMP_MIN_OT', 1),
(71, 'WS', 'MODULE_TEMP_MAX_OT', 1),
(72, 'WS', 'WIND_SPEED_AVG', 1),
(73, 'WS', 'SOLAR_RADIATION_CUM', 1),
(74, 'WS', 'WIND_DIRECTION_AVG', 1),
(75, 'WS', 'WIND_SPEED_OT', 1),
(76, 'WS', 'WIND_SPEED_MIN', 1),
(77, 'CR_EM', 'EQE_DAY', 1),
(78, 'CR_EM', 'EQI_DAY', 1),
(79, 'INV', 'EAEN_DAY', 1),
(80, 'PLANT', 'OPERATIONAL_TIME', 1),
(81, 'WS', 'MODULE_TEMP_AVG', 1),
(82, 'WS', 'SOLAR_RADIATION_MIN', 1),
(84, 'WS', 'WIND_SPEED_AVG_OT', 1),
(91, 'INV', 'ITF_OTI_AVG', 1),
(92, 'INV', 'ITF_OTI_MAX', 1),
(93, 'INV', 'ITF_WTI_AVG', 1),
(94, 'INV', 'ITF_WTI_MAX', 1),
(95, 'INV', 'ITF_OTI_AVG', 1),
(96, 'INV', 'ITF_OTI_MAX', 1),
(97, 'INV', 'ITF_WTI_AVG', 1),
(98, 'INV', 'ITF_WTI_MAX', 1);

--
-- Dumping data for table `smustringconn`
--

INSERT INTO `smustringconn` (`id`, `block`, `device`, `module`, `num_strings_connected`, `num_module_connected`) VALUES
(1, 'B01', 'B01_INV1_SMU01', 'TRINA_305', 0, 0),
(2, 'B01', 'B01_INV1_SMU02', 'TRINA_305', 0, 0),
(3, 'B01', 'B01_INV1_SMU03', 'TRINA_305', 0, 0),
(4, 'B01', 'B01_INV1_SMU04', 'TRINA_305', 0, 0),
(5, 'B01', 'B01_INV1_SMU05', 'TRINA_305', 0, 0),
(6, 'B01', 'B01_INV1_SMU06', 'TRINA_305', 0, 0),
(7, 'B01', 'B01_INV1_SMU07', 'TRINA_305', 0, 0),
(8, 'B01', 'B01_INV1_SMU08', 'TRINA_305', 0, 0),
(9, 'B01', 'B01_INV2_SMU09', 'TRINA_305', 0, 0),
(10, 'B01', 'B01_INV2_SMU10', 'TRINA_305', 0, 0),
(11, 'B01', 'B01_INV2_SMU11', 'TRINA_305', 0, 0),
(12, 'B01', 'B01_INV2_SMU12', 'TRINA_305', 0, 0),
(13, 'B01', 'B01_INV2_SMU13', 'TRINA_305', 0, 0),
(14, 'B01', 'B01_INV2_SMU14', 'TRINA_305', 0, 0),
(15, 'B01', 'B01_INV2_SMU15', 'TRINA_305', 0, 0),
(16, 'B01', 'B01_INV2_SMU16', 'TRINA_305', 0, 0),
(17, 'B01', 'B01_INV3_SMU17', 'TRINA_305', 0, 0),
(18, 'B01', 'B01_INV3_SMU18', 'TRINA_305', 0, 0),
(19, 'B01', 'B01_INV3_SMU19', 'TRINA_305', 0, 0),
(20, 'B01', 'B01_INV3_SMU20', 'TRINA_305', 0, 0),
(21, 'B01', 'B01_INV3_SMU21', 'TRINA_305', 0, 0),
(22, 'B01', 'B01_INV3_SMU22', 'TRINA_305', 0, 0),
(23, 'B01', 'B01_INV3_SMU23', 'TRINA_305', 0, 0),
(24, 'B01', 'B01_INV3_SMU24', 'TRINA_305', 0, 0),
(25, 'B01', 'B01_INV4_SMU25', 'TRINA_305', 0, 0),
(26, 'B01', 'B01_INV4_SMU26', 'TRINA_305', 0, 0),
(27, 'B01', 'B01_INV4_SMU27', 'TRINA_305', 0, 0),
(28, 'B01', 'B01_INV4_SMU28', 'TRINA_305', 0, 0),
(29, 'B01', 'B01_INV4_SMU29', 'TRINA_305', 0, 0),
(30, 'B01', 'B01_INV4_SMU30', 'TRINA_305', 0, 0),
(31, 'B01', 'B01_INV4_SMU31', 'TRINA_305', 0, 0),
(32, 'B01', 'B01_INV4_SMU32', 'TRINA_305', 0, 0),
(33, 'B02', 'B02_INV1_SMU01', 'TRINA_305', 0, 0),
(34, 'B02', 'B02_INV1_SMU02', 'TRINA_305', 0, 0),
(35, 'B02', 'B02_INV1_SMU03', 'TRINA_305', 0, 0),
(36, 'B02', 'B02_INV1_SMU04', 'TRINA_305', 0, 0),
(37, 'B02', 'B02_INV1_SMU05', 'TRINA_305', 0, 0),
(38, 'B02', 'B02_INV1_SMU06', 'TRINA_305', 0, 0),
(39, 'B02', 'B02_INV1_SMU07', 'TRINA_305', 0, 0),
(40, 'B02', 'B02_INV1_SMU08', 'TRINA_305', 0, 0),
(41, 'B02', 'B02_INV2_SMU09', 'TRINA_305', 0, 0),
(42, 'B02', 'B02_INV2_SMU10', 'TRINA_305', 0, 0),
(43, 'B02', 'B02_INV2_SMU11', 'TRINA_305', 0, 0),
(44, 'B02', 'B02_INV2_SMU12', 'TRINA_305', 0, 0),
(45, 'B02', 'B02_INV2_SMU13', 'TRINA_305', 0, 0),
(46, 'B02', 'B02_INV2_SMU14', 'TRINA_305', 0, 0),
(47, 'B02', 'B02_INV2_SMU15', 'TRINA_305', 0, 0),
(48, 'B02', 'B02_INV2_SMU16', 'TRINA_305', 0, 0),
(49, 'B02', 'B02_INV3_SMU17', 'TRINA_305', 0, 0),
(50, 'B02', 'B02_INV3_SMU18', 'TRINA_305', 0, 0),
(51, 'B02', 'B02_INV3_SMU19', 'TRINA_305', 0, 0),
(52, 'B02', 'B02_INV3_SMU20', 'TRINA_305', 0, 0),
(53, 'B02', 'B02_INV3_SMU21', 'TRINA_305', 0, 0),
(54, 'B02', 'B02_INV3_SMU22', 'TRINA_305', 0, 0),
(55, 'B02', 'B02_INV3_SMU23', 'TRINA_305', 0, 0),
(56, 'B02', 'B02_INV3_SMU24', 'TRINA_305', 0, 0),
(57, 'B02', 'B02_INV4_SMU25', 'TRINA_305', 0, 0),
(58, 'B02', 'B02_INV4_SMU26', 'TRINA_305', 0, 0),
(59, 'B02', 'B02_INV4_SMU27', 'TRINA_305', 0, 0),
(60, 'B02', 'B02_INV4_SMU28', 'TRINA_305', 0, 0),
(61, 'B02', 'B02_INV4_SMU29', 'TRINA_305', 0, 0),
(62, 'B02', 'B02_INV4_SMU30', 'TRINA_305', 0, 0),
(63, 'B02', 'B02_INV4_SMU31', 'TRINA_305', 0, 0),
(64, 'B02', 'B02_INV4_SMU32', 'TRINA_305', 0, 0),
(65, 'B03', 'B03_INV1_SMU01', 'TRINA_305', 0, 0),
(66, 'B03', 'B03_INV1_SMU02', 'TRINA_305', 0, 0),
(67, 'B03', 'B03_INV1_SMU03', 'TRINA_305', 0, 0),
(68, 'B03', 'B03_INV1_SMU04', 'TRINA_305', 0, 0),
(69, 'B03', 'B03_INV1_SMU05', 'TRINA_305', 0, 0),
(70, 'B03', 'B03_INV1_SMU06', 'TRINA_305', 0, 0),
(71, 'B03', 'B03_INV1_SMU07', 'TRINA_305', 0, 0),
(72, 'B03', 'B03_INV1_SMU08', 'TRINA_305', 0, 0),
(73, 'B03', 'B03_INV2_SMU09', 'TRINA_305', 0, 0),
(74, 'B03', 'B03_INV2_SMU10', 'TRINA_305', 0, 0),
(75, 'B03', 'B03_INV2_SMU11', 'TRINA_305', 0, 0),
(76, 'B03', 'B03_INV2_SMU12', 'TRINA_305', 0, 0),
(77, 'B03', 'B03_INV2_SMU13', 'TRINA_305', 0, 0),
(78, 'B03', 'B03_INV2_SMU14', 'TRINA_305', 0, 0),
(79, 'B03', 'B03_INV2_SMU15', 'TRINA_305', 0, 0),
(80, 'B03', 'B03_INV2_SMU16', 'TRINA_305', 0, 0),
(81, 'B04', 'B04_INV1_SMU01', 'TRINA_305', 0, 0),
(82, 'B04', 'B04_INV1_SMU02', 'TRINA_305', 0, 0),
(83, 'B04', 'B04_INV1_SMU03', 'TRINA_305', 0, 0),
(84, 'B04', 'B04_INV1_SMU04', 'TRINA_305', 0, 0),
(85, 'B04', 'B04_INV1_SMU05', 'TRINA_305', 0, 0),
(86, 'B04', 'B04_INV1_SMU06', 'TRINA_305', 0, 0),
(87, 'B04', 'B04_INV1_SMU07', 'TRINA_305', 0, 0),
(88, 'B04', 'B04_INV1_SMU08', 'TRINA_305', 0, 0),
(89, 'B04', 'B04_INV2_SMU09', 'TRINA_305', 0, 0),
(90, 'B04', 'B04_INV2_SMU10', 'TRINA_305', 0, 0),
(91, 'B04', 'B04_INV2_SMU11', 'TRINA_305', 0, 0),
(92, 'B04', 'B04_INV2_SMU12', 'TRINA_305', 0, 0),
(93, 'B04', 'B04_INV2_SMU13', 'TRINA_305', 0, 0),
(94, 'B04', 'B04_INV2_SMU14', 'TRINA_305', 0, 0),
(95, 'B04', 'B04_INV2_SMU15', 'TRINA_305', 0, 0),
(96, 'B04', 'B04_INV2_SMU16', 'TRINA_305', 0, 0),
(97, 'B04', 'B04_INV3_SMU17', 'TRINA_305', 0, 0),
(98, 'B04', 'B04_INV3_SMU18', 'TRINA_305', 0, 0),
(99, 'B04', 'B04_INV3_SMU19', 'TRINA_305', 0, 0),
(100, 'B04', 'B04_INV3_SMU20', 'TRINA_305', 0, 0),
(101, 'B04', 'B04_INV3_SMU21', 'TRINA_305', 0, 0),
(102, 'B04', 'B04_INV3_SMU22', 'TRINA_305', 0, 0),
(103, 'B04', 'B04_INV3_SMU23', 'TRINA_305', 0, 0),
(104, 'B04', 'B04_INV3_SMU24', 'TRINA_305', 0, 0),
(105, 'B04', 'B04_INV4_SMU25', 'TRINA_305', 0, 0),
(106, 'B04', 'B04_INV4_SMU26', 'TRINA_305', 0, 0),
(107, 'B04', 'B04_INV4_SMU27', 'TRINA_305', 0, 0),
(108, 'B04', 'B04_INV4_SMU28', 'TRINA_305', 0, 0),
(109, 'B04', 'B04_INV4_SMU29', 'TRINA_305', 0, 0),
(110, 'B04', 'B04_INV4_SMU30', 'TRINA_305', 0, 0),
(111, 'B04', 'B04_INV4_SMU31', 'TRINA_305', 0, 0),
(112, 'B04', 'B04_INV4_SMU32', 'TRINA_305', 0, 0);

--
-- Dumping data for table `system_architecture`
--

INSERT INTO `system_architecture` (`block`, `device`, `field`, `value`, `solved`, `ack`) VALUES
('B01', 'B01_iGatePV3801', 'CHANNEL1_STATUS', '0', 'yes', 'yes'),
('B01', 'B01_iGatePV3801', 'CHANNEL2_STATUS', '0', 'yes', 'yes'),
('B01', 'B01_iGatePV3801', 'CHANNEL3_STATUS', '0', 'yes', 'yes'),
('B01', 'B01_iGatePV3851', 'CHANNEL1_STATUS', '0', 'yes', 'yes'),
('B01', 'B01_iGatePV3851', 'CHANNEL2_STATUS', '0', 'yes', 'yes'),
('B01', 'B01_iGatePV3851', 'CHANNEL3_STATUS', '0', 'yes', 'yes'),
('B01', 'B01_iGatePV3851', 'CHANNEL4_STATUS', '0', 'yes', 'yes'),
('B02', 'B02_iGatePV3802', 'CHANNEL1_STATUS', '0', 'yes', 'yes'),
('B02', 'B02_iGatePV3802', 'CHANNEL2_STATUS', '2', 'no', 'yes'),
('B02', 'B02_iGatePV3802', 'CHANNEL3_STATUS', '0', 'yes', 'yes'),
('B02', 'B02_iGatePV3852', 'CHANNEL1_STATUS', '0', 'yes', 'yes'),
('B02', 'B02_iGatePV3852', 'CHANNEL2_STATUS', '2', 'no', 'yes'),
('B02', 'B02_iGatePV3852', 'CHANNEL3_STATUS', '0', 'yes', 'yes'),
('B02', 'B02_iGatePV3852', 'CHANNEL4_STATUS', '0', 'yes', 'yes'),
('B03', 'B03_iGatePV3803', 'CHANNEL1_STATUS', '0', 'yes', 'yes'),
('B03', 'B03_iGatePV3803', 'CHANNEL2_STATUS', '2', 'no', 'yes'),
('B03', 'B03_iGatePV3803', 'CHANNEL3_STATUS', '0', 'yes', 'yes'),
('B03', 'B03_iGatePV3803', 'CHANNEL4_STATUS', '2', 'no', 'yes'),
('B04', 'B04_iGatePV3804', 'CHANNEL1_STATUS', '0', 'yes', 'yes'),
('B04', 'B04_iGatePV3804', 'CHANNEL2_STATUS', '2', 'no', 'yes'),
('B04', 'B04_iGatePV3804', 'CHANNEL3_STATUS', '0', 'yes', 'yes'),
('B04', 'B04_iGatePV3854', 'CHANNEL1_STATUS', '2', 'no', 'yes'),
('B04', 'B04_iGatePV3854', 'CHANNEL2_STATUS', '0', 'yes', 'yes'),
('B04', 'B04_iGatePV3854', 'CHANNEL3_STATUS', '0', 'yes', 'yes'),
('B04', 'B04_iGatePV3854', 'CHANNEL4_STATUS', '0', 'yes', 'yes'),
('CR', 'B01', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B01', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B01', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B01', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B01', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B02', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B02', 'FO2_LINK', '0', 'yes', 'yes'),
('CR', 'B02', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B02', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B02', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B03', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B03', 'FO2_LINK', '0', 'yes', 'yes'),
('CR', 'B03', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B03', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B03', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B04', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B04', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B04', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B04', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B04', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B05', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B05', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B05', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B05', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B05', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B06', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B06', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B06', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B06', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B06', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B07', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B07', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B07', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B07', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B07', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B08', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B08', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B08', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B08', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B08', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B09', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B09', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B09', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B09', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B09', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B10', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B10', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B10', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B10', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B10', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B11', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B11', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B11', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B11', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B11', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B12', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B12', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B12', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B12', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B12', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B13', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B13', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B13', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B13', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B13', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B14', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B14', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B14', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B14', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B14', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B15', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B15', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B15', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B15', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B15', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B16', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B16', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B16', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B16', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B16', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B17', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B17', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B17', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B17', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B17', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B18', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B18', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B18', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B18', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B18', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B19', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B19', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B19', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B19', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B19', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B20', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B20', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B20', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B20', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B20', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B21', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B21', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B21', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B21', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B21', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B22', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B22', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B22', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B22', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B22', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B23', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B23', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B23', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B23', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B23', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B24', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B24', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B24', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B24', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B24', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B25', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B25', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B25', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B25', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B25', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B26', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B26', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B26', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B26', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B26', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'B27', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'B27', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'B27', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'B27', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'B27', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'CR1', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'CR1', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'CR1', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'CR1', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'CR1', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'CR2', 'FO1_LINK', '2', 'no', 'yes'),
('CR', 'CR2', 'FO2_LINK', '2', 'no', 'yes'),
('CR', 'CR2', 'iGATE1_LINK', '2', 'no', 'yes'),
('CR', 'CR2', 'iGATE2_LINK', '2', 'no', 'yes'),
('CR', 'CR2', 'IO_LINK', '2', 'no', 'yes'),
('CR', 'CR1_iGatePV3891', 'CHANNEL1_STATUS', '0', 'yes', 'yes'),
('CR', 'CR1_iGatePV3891', 'CHANNEL2_STATUS', '2', 'no', 'yes'),
('CR', 'CR1_iGatePV3891', 'CHANNEL3_STATUS', '0', 'yes', 'yes'),
('B01', 'B01_iGatePV3801', 'COMMUNICATION_STATUS', '0', 'yes', 'yes'),
('B01', 'B01_iGatePV3851', 'COMMUNICATION_STATUS', '0', 'yes', 'yes'),
('B01', 'B01_IO', 'COMMUNICATION_STATUS', '0', 'yes', 'yes'),
('B02', 'B02_iGatePV3802', 'COMMUNICATION_STATUS', '0', 'yes', 'yes'),
('B02', 'B02_iGatePV3852', 'COMMUNICATION_STATUS', '0', 'yes', 'yes'),
('B02', 'B02_IO', 'COMMUNICATION_STATUS', '0', 'yes', 'yes'),
('B03', 'B03_iGatePV3803', 'COMMUNICATION_STATUS', '0', 'yes', 'yes'),
('B03', 'B03_IO', 'COMMUNICATION_STATUS', '0', 'yes', 'yes'),
('B04', 'B04_iGatePV3804', 'COMMUNICATION_STATUS', '0', 'yes', 'yes'),
('B04', 'B04_iGatePV3854', 'COMMUNICATION_STATUS', '0', 'yes', 'yes'),
('B04', 'B04_IO', 'COMMUNICATION_STATUS', '0', 'yes', 'yes'),
('CR', 'CR1_iGatePV3891', 'COMMUNICATION_STATUS', '0', 'yes', 'yes'),
('CR', 'CR1_IO', 'COMMUNICATION_STATUS', '0', 'yes', 'yes'),
('B03', 'B03_iGatePV3803', 'CHANNEL5_STATUS', '2', 'no', 'yes'),
('CR', 'PS3882', 'COMMUNICATION_STATUS', '2', 'no', 'yes'),
('CR', 'SS3883', 'COMMUNICATION_STATUS', '0', 'yes', 'yes'),
('CR', 'PDS3884', 'COMMUNICATION_STATUS', '0', 'yes', 'yes'),
('CR', 'WS13872', 'COMMUNICATION_STATUS', '2', 'no', 'yes'),
('CR', 'WS23873', 'COMMUNICATION_STATUS', '2', 'no', 'yes');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
