-- MySQL dump 10.13  Distrib 5.6.28, for Linux (x86_64)
--
-- Host: localhost    Database: uos
-- ------------------------------------------------------
-- Server version	5.6.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `name_kana` varchar(50) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `mail` text NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  `status` tinyint(4) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `download_his`
--

DROP TABLE IF EXISTS `download_his`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `download_his` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `download_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `param` text,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `emcall`
--

DROP TABLE IF EXISTS `emcall`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emcall` (
  `emcall_id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `relationship` tinyint(4) NOT NULL,
  `name` varchar(20) NOT NULL,
  `name_kana` varchar(20) NOT NULL,
  `tel` varchar(14) DEFAULT NULL,
  `zipcode` varchar(7) DEFAULT NULL,
  `add1` tinyint(4) DEFAULT NULL,
  `add2` varchar(20) DEFAULT NULL,
  `add3` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`emcall_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `employment`
--

DROP TABLE IF EXISTS `employment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employment` (
  `person_id` int(11) NOT NULL,
  `contact_result` tinyint(4) DEFAULT NULL,
  `review_date` date DEFAULT NULL,
  `review_result` tinyint(4) DEFAULT NULL,
  `adoption_result` tinyint(4) DEFAULT NULL,
  `rank` tinyint(4) DEFAULT NULL,
  `register_date` date DEFAULT NULL,
  `registration_expiration` date NOT NULL,
  `contract_date` date DEFAULT NULL,
  `contract_result` tinyint(4) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `work_confirmation` tinyint(4) DEFAULT NULL,
  `employee_code` varchar(10) DEFAULT NULL,
  `code_registration_date` date DEFAULT NULL,
  `classification` tinyint(4) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `obic7_flag` tinyint(4) NOT NULL DEFAULT '0',
  `obic7_date` date DEFAULT NULL,
  PRIMARY KEY (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `interviewusami`
--

DROP TABLE IF EXISTS `interviewusami`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `interviewusami` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interview_day` date DEFAULT NULL,
  `parental_authority` tinyint(4) DEFAULT NULL,
  `commuting_means` varchar(20) DEFAULT NULL,
  `commuting_means_bus` int(11) DEFAULT NULL,
  `commuting_means_train` int(11) DEFAULT NULL,
  `ss_match` varchar(20) DEFAULT NULL,
  `ss_match_other` varchar(50) DEFAULT NULL,
  `work_location_hope1` varchar(30) DEFAULT NULL,
  `work_location_hope1_time` int(11) DEFAULT NULL,
  `work_location_hope2` varchar(30) DEFAULT NULL,
  `work_location_hope2_time` int(11) DEFAULT NULL,
  `work_location_remarks` text,
  `working_arrangements_shift_free` tinyint(1) DEFAULT NULL,
  `working_arrangements1` tinyint(1) DEFAULT NULL,
  `working_arrangements1_start_time` varchar(5) DEFAULT NULL,
  `working_arrangements1_end_time` varchar(5) DEFAULT NULL,
  `working_arrangements2` tinyint(4) DEFAULT NULL,
  `working_arrangements2_start_time` varchar(5) DEFAULT NULL,
  `working_arrangements2_end_time` varchar(5) DEFAULT NULL,
  `working_arrangements3` tinyint(4) DEFAULT NULL,
  `working_arrangements3_start_time` varchar(5) DEFAULT NULL,
  `working_arrangements3_end_time` varchar(5) DEFAULT NULL,
  `working_arrangements4` tinyint(4) DEFAULT NULL,
  `working_arrangements4_start_time` varchar(5) DEFAULT NULL,
  `working_arrangements4_end_time` varchar(5) DEFAULT NULL,
  `working_arrangements5` tinyint(4) DEFAULT NULL,
  `working_arrangements5_start_time` varchar(5) DEFAULT NULL,
  `working_arrangements5_end_time` varchar(5) DEFAULT NULL,
  `working_arrangements6` tinyint(4) DEFAULT NULL,
  `working_arrangements6_start_time` varchar(5) DEFAULT NULL,
  `working_arrangements6_end_time` varchar(5) DEFAULT NULL,
  `working_arrangements7` tinyint(4) DEFAULT NULL,
  `working_arrangements7_start_time` varchar(5) DEFAULT NULL,
  `working_arrangements7_end_time` varchar(5) DEFAULT NULL,
  `working_arrangements2_check` tinyint(1) DEFAULT NULL,
  `working_arrangements3_check` tinyint(1) DEFAULT NULL,
  `working_arrangements4_check` tinyint(1) DEFAULT NULL,
  `working_arrangements5_check` tinyint(1) DEFAULT NULL,
  `working_arrangements6_check` tinyint(1) DEFAULT NULL,
  `working_arrangements7_check` tinyint(1) DEFAULT NULL,
  `working_arrangements1_check` tinyint(1) DEFAULT NULL,
  `commute_dis` float DEFAULT '0',
  `work_day_week_min` tinyint(4) DEFAULT NULL,
  `work_day_week_max` tinyint(4) DEFAULT NULL,
  `work_day_month_min` int(11) DEFAULT NULL,
  `work_day_month_max` int(11) DEFAULT NULL,
  `work_holiday` int(11) DEFAULT NULL,
  `month_wage` int(11) DEFAULT NULL,
  `month_wage_other` text,
  `time_of_service` tinyint(4) DEFAULT NULL,
  `employment_month` tinyint(4) DEFAULT NULL,
  `employment_day` tinyint(4) DEFAULT NULL,
  `employment_possible` tinyint(4) DEFAULT NULL,
  `media_app` tinyint(4) DEFAULT NULL,
  `media_app_other` varchar(30) DEFAULT NULL,
  `experience` tinyint(4) DEFAULT NULL,
  `experience_year_position_before` varchar(11) DEFAULT NULL,
  `experience_year` varchar(11) DEFAULT NULL,
  `experience_month` varchar(11) DEFAULT NULL,
  `experience_other` varchar(50) DEFAULT NULL,
  `driver_license` varchar(50) DEFAULT NULL,
  `qualification` varchar(50) DEFAULT NULL,
  `qualification_b` tinyint(4) DEFAULT NULL,
  `qualification_mechanic` varchar(20) DEFAULT NULL,
  `pc_skills` varchar(50) DEFAULT NULL,
  `pc_skin_other` varchar(30) DEFAULT NULL,
  `occupation` tinyint(4) DEFAULT NULL,
  `occupation_company_name` varchar(50) DEFAULT NULL,
  `occupation_student_year` int(11) DEFAULT NULL,
  `occupation_student_grade` int(11) DEFAULT NULL,
  `health_status` tinyint(4) DEFAULT NULL,
  `anamnesis` tinyint(4) DEFAULT NULL,
  `disease_name` varchar(50) DEFAULT NULL,
  `insurance_employment` tinyint(4) DEFAULT NULL,
  `insurance_social` tinyint(4) DEFAULT NULL,
  `partner` tinyint(4) DEFAULT NULL,
  `partner_dependents_person` int(11) DEFAULT NULL,
  `uniform_rental_h` int(11) DEFAULT NULL,
  `uniform_rental_shoe_size` float DEFAULT NULL,
  `uniform_rental_up` varchar(5) DEFAULT NULL,
  `uniform_rental_under` varchar(5) DEFAULT NULL,
  `salary_hour_wage` int(11) DEFAULT NULL,
  `salary_role_wage` int(11) DEFAULT NULL,
  `salary_evaluation_wage` int(11) DEFAULT NULL,
  `salary_special_wage` int(11) DEFAULT NULL,
  `adoption_rank` tinyint(4) DEFAULT NULL,
  `adoption_person_des` text,
  `adoption_person_type` tinyint(4) DEFAULT NULL,
  `uos_person` varchar(100) DEFAULT NULL,
  `confirmation_shop_name` varchar(20) DEFAULT NULL,
  `confirmation_shop_date` date DEFAULT NULL,
  `location_ss` varchar(50) DEFAULT NULL,
  `work_starttime` datetime DEFAULT NULL,
  `part_type` tinyint(4) DEFAULT NULL,
  `income_tax` tinyint(4) DEFAULT NULL,
  `withholding` tinyint(4) DEFAULT '0',
  `withholding_slip` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  `qualification_mechanic_date6` date DEFAULT NULL,
  `qualification_mechanic_date5` date DEFAULT NULL,
  `qualification_mechanic_date4` date DEFAULT NULL,
  `qualification_mechanic_date3` date DEFAULT NULL,
  `qualification_mechanic_date2` date DEFAULT NULL,
  `qualification_mechanic_date1` date DEFAULT NULL,
  `qualification_date4` date DEFAULT NULL,
  `qualification_date3` date DEFAULT NULL,
  `qualification_date2` date DEFAULT NULL,
  `qualification_date1` date DEFAULT NULL,
  `driver_license_date7` date DEFAULT NULL,
  `driver_license_date6` date DEFAULT NULL,
  `driver_license_date5` date DEFAULT NULL,
  `driver_license_date4` date DEFAULT NULL,
  `driver_license_date3` date DEFAULT NULL,
  `driver_license_date2` date DEFAULT NULL,
  `driver_license_date1` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `job`
--

DROP TABLE IF EXISTS `job`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job` (
  `job_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `image_list` text,
  `media_list` text,
  `edit_data` longtext,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  `is_conscription` tinyint(4) DEFAULT NULL,
  `is_pickup` tinyint(4) DEFAULT NULL,
  `is_available` tinyint(4) DEFAULT '0',
  `public_type` tinyint(4) DEFAULT NULL,
  `url_home_page` varchar(50) DEFAULT NULL,
  `url_youtube` varchar(255) DEFAULT NULL,
  `zipcode` varchar(7) DEFAULT NULL,
  `location` varchar(64) DEFAULT NULL,
  `traffic` varchar(100) DEFAULT NULL,
  `store_name` varchar(100) DEFAULT NULL,
  `work_location_display_type` tinyint(4) NOT NULL,
  `work_location` varchar(40) NOT NULL,
  `work_location_title` varchar(20) DEFAULT NULL,
  `work_location_map` varchar(100) DEFAULT NULL,
  `employment_type` tinyint(4) DEFAULT NULL,
  `employment_mark` varchar(100) DEFAULT NULL COMMENT 'Save ,2,3,3,4,5,',
  `job_category` varchar(64) DEFAULT NULL,
  `occupation` int(11) DEFAULT NULL,
  `salary_type` tinyint(4) DEFAULT NULL,
  `salary_min` int(11) DEFAULT NULL,
  `catch_copy` varchar(90) DEFAULT NULL,
  `lead` varchar(120) DEFAULT NULL,
  `work_time_view` varchar(255) DEFAULT NULL,
  `work_day_week` tinyint(4) DEFAULT NULL,
  `work_time_des` varchar(200) DEFAULT NULL,
  `work_time_type` tinyint(4) DEFAULT NULL,
  `qualification` varchar(200) DEFAULT NULL,
  `employment_people` int(4) DEFAULT NULL,
  `employment_people_num` int(4) DEFAULT NULL,
  `employment_people_des` varchar(200) DEFAULT NULL,
  `work_period` varchar(100) DEFAULT NULL,
  `dispatch_placement_des` varchar(100) DEFAULT NULL,
  `job_description` text,
  `business_description` varchar(80) DEFAULT NULL,
  `interview_des` varchar(120) DEFAULT NULL,
  `interview_location` varchar(60) DEFAULT NULL,
  `apply_method` varchar(200) DEFAULT NULL,
  `apply_process` varchar(200) DEFAULT NULL,
  `is_apply_by_mobile` tinyint(4) DEFAULT NULL,
  `phone_name1` varchar(40) DEFAULT NULL,
  `phone_number1` varchar(14) DEFAULT NULL,
  `phone_name2` varchar(40) DEFAULT NULL,
  `phone_number2` varchar(14) DEFAULT NULL,
  `contact` varchar(120) DEFAULT NULL,
  `is_web_receipt` tinyint(4) DEFAULT NULL,
  `addr_is_view` tinyint(4) NOT NULL DEFAULT '0',
  `salary_des` varchar(72) NOT NULL,
  `post_company_name` varchar(56) NOT NULL,
  `trouble` varchar(255) DEFAULT NULL COMMENT 'Save ,1,2,3,4,',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `ss_id` int(11) unsigned NOT NULL,
  `sssale_id` int(11) unsigned NOT NULL,
  `csv` text,
  PRIMARY KEY (`job_id`),
  KEY `ss_id` (`ss_id`),
  KEY `sssale_id` (`sssale_id`),
  CONSTRAINT `job_ibfk_1` FOREIGN KEY (`ss_id`) REFERENCES `m_ss` (`ss_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `job_ibfk_2` FOREIGN KEY (`sssale_id`) REFERENCES `sssale` (`sssale_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `job_add`
--

DROP TABLE IF EXISTS `job_add`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_add` (
  `job_add_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sub_title` varchar(24) DEFAULT NULL,
  `text` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `job_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`job_add_id`),
  KEY `job_id` (`job_id`) USING BTREE,
  CONSTRAINT `job_add_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `job` (`job_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `job_recruit`
--

DROP TABLE IF EXISTS `job_recruit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_recruit` (
  `recruit_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sub_title` varchar(14) DEFAULT NULL,
  `text` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `job_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`recruit_id`),
  KEY `job_id` (`job_id`) USING BTREE,
  CONSTRAINT `job_recruit_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `job` (`job_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `m_group`
--

DROP TABLE IF EXISTS `m_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_group` (
  `m_group_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `obic7_name` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`m_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `m_image`
--

DROP TABLE IF EXISTS `m_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_image` (
  `m_image_id` varchar(64) NOT NULL,
  `content` mediumblob NOT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `mine_type` varchar(10) NOT NULL,
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL,
  PRIMARY KEY (`m_image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `m_media`
--

DROP TABLE IF EXISTS `m_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_media` (
  `m_media_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `media_name` varchar(20) NOT NULL,
  `media_version_name` varchar(20) NOT NULL,
  `classification` tinyint(4) NOT NULL,
  `budget_type` tinyint(4) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `is_web_reprint` tinyint(4) NOT NULL,
  `public_description` varchar(20) DEFAULT NULL,
  `deadline_description` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `partner_code` varchar(6) NOT NULL,
  PRIMARY KEY (`m_media_id`),
  KEY `partner_code` (`partner_code`) USING BTREE,
  CONSTRAINT `m_media_ibfk_1` FOREIGN KEY (`partner_code`) REFERENCES `m_partner` (`partner_code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `m_partner`
--

DROP TABLE IF EXISTS `m_partner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_partner` (
  `partner_code` varchar(6) NOT NULL,
  `edit_data` text,
  `type` tinyint(4) NOT NULL,
  `master_num` varchar(50) DEFAULT NULL,
  `branch_name` varchar(20) NOT NULL,
  `zipcode` varchar(7) NOT NULL,
  `addr1` tinyint(4) NOT NULL,
  `addr2` varchar(10) NOT NULL,
  `addr3` varchar(50) DEFAULT NULL,
  `tel` varchar(14) NOT NULL,
  `fax` varchar(14) DEFAULT NULL,
  `billing_department` varchar(10) DEFAULT NULL,
  `billing_tel` varchar(11) DEFAULT NULL,
  `billing_fax` varchar(11) DEFAULT NULL,
  `billing_deadline_day` int(4) DEFAULT NULL,
  `payment_day` int(4) DEFAULT NULL,
  `billing_start_date` date DEFAULT NULL,
  `bank_name` varchar(10) DEFAULT NULL,
  `bank_branch_name` varchar(10) DEFAULT NULL,
  `bank_account_number` varchar(20) DEFAULT NULL,
  `notes` varchar(500) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `m_group_id` int(11) unsigned NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `bank_type` tinyint(4) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `usami_branch_code` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`partner_code`),
  KEY `user_id` (`user_id`),
  KEY `m_group_id` (`m_group_id`) USING BTREE,
  CONSTRAINT `m_partner_ibfk_1` FOREIGN KEY (`m_group_id`) REFERENCES `m_group` (`m_group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `m_post`
--

DROP TABLE IF EXISTS `m_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_post` (
  `post_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `note` varchar(100) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `m_media_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `m_media_id` (`m_media_id`) USING BTREE,
  CONSTRAINT `m_post_ibfk_1` FOREIGN KEY (`m_media_id`) REFERENCES `m_media` (`m_media_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `m_ss`
--

DROP TABLE IF EXISTS `m_ss`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_ss` (
  `ss_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ss_name` varchar(20) NOT NULL,
  `obic7_name` varchar(100) DEFAULT NULL,
  `edit_data` text,
  `original_sale` varchar(50) DEFAULT NULL,
  `base_code` varchar(7) DEFAULT NULL,
  `zipcode` varchar(7) NOT NULL,
  `addr1` tinyint(4) NOT NULL,
  `addr2` varchar(10) NOT NULL,
  `addr3` varchar(50) DEFAULT NULL,
  `tel` varchar(14) NOT NULL,
  `access` varchar(100) DEFAULT NULL,
  `station_name1` varchar(20) DEFAULT NULL,
  `station_walk_time1` int(4) DEFAULT NULL,
  `station_line1` varchar(20) DEFAULT NULL,
  `station_name2` varchar(20) DEFAULT NULL,
  `station_line2` varchar(20) DEFAULT NULL,
  `station_walk_time2` int(4) DEFAULT NULL,
  `station_name3` varchar(20) DEFAULT NULL,
  `station_line3` varchar(20) DEFAULT NULL,
  `station_walk_time3` int(4) DEFAULT NULL,
  `station1` varchar(50) DEFAULT NULL,
  `station2` varchar(50) DEFAULT NULL,
  `station3` varchar(50) DEFAULT NULL,
  `mark_info` varchar(100) DEFAULT NULL,
  `notes` varchar(500) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `is_available` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `partner_code` varchar(6) NOT NULL,
  PRIMARY KEY (`ss_id`),
  KEY `partner_code` (`partner_code`) USING BTREE,
  CONSTRAINT `m_ss_ibfk_1` FOREIGN KEY (`partner_code`) REFERENCES `m_partner` (`partner_code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `m_user`
--

DROP TABLE IF EXISTS `m_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) NOT NULL,
  `division_type` tinyint(4) NOT NULL,
  `name` varchar(100) NOT NULL,
  `login_id` varchar(8) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `mail` text,
  `pass` varchar(64) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `apply_date` date DEFAULT NULL,
  `post_date` date DEFAULT NULL,
  `agreement_type` int(11) DEFAULT NULL,
  `work_type` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `access` varchar(100) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `apply_reason` tinyint(4) DEFAULT NULL,
  `apply_detail` varchar(50) DEFAULT NULL,
  `request_people_num` int(11) DEFAULT NULL,
  `work_date` varchar(30) DEFAULT NULL,
  `work_time_of_month` int(11) DEFAULT NULL,
  `is_insurance` tinyint(4) NOT NULL,
  `holiday_work` tinyint(4) DEFAULT NULL,
  `require_des` varchar(30) DEFAULT NULL,
  `require_experience` varchar(30) DEFAULT NULL,
  `require_other` varchar(30) DEFAULT NULL,
  `require_age` varchar(30) DEFAULT NULL,
  `require_gender` varchar(30) DEFAULT NULL,
  `require_w` varchar(30) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `notes` varchar(500) DEFAULT NULL,
  `ss_list` varchar(255) DEFAULT NULL COMMENT 'Save fiel type ,2,3,4,5,',
  `author_user_id` int(11) DEFAULT NULL,
  `interview_user_id` int(11) DEFAULT NULL,
  `agreement_user_id` int(11) DEFAULT NULL,
  `training_user_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `image_content` mediumblob,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `mine_type` varchar(10) DEFAULT NULL,
  `create_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `ss_id` int(11) unsigned NOT NULL,
  `order_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `ss_id` (`ss_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`ss_id`) REFERENCES `m_ss` (`ss_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `partner_code`
--

DROP TABLE IF EXISTS `partner_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partner_code` (
  `ident` enum('H','J') NOT NULL,
  `seq_no` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`ident`,`seq_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `person` (
  `person_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `name_kana` varchar(20) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` tinyint(4) DEFAULT NULL,
  `zipcode` varchar(7) DEFAULT NULL,
  `addr1` tinyint(4) NOT NULL,
  `addr2` varchar(20) DEFAULT NULL,
  `addr3` varchar(50) DEFAULT NULL,
  `tel` varchar(14) DEFAULT NULL,
  `mobile` varchar(14) DEFAULT NULL,
  `mail_addr1` varchar(50) DEFAULT NULL,
  `mail_addr2` varchar(50) DEFAULT NULL,
  `occupation_now` tinyint(4) DEFAULT NULL,
  `repletion` varchar(100) DEFAULT NULL,
  `transportation` varchar(100) DEFAULT NULL,
  `walk_time` int(4) DEFAULT NULL,
  `work_type` varchar(100) DEFAULT NULL,
  `license1` varchar(50) DEFAULT NULL,
  `license2` varchar(50) DEFAULT NULL,
  `license3` varchar(50) DEFAULT NULL,
  `employment_time` varchar(50) DEFAULT NULL,
  `job_career` varchar(500) DEFAULT NULL,
  `self_pr` varchar(500) DEFAULT NULL,
  `notes` varchar(500) DEFAULT NULL,
  `application_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `job_id` int(11) unsigned DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `sssale_id` int(11) unsigned DEFAULT NULL,
  `reprinted_via` tinyint(4) DEFAULT NULL,
  `health` varchar(100) DEFAULT NULL,
  `is_failure_existence` tinyint(4) DEFAULT NULL,
  `failure_existence` varchar(50) DEFAULT NULL,
  `memo_1` text,
  `memo_2` text,
  `is_country` tinyint(4) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `edit_data` text,
  `interview_user_id` int(11) DEFAULT NULL,
  `business_user_id` int(11) DEFAULT NULL,
  `agreement_user_id` int(11) DEFAULT NULL,
  `training_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`person_id`),
  KEY `sssale_id` (`sssale_id`),
  KEY `person_ibfk_2` (`job_id`),
  CONSTRAINT `person_ibfk_1` FOREIGN KEY (`sssale_id`) REFERENCES `sssale` (`sssale_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `personfile`
--

DROP TABLE IF EXISTS `personfile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personfile` (
  `person_id` int(11) NOT NULL,
  `attr_id` int(11) NOT NULL,
  `content` mediumblob,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`person_id`,`attr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `plan`
--

DROP TABLE IF EXISTS `plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plan` (
  `start_date` date NOT NULL,
  `area_id` int(11) NOT NULL,
  `job_cost` int(11) DEFAULT NULL,
  `expenses` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`start_date`,`area_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `register`
--

DROP TABLE IF EXISTS `register`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `register` (
  `register_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `name_kana` varchar(50) NOT NULL,
  `birthday` date NOT NULL,
  `gender` tinyint(4) NOT NULL,
  `zipcode` varchar(7) NOT NULL,
  `addr1` tinyint(4) NOT NULL,
  `addr3` varchar(20) NOT NULL,
  `addr2` varchar(20) NOT NULL,
  `mobile_home` varchar(11) DEFAULT NULL,
  `mail2` varchar(50) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `occupation_now` tinyint(4) NOT NULL,
  `notes` text NOT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `status` tinyint(4) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  PRIMARY KEY (`register_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sssale`
--

DROP TABLE IF EXISTS `sssale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sssale` (
  `sssale_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sale_type` tinyint(4) DEFAULT NULL,
  `sale_name` varchar(100) DEFAULT NULL,
  `free_hourly_wage` int(11) DEFAULT NULL,
  `free_recruit_attr` varchar(20) DEFAULT NULL,
  `free_start_time` varchar(10) DEFAULT NULL,
  `free_end_time` varchar(10) DEFAULT NULL,
  `constraint_hourly_wage` int(11) DEFAULT NULL,
  `constraint_recruit_attr` varchar(20) DEFAULT NULL,
  `constraint_start_time` varchar(10) DEFAULT NULL,
  `constraint_end_time` varchar(10) DEFAULT NULL,
  `minor_hourly_wage` int(11) DEFAULT NULL,
  `minor_recruit_attr` varchar(20) DEFAULT NULL,
  `minor_start_time` varchar(10) DEFAULT NULL,
  `minor_end_time` varchar(10) DEFAULT NULL,
  `night_hourly_wage` int(11) DEFAULT NULL,
  `night_recruit_attr` varchar(20) DEFAULT NULL,
  `night_start_time` varchar(10) DEFAULT NULL,
  `night_end_time` varchar(10) DEFAULT NULL,
  `apply_start_date` date DEFAULT NULL,
  `apply_end_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `ss_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`sssale_id`),
  KEY `ss_id` (`ss_id`),
  CONSTRAINT `sssale_ibfk_1` FOREIGN KEY (`ss_id`) REFERENCES `m_ss` (`ss_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-11 17:41:17
