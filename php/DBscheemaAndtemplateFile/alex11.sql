-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2022 at 02:16 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alex11`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int(11) NOT NULL,
  `cellno` varchar(11) DEFAULT NULL,
  `unique_id` varchar(20) DEFAULT NULL,
  `dt` datetime DEFAULT NULL,
  `activity_type` varchar(200) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `dtmf` varchar(10) DEFAULT NULL,
  `context` varchar(200) DEFAULT NULL,
  `sub_dt` datetime DEFAULT NULL,
  `state` varchar(25) DEFAULT NULL,
  `district` varchar(20) DEFAULT NULL,
  `tehsil` varchar(30) DEFAULT NULL,
  `lat` decimal(9,6) DEFAULT NULL,
  `lng` decimal(9,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `agi_scripts`
--

CREATE TABLE `agi_scripts` (
  `agi_file_name` text NOT NULL,
  `agi_url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `api_package_details`
--

CREATE TABLE `api_package_details` (
  `id` int(11) NOT NULL,
  `cellno` varchar(11) DEFAULT NULL,
  `request` varchar(500) DEFAULT NULL,
  `request_time` datetime DEFAULT NULL,
  `response` varchar(500) DEFAULT NULL,
  `response_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `api_package_subscribers`
--

CREATE TABLE `api_package_subscribers` (
  `cellno` varchar(11) NOT NULL,
  `offer_id` varchar(500) DEFAULT NULL,
  `package_exp_dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `black_list`
--

CREATE TABLE `black_list` (
  `id` int(11) NOT NULL,
  `cellno` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `charged_cellnos`
--

CREATE TABLE `charged_cellnos` (
  `cellno` varchar(11) NOT NULL,
  `charge_count` int(11) DEFAULT 0,
  `status` int(11) DEFAULT 0,
  `dt` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `charged_cellnos_bak`
--

CREATE TABLE `charged_cellnos_bak` (
  `cellno` varchar(11) CHARACTER SET latin1 NOT NULL,
  `charge_count` int(11) DEFAULT 0,
  `status` int(11) DEFAULT 0,
  `dt` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `charge_01`
--

CREATE TABLE `charge_01` (
  `id` int(11) NOT NULL,
  `cellno` varchar(20) DEFAULT NULL,
  `amount` decimal(10,4) DEFAULT NULL,
  `stat` tinyint(1) DEFAULT NULL,
  `charge_type` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `retry_count` int(11) DEFAULT 0,
  `sub_type` tinyint(1) DEFAULT NULL,
  `ref_id` varchar(20) DEFAULT NULL,
  `error_code` varchar(100) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `service_id` int(11) DEFAULT 0,
  `processed` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `charge_02`
--

CREATE TABLE `charge_02` (
  `id` int(11) NOT NULL,
  `cellno` varchar(20) DEFAULT NULL,
  `amount` decimal(10,4) DEFAULT NULL,
  `stat` tinyint(1) DEFAULT NULL,
  `charge_type` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `retry_count` int(11) DEFAULT 0,
  `sub_type` tinyint(1) DEFAULT NULL,
  `ref_id` varchar(20) DEFAULT NULL,
  `error_code` varchar(100) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `service_id` int(11) DEFAULT 0,
  `processed` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `charge_03`
--

CREATE TABLE `charge_03` (
  `id` int(11) NOT NULL,
  `cellno` varchar(20) DEFAULT NULL,
  `amount` decimal(10,4) DEFAULT NULL,
  `stat` tinyint(1) DEFAULT NULL,
  `charge_type` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `retry_count` int(11) DEFAULT 0,
  `sub_type` tinyint(1) DEFAULT NULL,
  `ref_id` varchar(20) DEFAULT NULL,
  `error_code` varchar(100) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `service_id` int(11) DEFAULT 0,
  `processed` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `charge_04`
--

CREATE TABLE `charge_04` (
  `id` int(11) NOT NULL,
  `cellno` varchar(20) DEFAULT NULL,
  `amount` decimal(10,4) DEFAULT NULL,
  `stat` tinyint(1) DEFAULT NULL,
  `charge_type` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `retry_count` int(11) DEFAULT 0,
  `sub_type` tinyint(1) DEFAULT NULL,
  `ref_id` varchar(20) DEFAULT NULL,
  `error_code` varchar(100) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `service_id` int(11) DEFAULT 0,
  `processed` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `charge_05`
--

CREATE TABLE `charge_05` (
  `id` int(11) NOT NULL,
  `cellno` varchar(20) DEFAULT NULL,
  `amount` decimal(10,4) DEFAULT NULL,
  `stat` tinyint(1) DEFAULT NULL,
  `charge_type` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `retry_count` int(11) DEFAULT 0,
  `sub_type` tinyint(1) DEFAULT NULL,
  `ref_id` varchar(20) DEFAULT NULL,
  `error_code` varchar(100) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `service_id` int(11) DEFAULT 0,
  `processed` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `charge_06`
--

CREATE TABLE `charge_06` (
  `id` int(11) NOT NULL,
  `cellno` varchar(20) DEFAULT NULL,
  `amount` decimal(10,4) DEFAULT NULL,
  `stat` tinyint(1) DEFAULT NULL,
  `charge_type` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `retry_count` int(11) DEFAULT 0,
  `sub_type` tinyint(1) DEFAULT NULL,
  `ref_id` varchar(20) DEFAULT NULL,
  `error_code` varchar(100) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `service_id` int(11) DEFAULT 0,
  `processed` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `charge_07`
--

CREATE TABLE `charge_07` (
  `id` int(11) NOT NULL,
  `cellno` varchar(20) DEFAULT NULL,
  `amount` decimal(10,4) DEFAULT NULL,
  `stat` tinyint(1) DEFAULT NULL,
  `charge_type` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `retry_count` int(11) DEFAULT 0,
  `sub_type` tinyint(1) DEFAULT NULL,
  `ref_id` varchar(20) DEFAULT NULL,
  `error_code` varchar(100) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `service_id` int(11) DEFAULT 0,
  `processed` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `charge_08`
--

CREATE TABLE `charge_08` (
  `id` int(11) NOT NULL,
  `cellno` varchar(20) DEFAULT NULL,
  `amount` decimal(10,4) DEFAULT NULL,
  `stat` tinyint(1) DEFAULT NULL,
  `charge_type` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `retry_count` int(11) DEFAULT 0,
  `sub_type` tinyint(1) DEFAULT NULL,
  `ref_id` varchar(20) DEFAULT NULL,
  `error_code` varchar(100) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `service_id` int(11) DEFAULT 0,
  `processed` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `charge_09`
--

CREATE TABLE `charge_09` (
  `id` int(11) NOT NULL,
  `cellno` varchar(20) DEFAULT NULL,
  `amount` decimal(10,4) DEFAULT NULL,
  `stat` tinyint(1) DEFAULT NULL,
  `charge_type` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `retry_count` int(11) DEFAULT 0,
  `sub_type` tinyint(1) DEFAULT NULL,
  `ref_id` varchar(20) DEFAULT NULL,
  `error_code` varchar(100) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `service_id` int(11) DEFAULT 0,
  `processed` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `charge_10`
--

CREATE TABLE `charge_10` (
  `id` int(11) NOT NULL,
  `cellno` varchar(20) DEFAULT NULL,
  `amount` decimal(10,4) DEFAULT NULL,
  `stat` tinyint(1) DEFAULT NULL,
  `charge_type` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `retry_count` int(11) DEFAULT 0,
  `sub_type` tinyint(1) DEFAULT NULL,
  `ref_id` varchar(20) DEFAULT NULL,
  `error_code` varchar(100) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `service_id` int(11) DEFAULT 0,
  `processed` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `charge_11`
--

CREATE TABLE `charge_11` (
  `id` int(11) NOT NULL,
  `cellno` varchar(20) DEFAULT NULL,
  `amount` decimal(10,4) DEFAULT NULL,
  `stat` tinyint(1) DEFAULT NULL,
  `charge_type` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `retry_count` int(11) DEFAULT 0,
  `sub_type` tinyint(1) DEFAULT NULL,
  `ref_id` varchar(20) DEFAULT NULL,
  `error_code` varchar(100) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `service_id` int(11) DEFAULT 0,
  `processed` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `charge_12`
--

CREATE TABLE `charge_12` (
  `id` int(11) NOT NULL,
  `cellno` varchar(20) DEFAULT NULL,
  `amount` decimal(10,4) DEFAULT NULL,
  `stat` tinyint(1) DEFAULT NULL,
  `charge_type` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `retry_count` int(11) DEFAULT 0,
  `sub_type` tinyint(1) DEFAULT NULL,
  `ref_id` varchar(20) DEFAULT NULL,
  `error_code` varchar(100) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `service_id` int(11) DEFAULT 0,
  `processed` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `charge_attempts`
--

CREATE TABLE `charge_attempts` (
  `id` int(11) NOT NULL,
  `cellno` varchar(11) DEFAULT NULL,
  `cur_dt` datetime DEFAULT NULL,
  `request_dt` datetime DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `api_url` varchar(2000) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `sub_mode` varchar(45) DEFAULT NULL,
  `charge_amount` decimal(10,2) DEFAULT NULL,
  `response_dt` datetime DEFAULT NULL,
  `response_code` int(11) DEFAULT NULL,
  `response_msg` varchar(2000) DEFAULT NULL,
  `attempt_no` int(11) DEFAULT NULL,
  `correlation_id` varchar(45) DEFAULT NULL,
  `transaction_id` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `charge_mem`
--

CREATE TABLE `charge_mem` (
  `id` int(11) NOT NULL,
  `cellno` varchar(20) DEFAULT NULL,
  `amount` varchar(20) DEFAULT NULL,
  `stat` tinyint(1) DEFAULT NULL COMMENT '0-pending 1-processed 2-success 3-failed_insuff_bal',
  `created` datetime DEFAULT NULL,
  `error_code` varchar(100) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MEMORY DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `charge_process`
--

CREATE TABLE `charge_process` (
  `id` int(11) NOT NULL,
  `cellno` varchar(20) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `stat` tinyint(1) DEFAULT NULL COMMENT '0-pending 1-processed 2-success 3-failed_insuff_bal',
  `charge_type` tinyint(1) DEFAULT NULL COMMENT '0-new_sub 1-sub_renewal 2-svc_chg',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `retry_count` int(11) DEFAULT 0,
  `sub_type` tinyint(1) DEFAULT NULL,
  `ref_id` varchar(20) DEFAULT NULL,
  `error_code` varchar(100) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `processed` int(11) DEFAULT 0,
  `charge_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `daily_charge_attempts`
--

CREATE TABLE `daily_charge_attempts` (
  `id` int(11) NOT NULL,
  `cell_no` varchar(11) NOT NULL,
  `cur_dt` date NOT NULL,
  `request_dt` datetime DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `api_url` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `charge_amount` decimal(10,2) DEFAULT NULL,
  `response_dt` datetime DEFAULT NULL,
  `response_code` int(11) DEFAULT NULL,
  `response_msg` text DEFAULT NULL,
  `attempt_no` int(11) DEFAULT NULL,
  `execute_dt` datetime DEFAULT NULL,
  `correlation_id` varchar(45) DEFAULT NULL,
  `transaction_id` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `daily_charge_attempts_mem`
--

CREATE TABLE `daily_charge_attempts_mem` (
  `id` int(11) NOT NULL,
  `cell_no` varchar(11) NOT NULL,
  `cur_dt` date NOT NULL,
  `request_dt` datetime DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `api_url` varchar(2000) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `charge_amount` decimal(10,2) DEFAULT NULL,
  `response_dt` datetime DEFAULT NULL,
  `response_code` int(11) DEFAULT NULL,
  `response_msg` varchar(200) DEFAULT NULL,
  `attempt_no` int(11) DEFAULT NULL,
  `execute_dt` datetime DEFAULT NULL,
  `correlation_id` varchar(45) DEFAULT NULL,
  `transaction_id` varchar(45) DEFAULT NULL
) ENGINE=MEMORY DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `incoming_calls`
--

CREATE TABLE `incoming_calls` (
  `id` int(11) NOT NULL,
  `cellno` varchar(11) DEFAULT NULL,
  `unique_id` varchar(20) DEFAULT NULL,
  `start_dt` datetime DEFAULT NULL,
  `end_dt` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kd_access_token`
--

CREATE TABLE `kd_access_token` (
  `id` int(11) NOT NULL,
  `access_token` varchar(500) DEFAULT NULL,
  `expires_in` varchar(45) DEFAULT NULL,
  `last_updated` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kr_sub`
--

CREATE TABLE `kr_sub` (
  `cellno` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `list_0`
--

CREATE TABLE `list_0` (
  `id` int(11) NOT NULL,
  `upload_id` int(11) DEFAULT NULL,
  `cellno` varchar(15) DEFAULT NULL,
  `dt` datetime DEFAULT NULL,
  `status` int(100) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `login_details`
--

CREATE TABLE `login_details` (
  `user_id` int(11) NOT NULL,
  `login_dt` datetime NOT NULL,
  `logout_dt` datetime DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu_box`
--

CREATE TABLE `menu_box` (
  `id` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `menu_type` int(11) DEFAULT NULL,
  `max_seg` int(11) DEFAULT NULL,
  `box_order` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu_segment`
--

CREATE TABLE `menu_segment` (
  `id` int(11) NOT NULL,
  `title` varchar(30) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `seg_type` int(11) DEFAULT NULL,
  `seg_sql` text DEFAULT NULL,
  `seg_file` varchar(255) DEFAULT NULL,
  `seg_order` int(11) DEFAULT NULL,
  `seg_file_1` varchar(255) DEFAULT NULL,
  `seg_file_2` varchar(255) DEFAULT NULL,
  `seg_file_3` varchar(255) DEFAULT NULL,
  `seg_file_4` varchar(255) DEFAULT NULL,
  `seg_file_5` varchar(255) DEFAULT NULL,
  `seg_file_6` varchar(255) DEFAULT NULL,
  `seg_file_7` varchar(255) DEFAULT NULL,
  `seg_file_8` varchar(255) DEFAULT NULL,
  `seg_file_9` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 100,
  `seg_data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu_segment_validity`
--

CREATE TABLE `menu_segment_validity` (
  `id` int(11) NOT NULL,
  `seg_id` int(11) DEFAULT NULL,
  `validity_sql` text DEFAULT NULL,
  `validity_sql_order` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `msisdn`
--

CREATE TABLE `msisdn` (
  `id` int(11) NOT NULL,
  `cell_no` varchar(11) CHARACTER SET latin1 NOT NULL,
  `state` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `new_sub_charge_responses`
--

CREATE TABLE `new_sub_charge_responses` (
  `id` int(11) NOT NULL,
  `cellno` varchar(45) DEFAULT NULL,
  `charge_attempt_dt` datetime DEFAULT NULL,
  `response_code` int(11) DEFAULT NULL,
  `response` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `response_codes_def`
--

CREATE TABLE `response_codes_def` (
  `id` int(11) NOT NULL,
  `response_code` varchar(45) DEFAULT NULL,
  `response_msg` text DEFAULT NULL,
  `desc` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `send_sms`
--

CREATE TABLE `send_sms` (
  `id` int(11) NOT NULL,
  `dt` datetime DEFAULT NULL,
  `msg_data` varchar(45) DEFAULT NULL,
  `receiver` varchar(45) DEFAULT NULL,
  `send_dt` datetime DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `send_sms_logs`
--

CREATE TABLE `send_sms_logs` (
  `id` int(11) NOT NULL,
  `dt` datetime DEFAULT NULL,
  `cellno` varchar(11) DEFAULT NULL,
  `sender` varchar(45) DEFAULT NULL,
  `msg_data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `srvcname` varchar(50) NOT NULL,
  `shortcode` varchar(10) NOT NULL,
  `amount` varchar(20) DEFAULT NULL,
  `insurance_amount` varchar(20) DEFAULT NULL,
  `charge_interval` int(11) DEFAULT NULL,
  `max_chargings_per_day` int(11) DEFAULT NULL,
  `max_attempts_per_day` int(11) DEFAULT NULL,
  `through_put` int(11) DEFAULT NULL,
  `op_name` varchar(50) DEFAULT NULL,
  `ucip_transaction_type` varchar(30) DEFAULT NULL,
  `ucip_transaction_code` varchar(30) DEFAULT NULL,
  `ucip_host_name` varchar(30) DEFAULT NULL,
  `ucip_node_type` varchar(30) DEFAULT NULL,
  `ucip_ip` varchar(45) DEFAULT NULL,
  `ucip_port` varchar(45) DEFAULT NULL,
  `ucip_path` varchar(45) DEFAULT NULL,
  `ucip_protocol_version` varchar(45) DEFAULT NULL,
  `ucip_connect_timeout` varchar(45) DEFAULT NULL,
  `ucip_wait_time_out` varchar(45) DEFAULT NULL,
  `ucip_operator_id` varchar(45) DEFAULT NULL,
  `ucip_ext_data_1` varchar(45) DEFAULT NULL,
  `ucip_ext_data_2` varchar(45) DEFAULT NULL,
  `ucip_client_version` varchar(45) DEFAULT NULL,
  `msg_resp_enable` int(11) DEFAULT NULL,
  `msg_resp_interval` int(11) DEFAULT NULL,
  `msg_resp_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `service_sms`
--

CREATE TABLE `service_sms` (
  `key_word` varchar(50) NOT NULL,
  `sms_text` text DEFAULT NULL,
  `eng_sms_text` text CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `service_type`
--

CREATE TABLE `service_type` (
  `id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `charge_cycle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sm_charge_attempts`
--

CREATE TABLE `sm_charge_attempts` (
  `id` int(11) NOT NULL,
  `ca_id` int(11) DEFAULT NULL,
  `cellno` varchar(11) NOT NULL,
  `request_dt` datetime DEFAULT NULL,
  `cur_dt` datetime NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `api_url` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `sub_mode` varchar(45) DEFAULT NULL,
  `charge_amount` decimal(10,2) DEFAULT NULL,
  `response_dt` datetime DEFAULT NULL,
  `response_code` int(11) DEFAULT NULL,
  `response_msg` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscriber`
--

CREATE TABLE `subscriber` (
  `cellno` varchar(11) NOT NULL,
  `sub_dt` datetime DEFAULT NULL,
  `unsub_dt` datetime DEFAULT NULL,
  `sub_mode` varchar(10) DEFAULT NULL,
  `unsub_mode` varchar(10) DEFAULT NULL,
  `charge_attempt_dt` datetime DEFAULT NULL,
  `last_charge_dt` datetime DEFAULT NULL,
  `next_charge_dt` datetime DEFAULT NULL,
  `grace_expire_dt` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `op` varchar(45) DEFAULT NULL,
  `service_id` varchar(45) DEFAULT '1',
  `lcr_status` int(11) DEFAULT 20,
  `last_call_dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscriber_mem`
--

CREATE TABLE `subscriber_mem` (
  `id` int(11) NOT NULL,
  `cellno` varchar(12) NOT NULL COMMENT 'subscriber',
  `next_charge_dt` date DEFAULT NULL COMMENT 'Date when last_success_charge or total_days_pending field was updated',
  `last_charge_dt` datetime DEFAULT NULL,
  `service_id` varchar(10) DEFAULT NULL,
  `charge_attempt_dt` datetime DEFAULT NULL,
  `grace_expire_dt` datetime DEFAULT NULL
) ENGINE=MEMORY DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscriber_sm`
--

CREATE TABLE `subscriber_sm` (
  `cellno` varchar(11) DEFAULT NULL,
  `sub_dt` datetime DEFAULT NULL,
  `unsub_dt` datetime DEFAULT NULL,
  `sub_mode` varchar(10) DEFAULT NULL,
  `unsub_mode` varchar(10) DEFAULT NULL,
  `charge_attempt_dt` datetime DEFAULT NULL,
  `last_charge_dt` datetime DEFAULT NULL,
  `next_charge_dt` datetime DEFAULT NULL,
  `grace_expire_dt` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `op` varchar(45) DEFAULT NULL,
  `service_id` varchar(45) DEFAULT '1',
  `lcr_status` int(11) DEFAULT 20,
  `last_call_dt` datetime DEFAULT NULL,
  `dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscriber_ss`
--

CREATE TABLE `subscriber_ss` (
  `cellno` varchar(11) NOT NULL,
  `last_sub_dt` datetime DEFAULT NULL,
  `last_unsub_dt` datetime DEFAULT NULL,
  `sub_mode` varchar(10) DEFAULT NULL,
  `unsub_mode` varchar(10) DEFAULT NULL,
  `charge_attempt_dt` datetime DEFAULT NULL,
  `last_charge_dt` datetime DEFAULT NULL,
  `next_charge_dt` datetime DEFAULT NULL,
  `grace_expire_dt` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `op` varchar(45) DEFAULT NULL,
  `service_id` varchar(45) DEFAULT '1',
  `lcr_status` int(11) DEFAULT 20,
  `last_call_dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscriber_status`
--

CREATE TABLE `subscriber_status` (
  `id` int(11) NOT NULL,
  `status_name` varchar(255) NOT NULL,
  `status_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subscriber_unsub`
--

CREATE TABLE `subscriber_unsub` (
  `cellno` varchar(11) NOT NULL,
  `sub_dt` datetime DEFAULT NULL,
  `unsub_dt` datetime DEFAULT NULL,
  `sub_mode` varchar(10) DEFAULT NULL,
  `unsub_mode` varchar(10) DEFAULT NULL,
  `charge_attempt_dt` datetime DEFAULT NULL,
  `last_charge_dt` datetime DEFAULT NULL,
  `next_charge_dt` datetime DEFAULT NULL,
  `grace_expire_dt` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `op` varchar(45) DEFAULT NULL,
  `service_id` varchar(45) DEFAULT '1',
  `last_call_dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscriber_unsub_history`
--

CREATE TABLE `subscriber_unsub_history` (
  `id` int(11) NOT NULL,
  `cellno` varchar(11) DEFAULT NULL,
  `sub_dt` datetime DEFAULT NULL,
  `unsub_dt` datetime DEFAULT NULL,
  `sub_mode` varchar(10) DEFAULT NULL,
  `unsub_mode` varchar(10) DEFAULT NULL,
  `charge_attempt_dt` datetime DEFAULT NULL,
  `last_charge_dt` datetime DEFAULT NULL,
  `next_charge_dt` datetime DEFAULT NULL,
  `grace_expire_dt` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `op` varchar(45) DEFAULT NULL,
  `service_id` varchar(45) DEFAULT '1',
  `last_call_dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscriber_unsub_ss`
--

CREATE TABLE `subscriber_unsub_ss` (
  `cellno` varchar(11) NOT NULL,
  `last_sub_dt` datetime DEFAULT NULL,
  `last_unsub_dt` datetime DEFAULT NULL,
  `sub_mode` varchar(10) DEFAULT NULL,
  `unsub_mode` varchar(10) DEFAULT NULL,
  `charge_attempt_dt` datetime DEFAULT NULL,
  `last_charge_dt` datetime DEFAULT NULL,
  `next_charge_dt` datetime DEFAULT NULL,
  `grace_expire_dt` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `op` varchar(45) DEFAULT NULL,
  `service_id` varchar(45) DEFAULT '1',
  `last_call_dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `success_charge_detail`
--

CREATE TABLE `success_charge_detail` (
  `cellno` varchar(20) NOT NULL,
  `service_id` int(11) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `charge_type` tinyint(1) DEFAULT NULL COMMENT '0-new_sub 1-sub_renewal 2-svc_chg',
  `created` datetime DEFAULT NULL,
  `charged_dt` datetime DEFAULT NULL,
  `sub_type` varchar(20) DEFAULT NULL,
  `response_code` varchar(100) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `processed` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `role_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_super_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `role_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_super_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `user_id` varchar(1024) NOT NULL,
  `dt` date NOT NULL,
  `address` varchar(1024) NOT NULL,
  `activity_code` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_activity_type` (`activity_type`),
  ADD KEY `dt` (`dt`),
  ADD KEY `sub_dt` (`sub_dt`),
  ADD KEY `state` (`state`);

--
-- Indexes for table `black_list`
--
ALTER TABLE `black_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `charged_cellnos`
--
ALTER TABLE `charged_cellnos`
  ADD PRIMARY KEY (`cellno`);

--
-- Indexes for table `charge_01`
--
ALTER TABLE `charge_01`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_cellno` (`cellno`);

--
-- Indexes for table `charge_02`
--
ALTER TABLE `charge_02`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_cellno` (`cellno`);

--
-- Indexes for table `charge_03`
--
ALTER TABLE `charge_03`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_cellno` (`cellno`);

--
-- Indexes for table `charge_04`
--
ALTER TABLE `charge_04`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_cellno` (`cellno`);

--
-- Indexes for table `charge_05`
--
ALTER TABLE `charge_05`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `charge_06`
--
ALTER TABLE `charge_06`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `charge_07`
--
ALTER TABLE `charge_07`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `charge_08`
--
ALTER TABLE `charge_08`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `charge_09`
--
ALTER TABLE `charge_09`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `charge_10`
--
ALTER TABLE `charge_10`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `charge_11`
--
ALTER TABLE `charge_11`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `charge_12`
--
ALTER TABLE `charge_12`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_cellno` (`cellno`);

--
-- Indexes for table `charge_attempts`
--
ALTER TABLE `charge_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `indx_cellno` (`cellno`),
  ADD KEY `indx_status` (`status`),
  ADD KEY `indx_service_id` (`service_id`);

--
-- Indexes for table `charge_mem`
--
ALTER TABLE `charge_mem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cellno` (`cellno`);

--
-- Indexes for table `charge_process`
--
ALTER TABLE `charge_process`
  ADD PRIMARY KEY (`id`),
  ADD KEY `indx_processed` (`processed`),
  ADD KEY `indx_cellno` (`cellno`),
  ADD KEY `indx_stat` (`stat`);

--
-- Indexes for table `daily_charge_attempts`
--
ALTER TABLE `daily_charge_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `indx_cell_no` (`cell_no`),
  ADD KEY `indx_response_code` (`response_code`),
  ADD KEY `indx_3` (`cell_no`),
  ADD KEY `indx_2` (`response_code`);

--
-- Indexes for table `daily_charge_attempts_mem`
--
ALTER TABLE `daily_charge_attempts_mem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incoming_calls`
--
ALTER TABLE `incoming_calls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cellno` (`cellno`);

--
-- Indexes for table `kd_access_token`
--
ALTER TABLE `kd_access_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_0`
--
ALTER TABLE `list_0`
  ADD KEY `id` (`id`);

--
-- Indexes for table `menu_box`
--
ALTER TABLE `menu_box`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_segment`
--
ALTER TABLE `menu_segment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `new_sub_charge_responses`
--
ALTER TABLE `new_sub_charge_responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `response_codes_def`
--
ALTER TABLE `response_codes_def`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `send_sms`
--
ALTER TABLE `send_sms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `send_sms_logs`
--
ALTER TABLE `send_sms_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_sms`
--
ALTER TABLE `service_sms`
  ADD PRIMARY KEY (`key_word`);

--
-- Indexes for table `sm_charge_attempts`
--
ALTER TABLE `sm_charge_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriber`
--
ALTER TABLE `subscriber`
  ADD PRIMARY KEY (`cellno`),
  ADD KEY `cellno` (`cellno`) USING BTREE;

--
-- Indexes for table `subscriber_mem`
--
ALTER TABLE `subscriber_mem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `renewel_date_index` (`next_charge_dt`),
  ADD KEY `sub_cellno` (`cellno`),
  ADD KEY `sub_updated` (`last_charge_dt`);

--
-- Indexes for table `subscriber_ss`
--
ALTER TABLE `subscriber_ss`
  ADD PRIMARY KEY (`cellno`),
  ADD KEY `cellno` (`cellno`);

--
-- Indexes for table `subscriber_unsub`
--
ALTER TABLE `subscriber_unsub`
  ADD PRIMARY KEY (`cellno`);

--
-- Indexes for table `subscriber_unsub_history`
--
ALTER TABLE `subscriber_unsub_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriber_unsub_ss`
--
ALTER TABLE `subscriber_unsub_ss`
  ADD PRIMARY KEY (`cellno`);

--
-- Indexes for table `success_charge_detail`
--
ALTER TABLE `success_charge_detail`
  ADD PRIMARY KEY (`cellno`,`service_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `black_list`
--
ALTER TABLE `black_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `charge_01`
--
ALTER TABLE `charge_01`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `charge_02`
--
ALTER TABLE `charge_02`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `charge_03`
--
ALTER TABLE `charge_03`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `charge_04`
--
ALTER TABLE `charge_04`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `charge_05`
--
ALTER TABLE `charge_05`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `charge_06`
--
ALTER TABLE `charge_06`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `charge_07`
--
ALTER TABLE `charge_07`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `charge_08`
--
ALTER TABLE `charge_08`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `charge_09`
--
ALTER TABLE `charge_09`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `charge_10`
--
ALTER TABLE `charge_10`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `charge_11`
--
ALTER TABLE `charge_11`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `charge_12`
--
ALTER TABLE `charge_12`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `charge_attempts`
--
ALTER TABLE `charge_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `charge_mem`
--
ALTER TABLE `charge_mem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `charge_process`
--
ALTER TABLE `charge_process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_charge_attempts`
--
ALTER TABLE `daily_charge_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_charge_attempts_mem`
--
ALTER TABLE `daily_charge_attempts_mem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incoming_calls`
--
ALTER TABLE `incoming_calls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kd_access_token`
--
ALTER TABLE `kd_access_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `list_0`
--
ALTER TABLE `list_0`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_box`
--
ALTER TABLE `menu_box`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_segment`
--
ALTER TABLE `menu_segment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `new_sub_charge_responses`
--
ALTER TABLE `new_sub_charge_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `response_codes_def`
--
ALTER TABLE `response_codes_def`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `send_sms`
--
ALTER TABLE `send_sms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `send_sms_logs`
--
ALTER TABLE `send_sms_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sm_charge_attempts`
--
ALTER TABLE `sm_charge_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
